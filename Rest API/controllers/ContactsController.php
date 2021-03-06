<?php
class ContactsController
{

    var $ClientModel;
    var $UserController;

    public function __construct() //nao permite que tu volte para a mesma pagina e pede login de novo, ele chama automaticamente o __construct
    {
        require_once('models/ContactsModel.php');
        $this->ClientModel = new ContactsModel();
        require_once('controllers/UsersController.php');
        $this->UserController = new UsersController();
    }


    public function listContacts()
    {
        if ($this->UserController->isAdmin()) {
            $this->ClientModel->getContacts();
            $result = $this->ClientModel->getConsult();

            $arrayClients = array();

            while ($line = $result->fetch_assoc()) {
                array_push($arrayClients, $line);
            }

            header('Content-Type: application/json');
            echo json_encode($arrayClients);
        } else {
            header('Content-Type: application/json');
            echo json_encode('{"acess" : "denied"}');
        }
    }

    public function listContact($idClient)
    {
        if ($this->UserController->isAdmin()) {
            $this->ClientModel->getContact($idClient);
            $result = $this->ClientModel->getConsult();

            $arrayClients = array();

            while ($line = $result->fetch_assoc()) {
                array_push($arrayClients, $line);
            }

            header('Content-Type: application/json');
            echo json_encode($arrayClients);
        }
    }

    public function insertContact()
    {
            $client = json_decode('file_get_contents'('php://input'));

            $arrayClient['name'] = $client->name;
            $arrayClient['email'] = $client->email;
            $arrayClient['message'] = $client->message;

            $this->ClientModel->insertContact($arrayClient);
            $idClient = $this->ClientModel->getConsult();

            header('Content-Type: application/json');
            echo ('{"result" : "true"}');
    }
    
}
