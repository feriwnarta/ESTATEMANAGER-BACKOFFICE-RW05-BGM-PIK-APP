<?php

namespace NextG\RwAdminApp\Services\UserServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\Entity\User;
use NextG\RwAdminApp\Services\UserServices\UserService;
use PDOException;
use Webpatser\Uuid\Uuid;

class UserServiceImpl implements UserService
{

    private $db;



    public function __construct()
    {
        $this->db = new Database;
    }

    public function saveEmployee()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if (!isset($obj) && empty($obj)) {
            http_response_code(400);
            echo json_encode('parameter empty', JSON_PRETTY_PRINT);
            return;
        }


        $username = $obj['username'];
        $name = $obj['name'];
        $email = $obj['email'];
        $phoneNumber = $obj['phoneNumber'];
        $idPosition = $obj['bagian'];
        $password = $obj['password'];
        $divisi = $obj['divisi'];


        /**
         * password hashing
         */
        $ubah1 = str_replace("=", "", base64_encode($password));
        $pengacak = "Bl4ck3rH4ck3r3ncR1pt";
        $ubah2 = md5($pengacak . md5($ubah1) . $pengacak);
        $hasil_password = md5($pengacak . md5($ubah2) . $pengacak);


        $division = '';
        $idMasterCategory = '';
        $scope = '';
        $unit = '';

        if ($divisi == 'radioPerawatanLanskap') {
            $scope = 'Landscape';
            $unit = 'Pertamanan, kebersihan, dan clubhouse';
        } else if ($divisi == 'radioMekanikelElektrikel') {
            $scope = 'ME & Perawatan kolam renang';
            $unit = 'ME, INFRA dan kolam renang';
        } else if ($divisi == 'radioBuildingControll') {
            $scope = 'Building controll dan perizinan';
            $unit = 'Building Control dan security';
        } else if ($divisi == 'radioMasalahkemanan') {
            $scope = 'Kemanan / Security';
            $unit = 'Building Control dan security';
        } else {
            $this->failedResponse("unit not exist", "failed");
        }


