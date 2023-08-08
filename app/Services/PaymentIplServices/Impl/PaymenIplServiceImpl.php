<?php

namespace NextG\RwAdminApp\Services\PaymentIplServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\App\FirebaseMessaging;
use NextG\RwAdminApp\Services\PaymentIplServices\PaymentIplService;
use Webpatser\Uuid\Uuid;

class PaymenIplServiceImpl implements PaymentIplService
{

    private Database  $db;

    /**
     * @param Database $db
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    public function saveNotif(string $idUser, string $message) {
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

        }catch (\PDOException $e) {

            return 'failed save notif';

        }
    }





    public function update(string $id, string $status, $note) {
        try {
           $query = 'UPDATE tb_upload_ipl SET status = :status, note = :note WHERE id = :id';
           $this->db->query($query);
           $this->db->startTransaction();

           $this->db->bindData(':status', $status);
           $this->db->bindData(':id', $id);
           $this->db->bindData(':note', $note);
           $result = $this->db->affectedRows();



            // dapatkan id user
            $query = 'SELECT id_user FROM tb_upload_ipl WHERE id = :id';
            $this->db->query($query);
            $this->db->bindData(':id', $id);
            $idUser = $this->db->fetch()['id_user'];



            $resultSaveNotif = $this->saveNotif($idUser, $note);

            if($resultSaveNotif == 'failed save notif') {
                http_response_code(400);
                echo json_encode(array('status' => 'failed', 'message' => 'gagal simpan notif hubungi administrator'));
                $this->db->rollBack();
                return;
            }

            //  Kirim notif firebase
            $query = 'SELECT token FROM tb_user_fcm_token WHERE id_user = :id';
            $this->db->query($query);
            $this->db->bindData(':id', $idUser);
            $resultToken = $this->db->fetch();

            if($resultToken != null) {
                $token = $resultToken['token'];
                FirebaseMessaging::sendNotif($token, 'Status Pengambilan Plastik Sampah', $note);
            }

           $this->db->commit();
           http_response_code(200);
           echo json_encode(array('status' => 'success', 'message' => 'berhasil update status'));
           return;


        }catch (\PDOException $e) {
            $this->db->rollBack();
            http_response_code(400);
            echo json_encode(array('status' => 'failed', 'message' => 'gagal update status'));
        }
    }


    public function getData() {
        try {
            $query = 'SELECT i.id, i.id_user, i.image, i.periode, i.status, i.create_at, u.username, u.email, u.no_telp, u.name FROM tb_upload_ipl AS i INNER JOIN tb_user AS u ON u.id_user = i.id_user WHERE i.status NOT IN ("Ditolak") ORDER BY create_at DESC';
            $this->db->query($query);
            $result = $this->db->fetchAll();

            if($result == null || empty($result)) {
                return 'data kosong';
            }

            return $result;

        }catch (\PDOException $e) {
            var_dump($e->getMessage());
        }

    }
}
