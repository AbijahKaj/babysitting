<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Abijah Kajabika <me@realabijah.com>
 */
class User {

    /**
     *  The ID of the user
     * @var type int
     */
    private $id;
    private $name;
    private $lastname;
    private $email;

    /**
     * MD5 password hash
     * @var type string
     */
    private $password;

    /**
     * A user type: 1 customer, 2 sitter, 3 manager
     * @var type int
     */
    private $type;

    /**
     *
     * @var type class
     */
    private $dbo;
    public $errors;

    public function __construct() {
        try {
            $this->dbo = new PDO('mysql:host=127.0.0.1;dbname=babysitting', 'root', 'mysql');
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
        }
        $this->type = 1;
    }

    public function signupUser($_sentData) {
        if ($this->verifyData($_sentData)) {
            $name = $this->dbo->quote($this->name);
            $lastname = $this->dbo->quote($this->lastname);
            $query = "INSERT INTO users VALUES(NULL, $name, $lastname, '{$this->email}', '{$this->password}', {$this->type})";
            if ($this->dbo->exec($query) !== 0) {
                $_SESSION['user'] = array("id" => base64_encode($this->dbo->lastInsertId()), "tmp" => md5(time()));
                return true;
            }
        }
        return FALSE;
    }

    /**
     * A function to help securely signin users using their emails and passwords
     * @param type $_sentData Usually data received from $_POST
     * @version 1.0
     * @author Abijah Kajabika <me@realabijah.com>
     * @return boolean
     */
    public function signinUser($data) {
        if (isset($data['email']) AND isset($data['password']) AND filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $this->dbo->quote($data['email']);
            $password = md5($data['password']);
            $query = "SELECT id FROM users WHERE email=$email AND password='$password'";
            $result = $this->dbo->query($query)->fetchAll();
            if (count($result) > 0) {
                $_SESSION['user'] = array("id" => base64_encode($result[0]['id']), "tmp" => md5(time()));
                return true;
            }
        }
        return false;
    }

    public function signoutUser() {
        $_SESSION['user'] = null;
    }
    /**
     * Get the name, lastname, email and type of the current logged in user.
     * @return array|null
     */
    public function getCurrentUser() {
        if (!isset($_SESSION['user'])) {
            return null;
        }
        $id = (int) base64_decode($_SESSION['user']['id']);
        $query = "SELECT name, lastname, email, type FROM users WHERE id=$id";
        $result = $this->dbo->query($query)->fetchAll();
        if (count($result) > 0) {
            return $result[0];
        }
    }

    /**
     * A simple way to verify and save data for User Registration
     * @version 1.1
     * @param type $data
     * @return boolean
     */
    protected function verifyData($data) {
        if (isset($data['name']) AND isset($data['lastname']) AND isset($data['password']) AND isset($data['email'])) {
            $name = $data['name'];
            $lastname = $data['lastname'];
            $email = $data['email'];
            $password = $data['password'];
            if ($name == $lastname) {
                $this->errors[] = "Username can not be the same as the last name";
                return FALSE;
            }
            if (strlen($password) >= 7 AND filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->name = $name;
                $this->lastname = $lastname;
                $this->email = $email;
                $this->password = md5($password);
                return true;
            } else {
                $this->errors[] = "Problem with the Email or Password";
            }
        } else {
            $this->errors[] = "Some elements not received";
        }
        return FALSE;
    }

}
