<?php

require_once __DIR__ . '/../config/connexion_db.php';
require_once __DIR__ . '/../model/admin/admin.php';

class AdminController {
    private $db;
    private $adminModel;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->adminModel = new Admin($this->db);
    }

    public function createTable() {
        try {
            $this->adminModel->createTable();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $this->db = null; 
        }
    }

    public function afficheAdmin(){
        try{
            $affichage=$this->adminModel->getAdmin();
            return $affichage;
        }catch(Exception $e){
            echo $e->getMessage();
        } finally {
            $this->db = null; 
        }
    }
    public function addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image = null) {
        try {
            $this->adminModel->addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $this->db = null;
        }
    }

    public function deleteAdmin($email) {
        try {
            $this->adminModel->deleteAdmin($email);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $this->db = null;
        }
    }
}

?>
