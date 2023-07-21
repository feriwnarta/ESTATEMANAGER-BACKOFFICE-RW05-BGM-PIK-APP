<?php

namespace NextG\RwAdminApp\Services\AuthServices\Impl;

use NextG\RwAdminApp\App\Database;
use NextG\RwAdminApp\Services\AuthServices\AuthServices;
use PDOException;
use Webpatser\Uuid\Uuid;

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
            $query = 'SELECT auth.id_auth, auth.status, ac.id_access, ac.management, ac.warga, ac.estate_manager, ac.manager_kontraktor, ac.kepala_contractor, ac.danru, ac.cordinator, ac.otp FROM tb_authorization AS auth INNER JOIN tb_access AS ac ON ac.id_auth = auth.id_auth';

            $this->db->query($query);
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getAccess(): array
    {

        $access = array(
            [
                'id' => 'idWarga',
                'status' => 'Warga'
            ],
            [
                'id' => 'idManagement',
                'status' => 'Management'
            ],
            [
                'id' => 'idEstateManager',
                'status' => 'Esate manager'
            ],
            [
                'id' => 'idManagerKontraktor',
                'status' => 'Manager Kontraktor'
            ],
            [
                'id' => 'idKepalaKontraktor',
                'status' => 'Kepala Kontraktor'
            ],
            [
                'id' => 'idKordinatorLapangan',
                'status' => 'Kordinator Lapangan'
            ],
            [
                'id' => 'idDanru',
                'status' => 'Danru'
            ],
            [
                'id' => 'idOtp',
                'status' => 'OTP'
            ],
        );

        return $access;
    }

    public function addAuth($obj)
    {
        $status = $obj['status'];
        $access = $obj['access'];
        $idAuth = Uuid::generate()->string;
        $idAccess = Uuid::generate()->string;

        try {
            $this->db->startTransaction();

            $authStatus = $this->checkAuthName($status);
            if ($authStatus != null || !empty($authStatus)) {
                $authStatus = $authStatus['total'];

                if ($authStatus > 0) {
                    $this->failedResponse('auth status exist', 'failed');
                    return;
                }

            }

            $resultSaveAuth = $this->saveAuth($idAuth, $status);
            if ($resultSaveAuth == 0) {
                $this->failedResponse('failed save auth', 'failed');
                return;
            }

            $buildQuery = $this->buildQuery($access);
            if (empty($buildQuery) || $buildQuery == null) {
                $this->failedResponse('error build query', 'failed');
                return;
            }

            $resultSaveAuth = $this->saveAccess($idAccess, $idAuth, $buildQuery);
            if ($resultSaveAuth == 0) {
                $this->failedResponse('There is no data to be saved', 'failed');
                return;
            }

            $this->db->commit();
            $this->successResponse('success save auth', 'success');

        } catch (PDOException $e) {
            $this->db->rollBack();
        }

    }

    private function checkAuthName($status)
    {

        try {
            $query = 'SELECT COUNT(id_auth) as total FROM tb_authorization WHERE status = :status';
            $this->db->query($query);
            $this->db->bindData(':status', $status);
            return $this->db->fetch();
        } catch (PDOException $e) {
            $this->failedResponse('failed check auth error query', 'failed');
            die();
        }


    }

    private function saveAccess($idAccess, $idAuth, $buildQuery)
    {
        try {
            $query = 'INSERT INTO tb_access SET id_access = :id_access, id_auth = :id_auth ,' . $buildQuery;

            $this->db->query($query);
            $this->db->bindData(':id_access', $idAccess);
            $this->db->bindData(':id_auth', $idAuth);
            $resultSaveAuth = $this->db->affectedRows();
            return $resultSaveAuth;

        } catch (PDOException $e) {

            $this->failedResponse('failed save access error query', 'failed');
            die();

        }


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

    private function saveAuth($idAuth, $status)
    {

        try {

            $query = 'INSERT INTO tb_authorization (id_auth, status) VALUES (:id, :status)';
            $this->db->query($query);
            $this->db->bindData(':id', $idAuth);
            $this->db->bindData(':status', $status);
            $resultSaveAuth = $this->db->affectedRows();
            return $resultSaveAuth;
        } catch (PDOException $exception) {
            $this->failedResponse('failed save auth error query', 'failed');
            die();
//            var_dump($exception->getMessage());
        }

    }

    private function buildQuery($dataAccess)
    {
        $queryParts = array();

        foreach ($dataAccess as $access) {
            switch ($access) {
                case 'idWarga':
                    $queryParts[] = 'warga = 1';
                    break;
                case 'idManagement':
                    $queryParts[] = 'management = 1';
                    break;
                case 'idEstateManager':
                    $queryParts[] = 'estate_manager = 1';
                    break;
                case 'idManagerKontraktor':
                    $queryParts[] = 'manager_kontraktor = 1';
                    break;
                case 'idKepalaKontraktor':
                    $queryParts[] = 'kepala_kontraktor = 1';
                    break;
                case 'idDanru':
                    $queryParts[] = 'danru = 1';
                    break;
                case 'idOtp':
                    $queryParts[] = 'otp = 1';
                    break;
                default:
                    break;
            }
        }

        return implode(', ', $queryParts);
    }


}
