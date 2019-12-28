<?php

class User {
    private username;
    private firstName;
    private lastName;
    private email;
    private password;

    public function __construct($username, $email, $password, $firstName, $lastName) {
        
    }

    private setUsername($username)
    {
        $this->username = $username;
    }
}

?>