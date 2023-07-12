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


    /**
     * fungsi untuk mendapatkan data user yang daftar
     * menggunakan limit untuk jumlah pengambilannya
     */
    public function getUser(int $start = 0, int $limit = 10)
    {

        try {
            // dapatkan data user dari db
            // $query = 'SELECT id_user, id_auth, username, email, no_telp, name, profile_image FROM tb_user LIMIT :limit OFFSET :start';
            $query = 'SELECT id_user, id_auth, username, email, no_telp, name, profile_image FROM tb_user';
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
                    $user['username'],
                    $user['email'],
                    $user['no_telp'],
                    $user['name'],
                    $user['profile_image']
                );
            }

            return $dataUser;
        } catch (PDOException $e) {

            // dev
            var_dump($e->getMessage());
        }
    }
}
