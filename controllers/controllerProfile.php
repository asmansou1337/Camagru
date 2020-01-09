<?php
 require_once('models/userManager.php');
 require_once('models/user.php');
class controllerProfile {

    public function editUserProfile($pdo)
    {
            $username = trim($_POST['username']);
            $firstName = trim($_POST['firstName']);
            $lastName = trim($_POST['lastName']);
            $email = trim($_POST['email']);
            if (empty($username))
                throw new Exception("Username should not be empty !");
            if (empty($email))
                throw new Exception("Email should not be empty !");
            $user = new UserManager();
            $user->editProfile($pdo, $username, $firstName, $lastName, $email);
            $user = new User($username, $email, unserialize($_SESSION['user'])->getPassword(), $firstName, $lastName);
            $_SESSION['user'] = serialize($user);
    }

    public function changePassword($pdo)
    {
        $oldPassword = trim($_POST['oldPassword']);
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmNewPassword']);
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword))
        {
            throw new Exception("All fields should not be empty !");
            
        } else if ($newPassword !== $confirmPassword)
        {
            throw new Exception("Both password values must be same !");
        } else {
            $user = new UserManager();
            $user->verifyOldPassword($pdo, $oldPassword);
            $user->updatePassword($pdo, $newPassword, $_SESSION['token']);
        }
    }

    public function changeNotification($pdo)
    {
        if(isset($_POST['checkNotification']))
        {
            $checked = "ON";

        } else {
            $checked = "OFF";
        }
        $user = new UserManager();
        $user->editNotification($pdo, $checked, $_SESSION['token']); 
    }

    public function getNotificationSetting($pdo)
    {
        $user = new UserManager();
        return $user->getNotification($pdo, $_SESSION['token']); 
    }

}
?>