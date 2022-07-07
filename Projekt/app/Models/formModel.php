<?php

    class Model
    {

        public string $Name;
        public string $Email;
        public string $Tel;
        public string $Werkzeugname;
        public string $Dringlichkeit;

        /**
         * @var PDO
         */

        public $db;

        public function __construcht(string $Name, string $Email, string $tel, string $Werkzeugname, string $Dringlichkeit)
        {
            $this->Name = $Name;
            $this->Email = $Email;
            $this->Tel = $tel;
            $this->Werkzeugname = $Werkzeugname;
            $this->Dringlichkeit = $Dringlichkeit;

            $this->db = db();
        }

        public function create()
        {
            
            $fk = $this->db->prepare('SELECT WerkzeugID FROM werkzeug WHERE werkzeug.Name = :Werkzeugname');
            $fk->bindParam(':Werkzeugname', $this->Werkzeugname, PDO::PARAM_STR); 
            $fk->execute();
            
            if($this->Dringlichkeit == "sehr tief"){
                $AnzTage = 25;
            }
            elseif($this->Dringlichkeit == "tief"){
                $AnzTage = 20;
            } 
             elseif($this->Dringlichkeit == "normal"){
                $AnzTage = 15;
            }
            elseif($this->Dringlichkeit == "hoch"){
                $AnzTage = 10;
            }
            elseif($this->Dringlichkeit == "sehr hoch"){
                $AnzTage = 5;
            }

            $statement = $this->db->prepare("INSERT INTO auftrag(Name, Email, TelefonNr, Dringlichkeit, fk_WerkzeugID) 
            VALUES (:Name, :Email, :Telefon, :Dringlichkeit,".$fk.");");
            
            $statement->bindParam(':Name', $this->Name, PDO::PARAM_STR);
            $statement->bindParam(':Email', $this->Email, PDO::PARAM_STR);
            $statement->bindParam(':Telefon',$this->Tel, PDO::PARAM_STR);
            $statement->bindParam(':Dringlichkeit', $AnzTage);

            return $statement->execute();    
        }

        public function selectall() : array{

            
            $statement = $this->db->prepare("SELECT * FROM auftrag JOIN werkzeug ON werkzeug.WerkzeugID = auftrag.fk_WerkzeugID");
            $statement->execute();

            return $statement->fetchAll();
        }
        
        public function select(){
            
            $statement = $this->db->perpare('SELECT * FROM auftrag JOIN werkzeug ON werkzeug.Name = :Werkzeugname');
            $statement->bindParam(':Werkzeugname', $Werkzeugname);
            $statement->execute();

            return $statement->fetchAll();
        }
    }
?>