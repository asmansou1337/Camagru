<?php

class Validation {
    public function validateEmail($email)
    {
        // Validate e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           throw new Exception("Please Enter a Valid Email Address !");
        }
        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $email;
    }

    public function validateStringOrigin($str)
    {
        // Change all illegal characters from string
        $str = filter_var($str, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $str;
    }

    public function validateString($str)
    {
        // Remove all illegal characters from string
        $str = filter_var($str, FILTER_SANITIZE_STRING);
        return $str;
    }

    public function validateUsername($username)
    {
        $username = $this->validateString($username);
        if(!preg_match('/^\w{3,}$/', $username)) {
            throw new Exception("Please Enter a Valid Username (Should be 3 caracteres or more) !");
        }
        return $username;
    }

    public function validatePassowrd($password)
    {
        // Remove all illegal characters from password
        $password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            throw new Exception('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
        }
        return $password;
    }

    public function verifyUsernameExists($pdo, $username)
    {
        $query = "SELECT * FROM user_account WHERE username = ?";
        $Statement=$pdo->prepare($query);
        $Statement->execute([$username]);
        // $ErrorInformation = $Statement->errorInfo();
        // if(isset($ErrorInformation[2])){
        //     throw new Exception($ErrorInformation[2]);
        // }
        if ($Statement->rowCount() > 0)
        {
            throw new Exception('Username Exists Already, Choose another one !');
        }
    }

    public function verifyEmailExists($pdo, $email)
    {
        $query = "SELECT * FROM user_account WHERE email = ?";
        $Statement=$pdo->prepare($query);
        $Statement->execute([$email]);
        // $ErrorInformation = $Statement->errorInfo();
        // if(isset($ErrorInformation[2])){
        //     throw new Exception($ErrorInformation[2]);
        // }
        if ($Statement->rowCount() > 0)
        {
            throw new Exception('Email Exists Already, Choose another one !');
        }
    }

    public function verifyPasswordExists($pdo, $password)
    {
        $query = "SELECT * FROM user_account WHERE password = ?";
        $Statement=$pdo->prepare($query);
        $Statement->execute([$password]);
        // $ErrorInformation = $Statement->errorInfo();
        // if(isset($ErrorInformation[2])){
        //     throw new Exception($ErrorInformation[2]);
        // }
        if ($Statement->rowCount() === 0)
        {
            throw new Exception('The old password is wrong, Try Again !');
        }
    }

    public function verifyCorrectloginInfo($pdo, $email, $password)
    {
        $query = "SELECT * FROM user_account WHERE email = ?";
        $Statement=$pdo->prepare($query);
        $Statement->execute([$email]);
        // $ErrorInformation = $Statement->errorInfo();
        // if(isset($ErrorInformation[2])){
        //     throw new Exception($ErrorInformation[2]);
        // }
        if ($Statement->rowCount() === 0)
        {
            throw new Exception('This Email does not Exist!');
        }
        $row = $Statement->fetch();
        if (hash("whirlpool", $password) === $row['password'])
        {
            $activated = $this->verifyAccountActivated($pdo, $row['token']);
                if ($activated->rowCount() === 0)
                {
                    throw new Exception('Account Activation Required !');
                }
            return $row;
        } else {
            throw new Exception('Wrong Password!');
        }
    }

    public function verifyTokenExist($pdo, $token)
    {
        $query = "SELECT * FROM user_account WHERE token = ?";
        $Statement=$pdo->prepare($query);
        $Statement->execute([$token]);
        if($Statement->rowCount() === 0)
        {
            throw new Exception('Unvalid link, Please try again !');
        }
    }

    public function verifyAccountActivated($pdo, $token)
    {
        $this->verifyTokenExist($pdo, $token);
        $query = "SELECT * FROM user_account WHERE token = ? AND active = 'ON'";
        $Statement = $pdo->prepare($query);
        $Statement->execute([$token]);
        // $ErrorInformation = $Statement->errorInfo();
        // if(isset($ErrorInformation[2])){
        //     throw new Exception($ErrorInformation[2]);
        // }
        return $Statement;
    }
}
?>