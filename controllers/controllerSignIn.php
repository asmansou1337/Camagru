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
            require('models/user.php');
            $userLogin = new UserManager();
            $userInfo = $userLogin->userLogin($pdo, $email, $password);
            $user = new User($userInfo['username'], $userInfo['email'], $userInfo['password'], $userInfo['firstName'], $userInfo['lastName']);
            $_SESSION['user'] = $user;
            $_SESSION['loggedIn'] = 'yes';
            echo "<script>console.log('Debug Objects: " . $_SESSION['loggedIn'] . "' );</script>";
            //echo 'logged ' . $_SESSION['loggedIn'];
        }
    }
}
?>