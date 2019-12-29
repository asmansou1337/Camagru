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
        $activated = $validation->verifyAccountActivated($pdo, $token);
        if ($activated->rowCount() > 0)
        {
            throw new Exception('This account is already activated !');
        }
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
        $email = $validation->validateString($email);
        $password = $validation->validateString($password);
        $userInfo = $validation->verifyCorrectloginInfo($pdo, $email, $password);
        return $userInfo;
    }

    public function reinitializePasswordEmail($pdo, $email)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $email = $validation->validateEmail($email);
        $query = "SELECT * FROM user_account WHERE email = ?";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$email]))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        } else 
        {
            if ($Statement->rowcount() === 0)
            {
                throw new Exception('This email does not exist, Please Try Again!');
            }
            $row = $Statement->fetch();
            require('models/emailManager.php');
            $subject = "Password Reinitialisation Link";
            $body = 'Hi '. $row['username'] . '<br>Folow the link below to reinitialize your password <br>'.
            'http://localhost/camagruproject/index.php?page=reinitializePassword&token='.$row['token'].'<br>';
            $sendEmail = new EmailManager();
            $sendEmail->sendEmail($email, $subject, $body);
            $_SESSION["message"] = "A link to reinitialize your password is sent to you, Please check your Email.";
        }
    }
    
    public function updatePassword($pdo, $password, $token)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $password = $validation->validatePassowrd($password);
        $hashedPassword = $this->hashPassword($password);
        $validation->validateString($token);
        $validation->verifyTokenExist($pdo, $token);
        $query = "UPDATE user_account SET password = ? WHERE token = ?";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$hashedPassword, $token]))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        }
        else {
            $_SESSION["message"] = "Your password has changed successfuly.";
        }
    }
}
?>