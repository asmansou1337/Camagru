<?php

class controllerSignIn 
{
    public function login($pdo)
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if (empty($email) || empty($password))
        {
            throw new Exception("All fields should not be empty !");
        } else {
            require('models/userManager.php');
            $userLogin = new UserManager();
            $user = $userLogin->userLogin($pdo, $email, $password);
            //echo $row['email'] . ' ' .  $row['password'];
            print_r($user);
        }
    }
}
?>