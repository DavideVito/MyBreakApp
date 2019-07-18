<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Connessione {

    private $connessione = null;

    public function disconnetti() {
        $this->connessione = null;
    }
    
    public function __construct() {
        try {
            $host = "localhost";
            $dataBase = "MyBreakApp";
            $uid = "Admin";
            $pwd = "Password";
            $this->connessione = new PDO("mysql:host=$host;dbname=$dataBase", $uid, $pwd);
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die(); // Lo script termina
        }
    }

    public function getScuole() {
        $sql = "SELECT * FROM Scuola";
        $stm = $this->connessione->prepare($sql);
        $esito = $stm->execute();
        if ($esito == 1) {
            $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $ris;
        }
        
        return null;
    }
    
    public function getSedi($idScuola) {
        $sql = "SELECT * FROM Sede INNER JOIN Scuola using (IDScuola) where Sede.IDScuola = $idScuola";
        $stm = $this->connessione->prepare($sql);
        $esito = $stm->execute();
        if ($esito == 1) {
            $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $ris;
        }
        
        return null;
    }
    
    public function getClassi($idSede, $idScuola) {
        $sql = "SELECT * FROM Classe INNER JOIN Sede using (IDSede) INNER JOIN Scuola using (IDScuola) where Sede.IDScuola = $idScuola and Classe.IDSede = $idSede";
        $stm = $this->connessione->prepare($sql);
        $esito = $stm->execute();
        if ($esito == 1) {
            $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $ris;
        }
        
        return null;
    }

    public function inserisciUtente($username, $nome, $cognome, $password, $idClasse, $tipoUtente = "S") {
        
        $sql = "INSERT INTO `Utente`(`Username`, `Nome`, `Cognome`, `Password`, `IDClasse`, `TipoUtente`) VALUES (:username, :nome, :cognome, :password, :idclasse, :tipoutente)";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":username", $username, PDO::PARAM_STR);
        $stm->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stm->bindParam(":cognome", $cognome, PDO::PARAM_STR);
        $password = hash("sha512", $password);
        $stm->bindParam(":password", $password, PDO::PARAM_STR);
        $stm->bindParam(":idclasse", $idClasse, PDO::PARAM_INT);
        $stm->bindParam(":tipoutente", $tipoUtente, PDO::PARAM_STR);

        $esito = $stm->execute();
        return $esito;
    }

    public function logga($username, $password) {
        $sql = "SELECT * from Utente where Utente.Username = :username and Utente.Password = :password";

        $stm = $this->connessione->prepare($sql);
        
        $stm->bindParam(":username", $username, PDO::PARAM_STR);
        $stm->bindParam(":password", $password, PDO::PARAM_STR);
        
        $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $ris;
    }

    public function ottieniPanini($IDScuola) {
        $sql = "SELECT * from Panino where Panino.IDScuola = :IDScuola";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":IDScuola", $IDScuola, PDO::PARAM_INT);

        $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ris;
    }
    
    public function ottieniSede($idUtente) {
        $sql = "SELECT Sede.IDSede FROM Classe inner join Sede using (IDSede) inner join Utente using (IDClasse) where Utente.IDUtente = :idUtente";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idUtente", $idUtente, PDO::PARAM_INT);

        $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ris;
    }
    
    function ottieniPaniniPaninara($idSede, $idScuola) {
        $sql  = 'select Panino.IDPanino, COUNT(*) as Qta, Classe.Sezione, Panino.Nome, Panino.Prezzo, Ordine.IDOrdine, Ordine.IDUtente from Ordine inner join Utente using (IDUtente) inner join Classe using (IDClasse) inner join Sede using (IDSede) inner join Scuola using (IDScuola) inner join Panino using (IDPanino) where (Sede.IDSede = :idsede and Scuola.IDScuola = :idscuola) GROUP by IDPanino, IDClasse';
        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idsede", $idSede, PDO::PARAM_INT);
        $stm->bindParam(":idscuola", $idScuola, PDO::PARAM_INT);

        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ottieniScuolaDaClasse($idClasse) {
        $sql = "SELECT * from Scuola INNER join Sede using (IDScuola) inner join Classe using (IDSede) inner join Utente using (IDClasse) where Utente.IDClasse = :idClasse";


        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idClasse", $idClasse, PDO::PARAM_INT);

        $esisto = $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ris[0]['IDScuola'];
    }

    function aggiungiPanino($idPanino, $idUtente) {
        $sql = "INSERT INTO `Ordine`(`IDUtente`, `IDPanino`) VALUES (:idutente, :idpanino)";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idpanino", $idPanino, PDO::PARAM_INT);
        $stm->bindParam(":idutente", $idUtente, PDO::PARAM_INT);
        
        $esito = $stm->execute();
        return $esito;
    }

    function getScuola($idClasse)
    {
        $sql  = "SELECT * FROM Scuola\n"

                . "inner join Sede using (IDScuola)\n"

                . "inner JOIN Classe USING (IDSede)\n"

                . "where Classe.IDClasse = :idclasse";
        
        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idclasse", $idClasse, PDO::PARAM_INT);

        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_ASSOC)[0]['IDScuola'];
    }
    
    function rimuoviOrdine($idOrdine, $idSede, $idScuola)
    {
        $sql = "DELETE FROM `Ordine` WHERE `Ordine`.`IDOrdine` = :id";
        
        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":id", $idOrdine, PDO::PARAM_INT);

        $stm->execute();
        
        return $this->ottieniPaniniPaninara($idSede, $idScuola);
        
    }
    
    function ottieniScuolaSedeClassi()
    {
        $scuole = $this->getScuole();
        return json_encode($scuole);
    }
    
    

    

}
