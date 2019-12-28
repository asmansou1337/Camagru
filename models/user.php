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

    private function getUsername()
    {
       return $this->username;
    }

    private function getFirstName()
    {
        return $this->firstName;
    }

    private function getLastName()
    {
        return $this->lastName;
    }

    private function getEmail()
    {
        return $this->email;
    }

    private function getPassword($password)
    {
        return $this->password;
    }
}

?>