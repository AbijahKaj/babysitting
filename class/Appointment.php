<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Appointment{
    private $id;
    protected $parent_id;
    protected $child_id;
    private $service;
    private $hours;
    /**
     * Status of the appointment 1 pending, 2 Accepted, 3 declined
     * @var type int
     */
    public $status;
    private $price;
    private $created_time;
    
    private $dbo;
    public $errors;

    public function __construct() {
        try {
            $this->dbo = new PDO('mysql:host=127.0.0.1;dbname=babysitting', 'root', 'mysql');
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
        }
        $this->parent_id = base64_decode($_SESSION['user']['id']);
        $this->status = 1;
    }
    
    public function createAppointment($data) {
        if(isset($data['child']) AND isset($data['service']) AND isset($data['hours'])
                AND strlen($data['service']) ==1){
            $this->child_id = (int) htmlentities($data['child']);
            $this->service = (int) htmlentities($data['service']);
            $this->hours = (int) htmlentities($data['hours']);
            $this->price = $this->getPrice($this->service, $this->hours);
            $this->created_time = time();
            $query = "INSERT INTO appointments VALUES(NULL, {$this->parent_id}, {$this->child_id}, {$this->service}, {$this->hours}, {$this->status}, {$this->price}, {$this->created_time})";
            if ($this->dbo->exec($query) !== 0) {
                return true;
            }
        } else {
            $this->errors[] = "Some data were not sent";
        }
        return false;
    }
    private function getPrice($service, $hours){
        switch ($service) {
            case 1:
            case 2:
            case 3:
                return $hours * 8500;
                break;
            case 4:
                return $hours * 12000;
                break;
            default:
                break;
        }
    }
}