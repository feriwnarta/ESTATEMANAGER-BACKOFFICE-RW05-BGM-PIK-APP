<?php

namespace NextG\RwAdminApp\Services\AuthServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\Services\AuthServices\LoginServices;

class LoginServicesImpl implements LoginServices
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function login(string $username, string $password) {

        $ubah1 = str_replace("=", "", base64_encode($password));
        $pengacak = "Bl4ck3rH4ck3r3ncR1pt";
        $ubah2 = md5($pengacak . md5($ubah1) . $pengacak );
        $hasil_password = md5($pengacak . md5($ubah2) . $pengacak );



        try {
            $query = 'SELECT u.id_user, u.username, u.email, au.status FROM tb_user AS u INNER JOIN tb_authorization AS au ON au.id_auth = u.id_auth WHERE username = :username AND password = :password AND  au.status IN ("KETUA RW", "ADMIN", "MANAGEMENT", "MASTER AKUN")';
            $this->db->query($query);
            $this->db->bindData(':username', $username);
            $this->db->bindData(':password', $hasil_password);
            $idUser = $this->db->fetch();




            if($idUser != null && !empty($idUser)) {

                // set session
                $_SESSION['user_must_log'] = 'log';
                $_SESSION['id_user'] = $idUser['id_user'];

                if(isset($_SESSION['error'])) {
                    unset($_SESSION['error']);
                }



                header('Location: users');
                return;


            }

            $_SESSION['error']  = 'Username atau password salah';
            header('Location: login');


        }catch (\PDOException $e) {
            echo json_encode(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

}