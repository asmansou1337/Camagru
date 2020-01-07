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
            'http://localhost/index.php?page=activateAccount&token='.$this->token.'<br>';
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
            'http://localhost/index.php?page=reinitializePassword&token='.$row['token'].'<br>';
            $sendEmail = new EmailManager();
            $sendEmail->sendEmail($email, $subject, $body);
            $_SESSION["message"] = "A link to reinitialize your password is sent to you, Please check your Email.";
        }
    }

    public function verifyOldPassword($pdo, $oldPassword)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $password = $validation->validateString($oldPassword);
        $hashedPassword = $this->hashPassword($password);
        $validation->verifyPasswordExists($pdo, $hashedPassword);
    }
    
    public function updatePassword($pdo, $password, $token)
    {
        //require('models/Validation.php');
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

    public function editProfile($pdo, $username, $firstName, $lastName, $email)
    {
        require('models/Validation.php');
        $validation = new Validation();
        $username = $validation->validateString($username);
        $firstName = $validation->validateString($firstName);
        $lastName = $validation->validateString($lastName);
        if (!empty($firstName) && !ctype_alpha($firstName))
            throw new Exception('Invalid Firstname!');
        if (!empty($lastName) && !ctype_alpha($lastName))
            throw new Exception('Invalid Lastname!');
        $email = $validation->validateEmail($email);
        if ($username != unserialize($_SESSION['user'])->getUsername())
        {
            // verify if new username does not exist already
            $validation->verifyUsernameExists($pdo, $username);
        }
        if ($email != unserialize($_SESSION['user'])->getEmail())
        {
            // verify if new email does not exist already
            $validation->verifyEmailExists($pdo, $email);
        }

        $query = "UPDATE user_account SET username = ?, email = ?, firstName = ?, lastName = ? WHERE token = ?";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$username, $email, $firstName, $lastName, $_SESSION['token']]))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        }
        else {
            $_SESSION["message"] = "Your profile information has been updated successfuly.";
        }
    }

    public function editNotification($pdo, $checked, $token)
    {
        $query = "UPDATE user_account SET notify = ? WHERE token = ?";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$checked, $token]))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        }
        else {
            $_SESSION["message"] = "Your notification setting has changed successfuly.";
        }
    }

    public function getNotification($pdo, $token)
    {
        $query = "SELECT notify FROM user_account WHERE token = ?";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$token]))
        {
            throw new Exception('Something Went Wrong, Please Try Again!');
        }
        else {
           $row = $Statement->fetch();
            return $row['notify'];
        }
    }
}
?>