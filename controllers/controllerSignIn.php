<?php
 require_once('models/userManager.php');
 require_once('models/user.php');
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
            $userLogin = new UserManager();
            $userInfo = $userLogin->userLogin($pdo, $email, $password);
            $user = new User($userInfo['id'], $userInfo['username'], $userInfo['email'], $userInfo['password'], $userInfo['firstName'], $userInfo['lastName']);
            // $_SESSION['username'] = $user->getUsername();
            // $_SESSION['firstName'] = $user->getFirstName();
            // $_SESSION['lastName'] = $user->getLastName();
            // $_SESSION['email'] = $user->getEmail();
            $_SESSION['token'] = $userInfo['token'];
            $_SESSION['user'] = serialize($user);
            
            $_SESSION['loggedIn'] = 'yes';
            //echo "<script>console.log('Debug Objects: " . $_SESSION['loggedIn'] . "' );</script>";
           // <?php  echo "<script>console.log('Debug Objects: " . unserialize($_SESSION['user'])->getUsername() . "' );</script>"; 
            //echo "<script>console.log('Debug Objects: " . unserialize($_SESSION['user'])->getUsername() . "' );</script>";
            //echo 'logged ' . $_SESSION['loggedIn'];
        }
    }

    public function logout($pdo)
    {
        setcookie("SettingEmail", null, time() - 86400);
        $_SESSION["user"]  = null;
        // $_SESSION['username'] = null;
        // $_SESSION['firstName'] = null;
        // $_SESSION['lastName'] = null;
        // $_SESSION['email'] = null;
        $_SESSION['token'] = null;
        $_SESSION['loggedIn'] = null;
        //$_SESSION["message"] = "you are logged out";
        session_destroy();
    }

    public function sendReinitializeEmail($pdo)
    {
        $email = trim($_POST['email']);
        if (empty($email))
        {
            throw new Exception("Please enter your email !");
        } else {
            $user = new UserManager();
            $user->reinitializePasswordEmail($pdo, $email);
        }
    }

    public function reinitializePassword($pdo)
    {
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['Confirmpassword']);
        if (empty($password) || empty($confirmPassword))
        {
            throw new Exception("All fields should not be empty !");
            
        } else if ($password !== $confirmPassword)
        {
            throw new Exception("Both password values must be same !");
        } else if (!isset($_GET['token'])){
            throw new Exception("Invalid link, Please try again !");
        } else {
            $user = new UserManager();
            $user->updatePassword($pdo, $password, $_GET['token']);
        }
    }
}
?>