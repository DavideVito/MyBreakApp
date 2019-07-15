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

    public function cercaAmico($nomeUtenteAmico) {
        $sql = "SELECT IDUtente from Utenti where Utenti.NomeUtente = :myUsername";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":myUsername", $nomeUtenteAmico, PDO::PARAM_STR);

        $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($ris)) {
            return -1;
        }
        
        return $ris[0]['IDUtente'];
    }

    function aggiungiAmico($idAmico, $mioId) {
        $sql = "INSERT INTO `ListaAmici`(`IDUtente`, `IDAmico`) VALUES (:idMio , :idAmico), (:idAmico,:idMio)";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idMio", $mioId, PDO::PARAM_INT);
        $stm->bindParam(":idAmico", $idAmico, PDO::PARAM_INT);
        
        $esito = $stm->execute();
        return $esito;
    }

    function ottieniTuttiGliAmici($idUtenteLoggato) {
        $sql = 'SELECT Tabella.NomeUtente, Tabella.ID1, Tabella.ID2 FROM ( SELECT u.Nome, u.NomeUtente, u.IDUtente as "ID1", la.IDUtente as "ID2" FROM ListaAmici la INNER JOIN Utenti u on(la.IDAmico = u.IDUtente) )  as Tabella inner join Utenti as Ute on Tabella.ID1 = Ute.IDUtente' .
                ' where Tabella.ID2 = :idUtente';

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":idUtente", $idUtenteLoggato, PDO::PARAM_INT);

        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Query Prova
      SELECT Tabella.NomeUtente, Tabella.ID1, Tabella.ID2
      FROM
      (
      SELECT u.Nome, u.NomeUtente, u.IDUtente as "ID1", la.IDUtente as "ID2"
      FROM ListaAmici la
      INNER JOIN Utenti u on (la.IDAmico = u.IDUtente)
      )  as Tabella


      inner join Utenti as Ute on Tabella.ID1 = Ute.IDUtente

      where Tabella.ID2 = 15
     */

    public function inserisciMessaggio($idMandante, $idRicevente, $contenuto) {
        $sql = "INSERT INTO `Messaggi`(`IDMittente`, `IDDestinatario`, `Contenuto`) VALUES (:mitt,:dest,:cont)";


        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":mitt", $idMandante, PDO::PARAM_INT);
        $stm->bindParam(":dest", $idRicevente, PDO::PARAM_INT);
        $stm->bindParam(":cont", $contenuto, PDO::PARAM_STR);

        $esisto = $stm->execute();
            
        return $esisto;
    }

    public function getMessaggi($mittente, $destinatario) {
        $sql = "SELECT * from Messaggi where (Messaggi.IDMittente = :quindici and Messaggi.IDDestinatario = :seidici) or (Messaggi.IDDestinatario = :quindici and Messaggi.IDMittente = :seidici) order by DataMessaggio";

        $stm = $this->connessione->prepare($sql);
        $stm->bindParam(":quindici", $mittente, PDO::PARAM_INT);
        $stm->bindParam(":seidici", $destinatario, PDO::PARAM_INT);

        $stm->execute();
        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);
        $messaggi = array();
        for ($i = 0; $i < count($ris); $i++) {
            $arr = $ris[$i];
            $contenuto = $arr['Contenuto'];
            $idMittenteMessaggio = $arr['IDMittente'];
            
            if ($idMittenteMessaggio == $mittente) {
                $contenuto = "i" . $contenuto; //Inviato
            } else {
                $contenuto = "r" . $contenuto; //Ricevuto
            }

            $messaggi[$i]['Contenuto'] = $contenuto;
            $messaggi[$i]['IDMessaggio'] = $arr['IDMessaggio'];
        }

        
        return $messaggi;
    }

    /*
     *



      SELECT IDMessaggio, Contenuto, IDMittente as "Mittente", IDDestinatario as "Destinatario", DataMessaggio FROM Messaggi
      where Messaggi.visualizzato = false and IDDestinatario = 15

      GROUP BY IDDestinatario, IDMittente
      ORDER BY DataMessaggio desc
     */

    function controllaMessaggiPerMeDaLeggere($mioId) {
        $sql = '
                SELECT IDMessaggio, Contenuto, IDMittente as "Mittente", IDDestinatario as "Destinatario", DataMessaggio FROM Messaggi	
                where Messaggi.visualizzato = false and IDDestinatario = :mioID
                GROUP BY IDDestinatario, IDMittente
                ORDER BY DataMessaggio desc';

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":mioID", $mioId, PDO::PARAM_INT);

        $stm->execute();

        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);

        $dim = count($ris);
        $indice = 0;
        $ret = array();
        for ($i = 0; $i < $dim; $i++) {
            $mess = $ris[$i];
            $contentuto = $mess['Contenuto'];
            $mandante = $mess['Mittente'];
            $data = $mess['DataMessaggio'];


            $ret[$indice]['Contenuto'] = $contentuto;
            $ret[$indice]['Mandante'] = $mandante;
            $ret[$indice]['Data'] = $data;
            $indice++;
        }

        
        return $ret;
    }

    public function getUsernameById($id) {

        $sql = "Select NomeUtente from Utenti where Utenti.IDUtente = :mioID";

        $stm = $this->connessione->prepare($sql);

        $stm->bindParam(":mioID", $id, PDO::PARAM_INT);
        $stm->execute();

        $ris = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $ris[0]['NomeUtente'];
    }
    
    public function impostaMessaggiVisualizzati($idMessaggio, $idMit, $idDest)
    {
        $sql = "UPDATE Messaggi
                SET  `Visualizzato` = true 
                where (Messaggi.IDMittente = :idMit and IDDestinatario = :idDest) ";
        $stm = $this->connessione->prepare($sql);
        //$stm->bindParam(":idMess", $idMessaggio, PDO::PARAM_INT);
        $stm->bindParam(":idMit", $idMit, PDO::PARAM_INT);
        $stm->bindParam(":idDest", $idDest, PDO::PARAM_INT);
        
        $esito = $stm->execute();
        
        return $esito;
    }
    
    public function prendiImmagineDa($nomeUtente)
    {
        $sql = "SELECT Immagine from Utenti where Utenti.NomeUtente = :mioNome";
        
        $stm = $this->connessione->prepare($sql);
        
        $stm->bindParam(":mioNome", $nomeUtente, PDO::PARAM_STR);
        
        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_ASSOC)[0]["Immagine"];
    }
    
    public function ottieniImmagine($idUtente)
    {
        $sql = "SELECT Immagine from Utenti where Utenti.IDUtente = :id";
        
        $stm = $this->connessione->prepare($sql);
        
        $stm->bindParam(":id", $idUtente, PDO::PARAM_INT);
        
        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_ASSOC)[0]['Immagine'];
    }
    
    public function ottieniPassword($idUtente)
    {
        $sql = "SELECT Password from Utenti where Utenti.IDUtente = :id";
        
        $stm = $this->connessione->prepare($sql);
        
        $stm->bindParam(":id", $idUtente, PDO::PARAM_INT);
        
        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_ASSOC)[0]['Password'];
    }
    
    public function cambiaImpostazioni($array, $idUtente)
    {
        $sql = 'USE Chat;UPDATE '
                . '`Utenti`'
                . ' SET '
                . ' `Nome` = :myNome,'
                . ' `Cognome` = :myCognome,'
                . ' `NomeUtente` = :myNomeUtente,'
                . ' `Password` = :myPassword,'
                . ' `Email` = :myEmail,'
                . ' `NumeroDiTelefono` = :myNumero'
                . ' WHERE Utenti.IDUtente = :myId';
        
        $nome = $array['Nome'];
        $cognome = $array['Cognome'];
        $user = $array['NomeUtente'];
        $email = $array['Email'];
        $password = $array['Password'];
        $numero  = $array['NumeroDiTelefono'];

        //Se la password che ho come parametro è diversa dalla password che ho nel database allora calcola l'hash sulla nuova password
        if(strcmp($password, $this->ottieniPassword($idUtente)) != 0)
        {
            $password = hash("sha512", $password);
        }
        
        foreach ($array as $key => $value) {
            echo "Tipo di $key " . gettype($value) . "<br>";
        }
        
        echo "Tipo di idUtente " . gettype($idUtente) . " <br>";
        $idUtente = intval($idUtente);
        echo "Tipo di idUtente " . gettype($idUtente) . " <br>";
        $stm = $this->connessione->prepare($sql);
        
        $stm->bindParam(":myNome", $nome, PDO::PARAM_STR);
        $stm->bindParam(":myCognome", $cognome, PDO::PARAM_STR);
        $stm->bindParam(":myNomeUtente", $user, PDO::PARAM_STR);
        $stm->bindParam(":myPassword", $password, PDO::PARAM_STR);
        $stm->bindParam(":myEmail", $email, PDO::PARAM_STR);
        $stm->bindParam(":myNumero", $numero, PDO::PARAM_STR);
        $stm->bindParam(":myId", $idUtente, PDO::PARAM_INT);
        echo "Query String: " . $stm->queryString . "<br>";
        return $stm->execute();
        
        

        
        
        
        
        
        
    }

}
