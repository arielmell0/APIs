<?php

    class ContactsModel{
        var $result;
        var $conn;

        public function __construct()
        {
            require_once('database/ConnectClass.php');
            $Oconn = new connectClass();
            $Oconn -> openConnect();
            $this -> conn = $Oconn ->getConn();

        }
        public function getContacts() {
 
            $sql = 'SELECT * FROM contacts order by idContact';

            $this -> result = $this -> conn -> query($sql);

        }

        public function insertContact($arrayClient) //inseir dados no array do banco
        {
            $sql = "
                INSERT INTO contacts
                    (name, email, message)
                VALUES(
                    '{$arrayClient['name']}',
                    '{$arrayClient['email']}',
                    '{$arrayClient['message']}'
                )
            ";

            $this -> conn -> query($sql);
            $this -> result = $this -> conn -> insert_id;
        }

        public function getContact($idContact)
        {
            $sql = "
                SELECT * FROM contacts 
                WHERE idContact = {$idContact}
            ";
            $this -> result = $this -> conn -> query($sql);
        }

        public function getConsult(){
            return $this -> result;
        }
        
    }