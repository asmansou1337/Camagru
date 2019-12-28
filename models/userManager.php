<?php

class UserManager {
    private $token;
    private $active;
    private $notify;

    public function addNewUser($pdo, $username, $email, $password)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $username = $validation->validateString($username);
        $email = $validation->validateEmail($email);
        $password = $validation->validatePassowrd($password);
        $validation->verifyUsernameExists($pdo, $username);
        $validation->verifyEmailExists($pdo, $email);
        $hashedPassword = $this->hashPassword($password);
        $this->token = $this->createToken();
        // Add User to database
        $query = "INSERT INTO user_account (username, email, password, token, active, notify) VALUES (?, ?, ?, ?, ?, ?)";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$username, $email, $hashedPassword, $this->token, 'OFF', 'ON']))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        } else 
        {
            require('models/emailManager.php');
            $subject = "Activation Link For Camagru";
            $body = 'Hi '. $username . '<br>Folow the link below to activate your account <br>'.
            'http://localhost/camagruproject/index.php?page=activateAccount&token='.$this->token.'<br>';
            $sendEmail = new EmailManager();
            $sendEmail->sendEmail($email, $subject, $body);
            $_SESSION["message"] = "Your Account has been created successfully, Please check your Email for the activation link";
        }
    }

    public function createToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(40));
        return $token;
    }

    public function hashPassword($password)
    {
        $passHashed = hash("whirlpool", $password);
        return $passHashed;
    }

    public function activateUserAccount($pdo, $token)
    {
        $token = filter_var($token, FILTER_SANITIZE_STRING);
        require('models/Validation.php');
        $validation = new Validation();
        $validation->verifyAccountActivated($pdo, $token);
        $query = "UPDATE user_account SET active = 'ON' WHERE token = ?";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$token])){
            throw new Exception('Something went wrong while activating your account, Please Try Again!');
        } else {
            $_SESSION["message"] = "Your Account has been activated successfully.";
        }
    }

    public function userLogin($pdo, $email, $password)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $email = $validation->validateEmail($email);
        $password = $validation->validatePassowrd($password);
        $user = $validation->verifyCorrectloginInfo($pdo, $email, $password);
        return $user;
    }
}
?>