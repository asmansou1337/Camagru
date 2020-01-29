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
require_once('controllers/controllerSignUp.php');
require_once('controllers/controllerSignIn.php');
require_once('controllers/controllerProfile.php');
require_once('controllers/controllerImage.php');
require_once('controllers/controllerComment.php');

class Controller 
{
    private $pdo;
    // private $ctrl;
    // private $view;
    // private $message;
    // private $errors;
    
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

        switch ($page) {
            case ($page === "home"):
               // if (isset($_SESSION['loggedIn']))
               //     echo "<script>console.log('Debug Objects: " . $_SESSION['loggedIn'] . "' );</script>";
                require('views/homeView.php');
                break;
            case ($page === "signup"):
                $this->accessControl("logged");
                try 
                {
                    if(isset($_POST['signUp']))
                    {
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
                unset($_SESSION["message"]);
                require('views/signUpView.php');
                break;
            case ($page === "activateAccount"):
                $this->accessControl("logged");
                try 
                {
                    if(isset($_GET['token']))
                    {
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
                    if(isset($_POST['login']))
                    {
                        $ctrl = new controllerSignIn();
                        $ctrl->login($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        if (isset($_POST["RememberMe"]))
                        {
                            setcookie("SettingEmail", unserialize($_SESSION['user'])->getEmail() , time() + 86400);
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
                    if(isset($_POST['SendPasswordEmail']))
                    {
                        $ctrl = new controllerSignIn();
                        $ctrl->sendReinitializeEmail($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
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
                    if(isset($_POST['changePassword']))
                    {
                        $ctrl = new controllerSignIn();
                        $ctrl->reinitializePassword($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
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
                        $ctrl = new controllerSignIn();
                        $ctrl->logout($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                        header('Location: index.php?page=home');
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
                        if(isset($_POST['editProfile']))
                        {
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
                        if(isset($_POST['editPassword']))
                        {
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
                        $notify = "";
                        $ctrl = new controllerProfile();
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
                        $ctrl = new controllerImage();
                        $nbpages = $ctrl->getTotalPages($this->pdo);
                        $nbr = filter_input(INPUT_GET, 'nbr', FILTER_SANITIZE_SPECIAL_CHARS);
                        $pics = $ctrl->getGalleryPage($this->pdo, $nbr);
                        
                        //print_r($pics);
                      
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
                $this->accessControl("notlogged");
                    try 
                    {
                        $ctrl = new controllerImage();
                        $pics = $ctrl->getLoggedUserImages($this->pdo);
                        $count = count($pics);
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
            case ($page === "addLike"):
                //$this->accessControl("notlogged");
                    try 
                        {
                            if (isset($_POST['like']))
                            {
                                $ctrl = new controllerImage();
                                $ctrl->addLikeToImage($this->pdo, $_POST['picId'], $_POST['ownerId'], $_POST['ownerUsername'], $_POST['ownerEmail']);
                                if (isset($_SESSION["message"]))
                                    $message = $_SESSION["message"];
                                header('Location: index.php?page=gallery');
                            }
                        } catch (Exception $e)
                        {
                            $errors = $e->getMessage();
                        }
                        require('views/messageView.php');
                        unset($_SESSION["message"]);
                        require('views/galleryView.php');
                        break;
            case ($page === "addLikeDetail"):
                            //$this->accessControl("notlogged");
                                try 
                                    {
                                        if (isset($_POST['like']))
                                        {
                                            $ctrl = new controllerImage();
                                            $ctrlComment = new controllerComment();
                                            $ctrl->addLikeToImage($this->pdo, $_POST['picId'], $_POST['ownerId'], $_POST['ownerUsername'], $_POST['ownerEmail']);
                                            $pic = $ctrl->getImageDetailPage($this->pdo, $_POST['picId']);
                                            $comment = $ctrlComment->getCommentList($this->pdo, $_POST['picId']);
                                            if (isset($_SESSION["message"]))
                                                $message = $_SESSION["message"];
                                            //header('Location: index.php?page=viewImageDetails');
                                        }
                                    } catch (Exception $e)
                                    {
                                        $errors = $e->getMessage();
                                    }
                                    require('views/messageView.php');
                                    unset($_SESSION["message"]);
                                    require('views/imageDetailView.php');
                                    break;
            case ($page === "addComment"):
                //$this->accessControl("notlogged");
                try 
                {
                    if (isset($_POST['addComment']))
                        {
                            $ctrl = new controllerComment();
                            $ctrlImg = new controllerImage();
                            //$pic = $ctrl->getImageDetailPage($this->pdo, $_POST['picId']);
                            //$ctrl->addLikeToImage($this->pdo, $_POST['picId'], $_POST['ownerId'], $_POST['ownerUsername'], $_POST['ownerEmail']);
                            $ctrl->addNewComment($this->pdo);
                            $pic = $ctrlImg->getImageDetailPage($this->pdo, $_POST['CommentedPicId']);
                            $comment = $ctrl->getCommentList($this->pdo, $_POST['CommentedPicId']);
                            //print_r($comment);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                            //header('Location: index.php?page=gallery');
                        }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/imageDetailView.php');
                break;
            case ($page === "delComment"):
                    //$this->accessControl("notlogged");
                    try 
                    {
                        if (isset($_POST['delComment']))
                            {
                                $ctrl = new controllerComment();
                                $ctrlImg = new controllerImage();
                                //$pic = $ctrl->getImageDetailPage($this->pdo, $_POST['picId']);
                                //$ctrl->addLikeToImage($this->pdo, $_POST['picId'], $_POST['ownerId'], $_POST['ownerUsername'], $_POST['ownerEmail']);
                                $ctrl->delSelectedComment($this->pdo);
                                $pic = $ctrlImg->getImageDetailPage($this->pdo, $_POST['CommentedPicId']);
                                $comment = $ctrl->getCommentList($this->pdo, $_POST['CommentedPicId']);
                                //print_r($comment);
                                if (isset($_SESSION["message"]))
                                    $message = $_SESSION["message"];
                                //header('Location: index.php?page=gallery');
                            }
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/imageDetailView.php');
                    break;
            case ($page === "viewImageDetails"):
                //$this->accessControl("notlogged");
                    try 
                        {
                            if (isset($_POST['view']))
                                {
                                    $ctrlComment = new controllerComment();
                                    $ctrl = new controllerImage();
                                    $pic = $ctrl->getImageDetailPage($this->pdo, $_POST['picId']);
                                    $comment = $ctrlComment->getCommentList($this->pdo, $_POST['picId']);
                                    //$ctrl->addLikeToImage($this->pdo, $_POST['picId'], $_POST['ownerId'], $_POST['ownerUsername'], $_POST['ownerEmail']);
                                    if (isset($_SESSION["message"]))
                                        $message = $_SESSION["message"];
                                    //header('Location: index.php?page=gallery');
                                }
                        } catch (Exception $e)
                        {
                            $errors = $e->getMessage();
                        }
                        require('views/messageView.php');
                        unset($_SESSION["message"]);
                        require('views/imageDetailView.php');
                        break;
            case ($page === "uploadMergeImg"):
                //$this->accessControl("notlogged");
                try 
                    {
                        if(isset($_POST['imgToSend']))
                        {
                            $ctrl = new controllerImage();
                            $ctrl->uploadMergeImg($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }       
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/uploadView.php');
                    break;
            case ($page === "deleteImg"):
                echo "<script>console.log('yes working:' );</script>";
                //$this->accessControl("notlogged");
                try 
                    {
                        if(isset($_POST['imgToDelete']))
                        {
                           //echo "<script>console.log('Debug Objects: " . $_POST['delImg'] . "' );</script>";
                            //echo $_POST['imgId'];
                            $ctrl = new controllerImage();
                            $ctrl->deleteImage($this->pdo, $_POST['delImgId'], $_POST['delImgName']);
                            $pics = $ctrl->getLoggedUserImages($this->pdo);
                            $count = count($pics);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                            }
                        //$message = "delete";     
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

    // private function routing($controller, $function , $type)
    // {
    //     if ($type === "post")
    //         $par = $_POST[$function];
    //     if ($type === "get")
    //         $par = $_GET[$function];
    //     try 
    //         {
    //             if(isset($par))
    //             {
    //                 $var = "controller".$controller;
    //                 $ctrl = new $var();
    //                 $ctrl->$function($this->pdo);
    //                 if (isset($_SESSION["message"]))
    //                     $message = $_SESSION["message"];
    //             }
    //     } catch (Exception $e)
    //     {
    //         $errors = $e->getMessage();
    //     }
    //     require('views/messageView.php');
    //     unset($_SESSION["message"]);
    // }

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