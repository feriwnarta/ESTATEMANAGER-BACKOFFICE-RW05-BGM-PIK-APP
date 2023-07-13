<?php

namespace NextG\RwAdminApp\Services\UserServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\Entity\User;
use NextG\RwAdminApp\Services\UserServices\UserService;
use PDOException;

class UserServiceImpl implements UserService
{

    private $db;


    public function __construct()
    {
        $this->db = new Database;
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
