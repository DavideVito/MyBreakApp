<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utente
 *
 * @author davidevitiello
 */
class Utente {
    
    private $username;
    private $idClasse;
    private $idUtente;
    private $tipoUtente;
    private $idScuola;
    
    function __construct($username, $idClasse, $idUtente, $tipoUtente, $idScuola) {
        $this->username = $username;
        $this->idClasse = $idClasse;
        $this->idUtente = $idUtente;
        $this->tipoUtente = $tipoUtente;
        $this->idScuola = $idScuola;
    }

    function getUsername() {
        return $this->username;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function getIdUtente() {
        return $this->idUtente;
    }

    function getTipoUtente() {
        return $this->tipoUtente;
    }

    function getIdScuola() {
        return $this->idScuola;
    }





}
