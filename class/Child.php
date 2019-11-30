<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Child {

    private $id;
    private $parent_id;
    private $name;
    private $age;
    private $dbo;
    
    public $errors;
    
    public function __construct() {
        try {
            $this->dbo = new PDO('mysql:host=127.0.0.1;dbname=babysitting', 'root', 'mysql');
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
        }
        $this->parent_id = base64_decode($_SESSION['user']['id']);
    }

    public function addChild($data) {
        if (isset($data['name']) AND isset($data['age'])) {
            $this->name = htmlentities($data['name'], ENT_QUOTES);
            $name = $this->dbo->quote($this->name);
            $this->age = (int) htmlentities($data['age'], ENT_QUOTES);
            $query = "INSERT INTO children VALUES(NULL, {$this->parent_id}, $name, {$this->age})";
            if ($this->dbo->exec($query) !== 0) {
                return true;
            }
        } else {
            $this->errors[] = "Some data were not sent";
        }
        return false;
    }

}
