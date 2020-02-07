<?php
session_start();
require_once('controllers/controllerSignUp.php');
require_once('controllers/controllerSignIn.php');
require_once('controllers/controllerProfile.php');
require_once('controllers/controllerImage.php');
require_once('controllers/controllerComment.php');

class Controller 
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $page;
        require('views/header.php');
        
        // Depending on the page requested a certain traitement is done
        switch ($page) {
            case ($page === "home"):
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
                        $notify = "";
                        $ctrl = new controllerProfile();
                        if(isset($_POST['editProfile']))
                        {
                            $ctrl->changeNotification($this->pdo);
                            $ctrl->editUserProfile($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }
                        $notify = $ctrl->getNotificationSetting($this->pdo);
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
                    require('views/editProfileView.php');
                    break;
            case ($page === "gallery"):
                    try 
                    {
                        $ctrl = new controllerImage();
                        $nbpages = $ctrl->getTotalPages($this->pdo);
                        $nbr = filter_input(INPUT_GET, 'nbr', FILTER_SANITIZE_SPECIAL_CHARS);
                        $pics = $ctrl->getGalleryPage($this->pdo, $nbr);
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
                $this->accessControl("notlogged");
                    try 
                        {
                            if (isset($_POST['like']))
                            {
                                $ctrl = new controllerImage();
                                $ctrl->addLikeToImage($this->pdo);
                                if (isset($_SESSION["message"]))
                                    $message = $_SESSION["message"];
                                header('Location: index.php?page=gallery');
                            }
                        } catch (Exception $e)
                        {
                            $errors = $e->getMessage();
                            header('Location: index.php?page=gallery');
                        }
                        require('views/messageView.php');
                        unset($_SESSION["message"]);
                        require('views/galleryView.php');
                        break;
            case ($page === "addLikeDetail"):
                $this->accessControl("notlogged");
                try 
                {
                    if (isset($_POST['like']))
                    {
                        $ctrl = new controllerImage();
                        $ctrlComment = new controllerComment();
                        $ctrl->addLikeToImage($this->pdo);
                        $pic = $ctrl->getImageDetailPage($this->pdo);
                        $comment = $ctrlComment->getCommentList($this->pdo);
                        if (isset($_SESSION["message"]))
                            $message = $_SESSION["message"];
                    }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                    header('Location: index.php?page=gallery');
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/imageDetailView.php');
                break;
            case ($page === "addComment"):
                $this->accessControl("notlogged");
                try 
                {
                    if (isset($_POST['addComment']))
                        {
                            $ctrl = new controllerComment();
                            $ctrlImg = new controllerImage();
                            $ctrl->addNewComment($this->pdo);
                            $pic = $ctrlImg->getImageDetailPage($this->pdo);
                            $comment = $ctrl->getCommentList($this->pdo);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                        }
                } catch (Exception $e)
                {
                    $errors = $e->getMessage();
                    header('Location: index.php?page=gallery');
                }
                require('views/messageView.php');
                unset($_SESSION["message"]);
                require('views/imageDetailView.php');
                break;
            case ($page === "delComment"):
                    $this->accessControl("notlogged");
                    try 
                    {
                        if (isset($_POST['delComment']))
                            {
                                $ctrl = new controllerComment();
                                $ctrlImg = new controllerImage();
                                $ctrl->delSelectedComment($this->pdo);
                                $pic = $ctrlImg->getImageDetailPage($this->pdo);
                                $comment = $ctrl->getCommentList($this->pdo);
                                if (isset($_SESSION["message"]))
                                    $message = $_SESSION["message"];
                            }
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                        header('Location: index.php?page=gallery');
                    }
                    require('views/messageView.php');
                    unset($_SESSION["message"]);
                    require('views/imageDetailView.php');
                    break;
            case ($page === "viewImageDetails"):
                    try 
                        {
                            if (isset($_POST['view']))
                                {
                                    $ctrlComment = new controllerComment();
                                    $ctrl = new controllerImage();
                                    $pic = $ctrl->getImageDetailPage($this->pdo);
                                    $comment = $ctrlComment->getCommentList($this->pdo);
                                    if (isset($_SESSION["message"]))
                                        $message = $_SESSION["message"];
                                }
                        } catch (Exception $e)
                        {
                            $errors = $e->getMessage();
                            header('Location: index.php?page=gallery');
                        }
                        require('views/messageView.php');
                        unset($_SESSION["message"]);
                        require('views/imageDetailView.php');
                        break;
            case ($page === "uploadMergeImg"):
                $this->accessControl("notlogged");
                try 
                    {
                        if(isset($_POST['submit']))
                        {
                            $ctrl = new controllerImage();
                            $ctrl->uploadMergeImg($this->pdo);
                        }
                    } catch (Exception $e)
                    {
                        $errors = $e->getMessage();
                    }
                    /*
                    * we still need to retrieve the list of miniatures images even if merge return error
                    * that's why we have another try catch block
                    */
                    try {
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
            case ($page === "deleteImg"):
                $this->accessControl("notlogged");
                try 
                    {
                        if(isset($_POST['imgToDelete']))
                        {
                            $ctrl = new controllerImage();
                            $ctrl->deleteImage($this->pdo);
                            $pics = $ctrl->getLoggedUserImages($this->pdo);
                            $count = count($pics);
                            if (isset($_SESSION["message"]))
                                $message = $_SESSION["message"];
                            }    
                        } catch (Exception $e)
                        {
                            $errors = $e->getMessage();
                            header('Location: index.php?page=upload');
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