<?php

namespace NextG\RwAdminApp\Services\AuthServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\Services\AuthServices\AuthServices;
use PDOException;

class AuthServiceImpl implements AuthServices
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function updateAuthAcces($id = '', $data = array())
    {
        if (empty($id) || empty($data)) {
            return false;
        }

        $query = 'UPDATE tb_access SET management = :management ,warga = :warga, estate_manager = :em, manager_kontraktor = :mg, kepala_contractor = :kepala_kon, cordinator = :korlap, danru = :danru, otp = :otp WHERE id_auth = :id';

        try {
            $this->db->startTransaction();

            $this->db->query($query);
            $this->db->bindData(':warga', $data['warga']);
            $this->db->bindData(':management', $data['management']);
            $this->db->bindData(':em', $data['estate_manager']);
            $this->db->bindData(':mg', $data['manager_kontraktor']);
            $this->db->bindData(':kepala_kon', $data['kepala_kontraktor']);
            $this->db->bindData(':korlap', $data['kordinator_lapangan']);
            $this->db->bindData(':danru', $data['danru']);
            $this->db->bindData(':otp', $data['otp']);
            $this->db->bindData(':id', $id);
            $result = $this->db->affectedRows();
            $this->db->commit();

            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();

            http_response_code(400);
            echo json_encode(array(
                'status' => 'failed',
                'message' => 'failed update access'
            ), JSON_PRETTY_PRINT);
            return;
        }
    }

    /**
     * dapatkan seluruh authentikasi yang ada
     */
    public function getAuth()
    {
        try {
            $query = 'SELECT auth.id_auth, auth.status, ac.id_access, ac.management, ac.warga, ac.estate_manager, ac.manager_kontraktor, ac.kepala_contractor, ac.danru, ac.cordinator, ac.otp, ac.master FROM tb_authorization AS auth INNER JOIN tb_access AS ac ON ac.id_auth = auth.id_auth';

            $this->db->query($query);
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}
