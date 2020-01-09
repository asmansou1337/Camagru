<?php
require_once('models/userManager.php');
class controllerSignUp {

    public function signUp($pdo)
    {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword))
            {
                throw new Exception("All fields should not be empty !");
            } else if ($password !== $confirmPassword)
            {
                throw new Exception("Both password values must be same !");
            } else {
                $userManager = new UserManager();
                $userManager->addNewUser($pdo, $username, $email, $password);
            }
       
    }

    public function activateAccount($pdo, $token)
    {
        $userManager = new UserManager();
        $userManager->activateUserAccount($pdo, $token);
    }
}
?>