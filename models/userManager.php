<?php
 require_once('models/Validation.php');
 require_once('models/emailManager.php');
class UserManager {
    private $token;
    private $validation;

    

    public function addNewUser($pdo, $username, $email, $password)
    {
        $this->validation = new Validation();
        $username = $this->validation->validateString($username);
        $email = $this->validation->validateEmail($email);
        $password = $this->validation->validatePassowrd($password);
        $this->validation->verifyUsernameExists($pdo, $username);
        $this->validation->verifyEmailExists($pdo, $email);
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
        $this->validation = new Validation();
        $token = filter_var($token, FILTER_SANITIZE_STRING);
        $activated = $this->validation->verifyAccountActivated($pdo, $token);
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
        $this->validation = new Validation();
        $email = $this->validation->validateEmail($email);
        $password = $this->validation->validateString($password);
        $userInfo = $this->validation->verifyCorrectloginInfo($pdo, $email, $password);
        return $userInfo;
    }

    public function reinitializePasswordEmail($pdo, $email)
    {
        $this->validation = new Validation();
        $email = $this->validation->validateEmail($email);
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
        $this->validation = new Validation();
        $password = $this->validation->validateString($oldPassword);
        $hashedPassword = $this->hashPassword($password);
        $this->validation->verifyPasswordExists($pdo, $hashedPassword);
    }
    
    public function updatePassword($pdo, $password, $token)
    {
        $this->validation = new Validation();
        $password = $this->validation->validatePassowrd($password);
        $hashedPassword = $this->hashPassword($password);
        $this->validation->validateString($token);
        $this->validation->verifyTokenExist($pdo, $token);
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
        $this->validation = new Validation();
        $username = $this->validation->validateString($username);
        $firstName = $this->validation->validateString($firstName);
        $lastName = $this->validation->validateString($lastName);
        if (!empty($firstName) && !ctype_alpha($firstName))
            throw new Exception('Invalid Firstname!');
        if (!empty($lastName) && !ctype_alpha($lastName))
            throw new Exception('Invalid Lastname!');
        $email = $this->validation->validateEmail($email);
        if ($username != unserialize($_SESSION['user'])->getUsername())
        {
            // verify if new username does not exist already
            $this->validation->verifyUsernameExists($pdo, $username);
        }
        if ($email != unserialize($_SESSION['user'])->getEmail())
        {
            // verify if new email does not exist already
            $this->validation->verifyEmailExists($pdo, $email);
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