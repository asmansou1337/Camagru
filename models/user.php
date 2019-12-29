<?php

class User {
    private $username;
    private $firstName;
    private $lastName;
    private $email;
    private $password;

    public function __construct($username, $email, $password, $firstName, $lastName) {
        $this->setUsername($username);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPassword($password);
        
    }

    private function setUsername($username)
    {
        $this->username = $username;
    }

    private function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    private function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    private function setEmail($email)
    {
        $this->email = $email;
    }

    private function setPassword($password)
    {
        $this->password = $password;
    }

    public function getUsername()
    {
       return $this->username;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword($password)
    {
        return $this->password;
    }
}

?>