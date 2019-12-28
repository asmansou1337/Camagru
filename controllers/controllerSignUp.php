<?php
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
                require('models/userManager.php');
                $user = new UserManager();
                $user->addNewUser($pdo, $username, $email, $password);
            }
       
    }

    public function activateAccount($pdo, $token)
    {
        require('models/userManager.php');
        $user = new UserManager();
        $user->activateUserAccount($pdo, $token);
    }
}
?>