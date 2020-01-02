<?php
class controllerProfile {

    public function editUserProfile($pdo)
    {
            $username = trim($_POST['username']);
            $firstName = trim($_POST['firstName']);
            $lastName = trim($_POST['lastName']);
            $email = trim($_POST['email']);
            require('models/userManager.php');
            $user = new UserManager();
            $user->editProfile($pdo, $username, $firstName, $lastName, $email);
            $_SESSION['username'] = $username;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
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
            require('models/userManager.php');
            $user = new UserManager();
            $user->verifyOldPassword($pdo, $oldPassword);
            //$user->updatePassword($pdo, $newPassword, $_SESSION['token']);
        }
    }

}
?>