        try {
            $this->db->startTransaction();

            // simpan employee landscape
            $queryDivisionLandscape = "SELECT id_division, divisi FROM tb_division WHERE divisi IN ('{$scope}')";

            $this->db->query($queryDivisionLandscape);
            $division = $this->db->fetch();

            if (empty($division)) {
                $this->failedResponse("division not exist", "failed");
                return;
            }

            $idMasterCategory = $this->getIdMasterCategory($unit);

            if (empty($idMasterCategory)) {
                $this->failedResponse("id master not exist", "failed");
                return;
            }

            $idMasterCategory = $idMasterCategory['id_master_category'];

            $idUser = Uuid::generate()->string;
            $position = $this->getPositionName($idPosition);

            if (empty($position)) {
                $this->failedResponse("position not exist", "failed");
                return;
            }

            $position = $position['position'];

            $idAuth = $this->getIdAuth($position);

            if (empty($idAuth)) {
                $this->failedResponse("auth not exist", "failed");
                return;
            }

            $idAuth = $idAuth['id_auth'];


            if ($idAuth == '' || $idAuth == null) {
                $this->failedResponse("auth not exist", "failed");
                return;
            }


            $usernameExist = $this->checkValidUser($username, $email, $phoneNumber);

            if ($usernameExist['count'] > 0) {
                $this->failedResponse("username or email or phone number exist", "failed");
                return;
            }


            $resultSaveUser = $this->saveUser($idUser, $idAuth, $email, $username, $phoneNumber, $name, $hasil_password);


            if ($resultSaveUser == 0) {
                $this->failedResponse("failed save user", "failed");
                return;
            }

            // insert notification
            $idNotification = Uuid::generate()->string;
            $resultSaveNotif = $this->saveNotification($idNotification, $idUser);

            if ($resultSaveNotif == 0) {
                $this->failedResponse("failed save notification", "failed");
                return;
            }


            $idDivision = $division['id_division'];
            $idJob = Uuid::generate()->string;

            $resultSaveEmployee = $this->saveLandscapeEmployee($idUser, $email, $name, $phoneNumber, $idPosition, $idDivision, $idJob);


            if ($resultSaveEmployee == 0) {
                $this->failedResponse("failed save employee", "failed");
                return;
            }

            $resultSaveEmlpoyeeJob = $this->saveEmployeeJob($idJob, $idUser, $position, $idMasterCategory);

            if ($resultSaveEmlpoyeeJob == 0) {
                $this->failedResponse("failed save employee job", "failed");
                return;
            }

            $this->db->commit();

            // success Message 
            $this->successResponse("success create user", "success");
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(
                array(
                    "message" => "failed save data"
                ),
                JSON_PRETTY_PRINT
            );

            $this->db->rollBack();


            die();
        }
    }

    private function saveNotification($idNotification, $idUser) {
        $query = 'INSERT INTO tb_settings_notification (id_notification, id_user) VALUES (:id_notif, :id_user)';
        $this->db->query($query);
        $this->db->bindData(':id_notif', $idNotification);
        $this->db->bindData(':id_user', $idUser);
        return $this->db->affectedRows();
    }


    private function successResponse($message, $status)
    {
        http_response_code(200);
        echo json_encode(
            array(
                "status" => $status,
                "message" => $message
            ),
            JSON_PRETTY_PRINT
        );
    }

    private function failedResponse($message, $status)
    {
        http_response_code(400);
        echo json_encode(
            array(
                "status" => $status,
                "message" => $message
            ),
            JSON_PRETTY_PRINT
        );
    }

    private function getIdMasterCategory($unit)
    {

        $query = 'SELECT id_master_category FROM tb_master_category WHERE unit = :unit';
        $this->db->query($query);
        $this->db->bindData(':unit', $unit);
        return $this->db->fetch();
    }

    private function saveEmployeeJob($idJob, $idEmployee, $type, $idMaster)
    {
        $query = 'INSERT INTO tb_employee_job (id_employee_job, id_employee, type, id_master_category) VALUES (:id_job, :id_employee, :type, :id_master)';
        $this->db->query($query);
        $this->db->bindData(':id_job', $idJob);
        $this->db->bindData(':id_employee', $idEmployee);
        $this->db->bindData(':type', $type);
        $this->db->bindData(':id_master', $idMaster);
        return $this->db->affectedRows();
    }


    private function checkValidUser($username, $email, $no_telp)
    {
        $query = 'SELECT count( username ) AS count FROM tb_user WHERE username = :username OR email = :email OR no_telp = :no_telp';
        $this->db->query($query);
        $this->db->bindData(':username', $username);
        $this->db->bindData(':email', $email);
        $this->db->bindData(':no_telp', $no_telp);
        return $this->db->fetch();
    }

    private function saveUser($idUser, $idAuth, $email, $username, $noTelp, $name, $password)
    {

        $query = 'INSERT INTO tb_user (id_user, id_auth, username, email, no_telp, name, password) VALUES (:id_user, :id_auth, :username, :email, :no_telp, :name, :password)';


        $this->db->query($query);
        $this->db->bindData(':id_user', $idUser);
        $this->db->bindData(':id_auth', $idAuth);
        $this->db->bindData(':email', $email);
        $this->db->bindData(':username', $username);
        $this->db->bindData(':no_telp', $noTelp);
        $this->db->bindData(':name', $name);
        $this->db->bindData(':password', $password);
        $result = $this->db->affectedRows();


        return $result;
    }

    private function getIdAuth($position)
    {
        $query = 'SELECT id_auth FROM tb_authorization WHERE status = :status';
        $this->db->query($query);
        $this->db->bindData(':status', $position);
        return $this->db->fetch();
    }

    private function getPositionName($idPosition)
    {

        $query = 'SELECT position FROM tb_position WHERE id_position = :id_position';
        $this->db->query($query);
        $this->db->bindData(':id_position', $idPosition);
        return $this->db->fetch();
    }

    private function saveLandscapeEmployee($idEmployee, $email, $name, $phoneNumber, $idPosition, $idDivision, $idJob)
    {


        // insert employe
        $queryInsertEmployee = 'INSERT INTO tb_employee (id_employee, name, email, no_telp, id_position, id_division, id_job) VALUES (:id_employee, :name, :email, :no_telp, :id_position, :id_division, :id_job)';

        $this->db->query($queryInsertEmployee);
        $this->db->bindData(':id_employee', $idEmployee);
        $this->db->bindData(':email', $email);
        $this->db->bindData(':name', $name);
        $this->db->bindData(':no_telp', $phoneNumber);
        $this->db->bindData(':id_position', $idPosition);
        $this->db->bindData(':id_division', $idDivision);
        $this->db->bindData(':id_job', $idJob);

        $result = $this->db->affectedRows($queryInsertEmployee);


        return $result;
    }

    public function getPositionSecurity()
    {
        $query = 'SELECT id_position, position FROM tb_position WHERE position IN ("Danru")';
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    public function getPositionBuildingControll()
    {
        $query = 'SELECT id_position, position FROM tb_position WHERE position IN ("Supervisor / Estate Koordinator")';
        $this->db->query($query);
        return $this->db->fetchAll();
    }


    public function getPositionMekanikelElektrikel()
    {
        $query = 'SELECT id_position, position FROM tb_position WHERE position IN ("Teknisi", "Supervisor / Estate Koordinator")';
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    public function getPositionLandscape()
    {
        $query = 'SELECT id_position, position FROM tb_position WHERE position NOT IN ("Teknisi", "Danru")';
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    public function updateUser($idUser, $data)
    {

        if (empty($data)) {
            return 0;
        }

        try {
            $this->db->startTransaction();

            $query = 'UPDATE tb_user SET username = :username, email = :email, no_telp = :no_telp, name = :name, id_auth = :id_auth WHERE id_user = :id_user';
            $this->db->query($query);
            $this->db->bindData(':username', $data['username']);
            $this->db->bindData(':email', $data['email']);
            $this->db->bindData(':no_telp', $data['no_telp']);
            $this->db->bindData(':name', $data['name']);
            $this->db->bindData(':id_auth', $data['id_auth']);
            $this->db->bindData(':id_user', $data['id_user']);

            $rs = $this->db->affectedRows();
            $this->db->commit();
            return $rs;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // var_dump($e->getMessage());
            return null;
        }
    }

    public function getAllStatus()
    {
        $query = 'SELECT * FROM tb_authorization';
        try {

            $this->db->query($query);
            $rs = $this->db->fetchAll();

            if (empty($rs) || $rs == null) {
                return [];
            }

            return $rs;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function detailUser($idUser)
    {

        $query = 'SELECT u.id_user, u.username, u.email, u.no_telp, u.name, u.password, u.profile_image, u.id_auth, a.status FROM tb_user AS u INNER JOIN tb_authorization AS a ON u.id_auth = a.id_auth WHERE id_user = :idUser';

        try {

            $this->db->query($query);
            $this->db->bindData(':idUser', $idUser);

            $user = $this->db->fetch();

            if ($user == null || empty($user)) {
                return [];
            }

            return $user;
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'failed',
                )
            );
            var_dump($e->getMessage());
            return;
        }
    }


    /**
     * fungsi untuk menghapus user berdasarkan id
     */
    public function deleteUser(string $idUser)
    {
        $rs = false;

        $query = 'DELETE FROM tb_user WHERE id_user = :idUser';

        try {
            $this->db->startTransaction();
            $this->db->query($query);
            $this->db->bindData(':idUser', $idUser);
            $rs = $this->db->affectedRows();
            $this->db->commit();
            return $rs;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return $rs;
            var_dump($e->getMessage());
        }
    }


    /**
     * fungsi untuk mendapatkan data user yang daftar
     * menggunakan limit untuk jumlah pengambilannya
     */
    public function getUser(int $start = 0, int $limit = 10)
    {

        try {
            // dapatkan data user dari db
            // $query = 'SELECT id_user, id_auth, username, email, no_telp, name, profile_image FROM tb_user LIMIT :limit OFFSET :start';
            $query = 'SELECT u.id_user, a.status, u.username, u.email, u.no_telp, u.id_auth, u.name, u.profile_image FROM tb_user AS u INNER JOIN tb_authorization AS a ON u.id_auth = a.id_auth';
            $this->db->query($query);
            // $this->db->bindData(':limit', $limit);
            // $this->db->bindData(':start', $start);

            $users =  ($this->db->fetchAll() == null) ? [] : $this->db->fetchAll();

            // jika user kosong, maka balikan array kosong
            if ($users == null) return [];

            $dataUser = array();

            foreach ($users as $user) {
                $dataUser[] = new User(
                    $user['id_user'],
                    $user['id_auth'],
                    $user['status'],
                    $user['username'],
                    $user['email'],
                    $user['no_telp'],
                    $user['name'],
                    $user['profile_image'],
                );
            }

            return $dataUser;
        } catch (PDOException $e) {

            // dev
            var_dump($e->getMessage());
        }
    }
}
