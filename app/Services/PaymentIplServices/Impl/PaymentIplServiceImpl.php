<?php

namespace NextG\RwAdminApp\Services\PaymentIplServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\App\FirebaseMessaging;
use NextG\RwAdminApp\Services\PaymentIplServices\PaymentIplService;
use Webpatser\Uuid\Uuid;

class PaymentIplServiceImpl implements PaymentIplService
{

    private Database  $db;

    /**
     * @param Database $db
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    public function saveNotif(string $idUser, string $message)
    {
        $idNotif = Uuid::generate()->string;

        try {
            $query = 'INSERT INTO tb_notification (id_notification, id_user, type, title, content) VALUES (:id_notification, :id_user, :type, :title, :content)';
            $this->db->query($query);
            $this->db->startTransaction();

            $this->db->bindData(':id_notification', $idNotif);
            $this->db->bindData(':id_user', $idUser);
            $this->db->bindData(':type', 'PAYMENT STATUS');
            $this->db->bindData(':title', 'Status Pengambilan Plastik Sampah');
            $this->db->bindData(':content', $message);
            $rs = $this->db->affectedRows();

            return $rs;
        } catch (\PDOException $e) {

            return 'failed save notif';
        }
    }

    public function update(string $id, string $status, string $note, array $file)
    {
        try {
            $fileName = '';

            if ($file != []) {
                // Generate a unique name for the compressed image
                $fileName = uniqid() . '_' . basename($file['name']);
                $targetDir = __DIR__ . '/../../../../public/delivery_proof/';
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check file size (you can set a maximum file size)
                if ($file["size"] > 5000000) {
                    http_response_code(400);
                    echo json_encode(array('status' => 'failed', 'message' => 'Ukuran gambar terlalu besar harap upload gambar dibawah ukuran 5MB'));
                    return;
                }


                if (!$this->compressAndSaveImage($file['tmp_name'], $targetDir . $fileName, $imageFileType)) {
                    http_response_code(400);
                    echo json_encode(array('status' => 'failed', 'message' => 'Gagal mengompres dan mengunggah file.'));
                    return;
                }

                $fileName  = 'delivery_proof/' . $fileName;
            }

            // Lanjutkan dengan pembaruan status di database
            $updateAt = date("Y-m-d H:i:s");
            
            $query = 'UPDATE tb_upload_ipl SET status = :status, note = :note, update_at = :update, delivery_proof = :proof WHERE id = :id';
            $this->db->query($query);
            $this->db->startTransaction();

            $this->db->bindData(':status', $status);
            $this->db->bindData(':id', $id);
            $this->db->bindData(':note', $note);

            $this->db->bindData(':proof', $fileName);
            $this->db->bindData(':update', $updateAt);
            $result = $this->db->affectedRows();

            // Dapatkan id user
            $query = 'SELECT id_user FROM tb_upload_ipl WHERE id = :id';
            $this->db->query($query);
            $this->db->bindData(':id', $id);
            $idUser = $this->db->fetch()['id_user'];

            $resultSaveNotif = $this->saveNotif($idUser, $note);

            if ($resultSaveNotif == 'failed save notif') {
                http_response_code(400);
                echo json_encode(array('status' => 'failed', 'message' => 'Gagal menyimpan notifikasi, hubungi administrator'));
                $this->db->rollBack();
                return;
            }

            // Kirim notifikasi Firebase
            $query = 'SELECT token FROM tb_user_fcm_token WHERE id_user = :id';
            $this->db->query($query);
            $this->db->bindData(':id', $idUser);
            $resultToken = $this->db->fetch();

            if ($resultToken != null) {
                $token = $resultToken['token'];
                FirebaseMessaging::sendNotif($token, 'Status Pengambilan Plastik Sampah', $note);
            }

            $this->db->commit();
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'message' => 'Berhasil memperbarui status'), JSON_PRETTY_PRINT);
            return;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            http_response_code(400);
            echo json_encode(array('status' => 'failed', 'message' => 'Gagal memperbarui status'));
        }
    }

    private function compressAndSaveImage($sourcePath, $destinationPath, $fileType)
    {
        if ($fileType == "jpeg" || $fileType == "jpg") {
            $image = imagecreatefromjpeg($sourcePath);
            // Sesuaikan level kompresi (0-100) sesuai kebutuhan
            imagejpeg($image, $destinationPath, 80); // 80 adalah contoh level kompresi
        } elseif ($fileType == "png") {
            $image = imagecreatefrompng($sourcePath);
            // Sesuaikan level kompresi (0-9) sesuai kebutuhan
            imagepng($image, $destinationPath, 6); // 6 adalah contoh level kompresi
        }

        return is_file($destinationPath);
    }



    public function getData()
    {
        try {
            $query = 'SELECT i.id, i.id_user, i.delivery_proof, i.image, i.periode, i.latitude, i.longitude, i.status, i.create_at, u.username, u.email, u.no_telp, u.name FROM tb_upload_ipl AS i INNER JOIN tb_user AS u ON u.id_user = i.id_user WHERE i.status NOT IN ("Ditolak") ORDER BY i.create_at ASC';
            $this->db->query($query);
            $result = $this->db->fetchAll();

            if ($result == null || empty($result)) {
                return 'data kosong';
            }

            return $result;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
