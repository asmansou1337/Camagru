<?php
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
session_start();
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
        spl_autoload_register(function($class){
            require_once('models/'.$class.'.php');
          });
        //require('controllers/controllerSignUp.php');
        switch ($page) {
            case ($page === "home"):
               // if (isset($_SESSION['loggedIn']))
               //     echo "<script>console.log('Debug Objects: " . $_SESSION['loggedIn'] . "' );</script>";
                require('views/homeView.php');
                break;
            case ($page === "signup"):
                $this->accessControl("logged");
                    require('controllers/controllerSignUp.php');
                $this->routing("SignUp", "signUp");
                // try 
                // {
                //     if (isset($_SESSION['loggedIn']))
                //     {
                //         header('Location: index.php?page=home');
                //     }
                //     if(isset($_POST['signUp']))
                //     {
                //         require('controllers/controllerSignUp.php');
                //         $ctrl = new controllerSignUp();
                //         $ctrl->signUp($this->pdo);
                //         if (isset($_SESSION["message"]))
                //             $message = $_SESSION["message"];
                //     }
                // } catch (Exception $e)
                // {
                //     $errors = $e->getMessage();
                // }
                // require('views/messageView.php');
                // unset($_SESSION["message"]);
                require('views/signUpView.php');
                break;
            case ($page === "activateAccount"):
                $this->accessControl("logged");
                // require('controllers/controllerSignUp.php');
                // $this->routing("SignUp", "signUp");
                try 
                {
                    // if (isset($_SESSION['loggedIn']))
                    // {
                    //     header('Location: index.php?page=home');
                    // }
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
                unset($_SESSION["message"]);
                require('views/loginView.php');
                break;
            case ($page === "login"):
                $this->accessControl("logged");
                try 
                {
                    // if (isset($_SESSION['loggedIn']))
                    // {
                    //     //$message = "You are already logged in !";
                    //     header('Location: index.php?page=home');
                    // }
                    if(isset($_POST['login']))
                    {
                        require('controllers/controllerSignIn.php');
                        $ctrl = new controllerSignIn();
                        $ctrl->login($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        if (isset($_POST["RememberMe"]))
                        {
                            setcookie("SettingEmail", $_SESSION['user']->getEmail() , time() + 86400);
                        }
                        header('Location: index.php?page=home');
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/loginView.php');
                break;
            case ($page === "forgotPassword"):
                $this->accessControl("logged");
                try 
                {
                    // if (isset($_SESSION['loggedIn']))
                    // {
                    //         //$message = "You are already logged in !";
                    //     header('Location: index.php?page=home');
                    //     //exit();
                    // }
                    if(isset($_POST['SendPasswordEmail']))
                    {
                        require('controllers/controllerSignIn.php');
                        $ctrl = new controllerSignIn();
                        $ctrl->sendReinitializeEmail($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        //header('Location: index.php?page=home');
                        //exit();
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/reinitialisationEmailView.php');
                break;
            case ($page === "reinitializePassword"):
                $this->accessControl("logged");
                try 
                {
                    // if (isset($_SESSION['loggedIn']))
                    // {
                    //             //$message = "You are already logged in !";
                    //     header('Location: index.php?page=home');
                    //     //exit();
                    // }
                    if(isset($_POST['changePassword']))
                    {
                        require('controllers/controllerSignIn.php');
                        $ctrl = new controllerSignIn();
                        $ctrl->reinitializePassword($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        //header('Location: index.php?page=login');
                        //exit();
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/reinitialisationPasswordView.php');
                break;
            case ($page === "logout"):
                try 
                {
                        require('controllers/controllerSignIn.php');
                        $ctrl = new controllerSignIn();
                        $ctrl->logout($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        header('Location: index.php?page=home');
                        //exit();
                    
                } catch (Exception $e)
                {
                        $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/loginView.php');
                break;
            case ($page === "editProfile"):
                $this->accessControl("notlogged");
                    try 
                    {   
                        // if (!isset($_SESSION['loggedIn']))
                        // {
                        //     header('Location: index.php?page=home');
                        // }
                        if(isset($_POST['editProfile']))
                        {
                            require('controllers/controllerProfile.php');
                            $ctrl = new controllerProfile();
                            $ctrl->editUserProfile($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }
                    } catch (Exception $e)
                    {
                            $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/editProfileView.php');
                    break;
            case ($page === "changePassword"):
                $this->accessControl("notlogged");
                    try 
                    {   
                        // if (!isset($_SESSION['loggedIn']))
                        // {
                        //     header('Location: index.php?page=home');
                        // }
                        if(isset($_POST['editPassword']))
                        {
                            require('controllers/controllerProfile.php');
                            $ctrl = new controllerProfile();
                            $ctrl->changePassword($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/editPasswordView.php');
                    break;
            case ($page === "notifications"):
                $this->accessControl("notlogged");
                try 
                    {
                        $notify = "ON/OFF";
                        require('controllers/controllerProfile.php');
                        $ctrl = new controllerProfile();
                        // if (!isset($_SESSION['loggedIn']))
                        // {
                        //     header('Location: index.php?page=home');
                        // }
                        if(isset($_POST['editNotifications']))
                        {
                            $ctrl->changeNotification($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }
                        $notify = $ctrl->getNotificationSetting($this->pdo);
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/notificationView.php');
                    break;
                case ($page === "gallery"):
                try 
                {
                   
                    if (isset($_SESSION["message"]))
                        $message = $_SESSION["message"];
                        
                } catch (Exception $e)
                {
                            $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/galleryView.php');
                break;
                case ($page === "upload"):
                    try 
                    {
                       
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                            
                    } catch (Exception $e)
                    {
                                $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/uploadView.php');
                    break;
            default:
                require "views/homeView.php";
                break;
        }
        require('views/footer.php');
    }

    private function routing($controller, $function , $type)
    {
        if ($type === "post")
            $par = $_POST[$function];
        if ($type === "get")
            $par = $_POST[$function];
        try 
            {
                if(isset($par))
                {
                    $var = "controller".$controller;
                    $ctrl = new $var();
                    $ctrl->$function($this->pdo);
                    if (isset($_SESSION["message"]))
                        $message = $_SESSION["message"];
                }
        } catch (Exception $e)
        {
            $errors = $e->getMessage();
        }
        require('views/messageView.php');
        unset($_SESSION["message"]);
    }

    private function accessControl($access)
    {
        if($access == "logged")
        {
            if (isset($_SESSION['loggedIn']))
            {
                header('Location: index.php?page=home');
            }
        }
        else if ($access == "notlogged")
        {
            if (!isset($_SESSION['loggedIn']))
            {
                header('Location: index.php?page=home');
            }
        }
    }

}
?>