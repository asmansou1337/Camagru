<?php
session_start();
//require('views/header.php');
//require('views/messageView.php');
//require('views/signUpView.php');
//require('views/loginView.php');
//require('views/reinitialisationEmailView.php');
//require('views/reinitialisationPasswordView.php');
//require('views/editProfileView.php');
//require('views/editPasswordView.php');
//require('views/notificationView.php');
//require('views/galleryView.php');
//require('views/footer.php');

class Controller 
{
    private $pdo;
    private $ctrl;
    private $view;
    private $message;
    private $errors;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $page;
        require('views/header.php');
        //require('controllers/controllerSignUp.php');
        switch ($page) {
            case ($page === "home"):
                require('views/homeView.php');
                break;
            case ($page === "signup"):
                try 
                {
                    if(isset($_POST['signUp']))
                    {
                        require('controllers/controllerSignUp.php');
                        $ctrl = new controllerSignUp();
                        $ctrl->signUp($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                require('views/signUpView.php');
                break;
            case ($page === "activateAccount"):
                try 
                {
                    if(isset($_GET['token']))
                    {
                        require('controllers/controllerSignUp.php');
                        $ctrl = new controllerSignUp();
                        $ctrl->activateAccount($this->pdo, $_GET['token']);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                    } else {
                        throw new Exception("Token required to activate your account !");
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                require('views/loginView.php');
                break;
            case ($page === "login"):
               // echo "signin";
                require('views/loginView.php');
                break;
            default:
                require "views/homeView.php";
                break;
        }
        require('views/footer.php');
    }
}
?>