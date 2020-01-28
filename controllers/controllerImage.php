<?php
require_once('models/imageManager.php');
class controllerImage {

    public function uploadMergeImg($pdo){ 
       $upload = new ImageManager();
       $upload->uploadImage($pdo);
    }

    public function getLoggedUserImages($pdo) {
        $images = new ImageManager();
        return $images->getUserImages($pdo);
    }

    public function deleteImage($pdo, $imgId, $imgName) {
        $images = new ImageManager();
        return $images->deleteUserImages($pdo, $imgId, $imgName);
    }


    public function getTotalPages($pdo) {
        $images = new ImageManager();
        $total = $images->getCountImages($pdo);
        $imagePerPage = 4;
        $nbrPages = ceil($total / $imagePerPage);
        return $nbrPages;
    }

    public function getGalleryPage($pdo, $nbr) {
        $images = new ImageManager();
        $nbrPages = $this->getTotalPages($pdo);
        $imagePerPage = 6;
        if (isset($nbr))
        {
            if ($nbr > $nbrPages)
                $currentPage = $nbrPages;
            else
                $currentPage = $nbr;
        } else {
            $currentPage = 1;
        }
        //print_r($currentPage);
        $pics = $images->getPageImages($pdo, $currentPage, $imagePerPage);
        //print_r($pics);
        return $pics;
    }

    public function getImageDetailPage($pdo, $imgId)
    {
        $image = new ImageManager();
        $pic = $image->getImageById($pdo, $imgId);
       // print_r($pic);
        return $pic[0];
    }

    public function getLikeStatus()
    {
        $image = new ImageManager();
        // if (!$image->isLiked($pdo, $imageId, $ownerId)){
        // }else {

        // }
    }

    public function addLikeToImage($pdo, $imageId, $ownerId, $ownerUsername, $ownerEmail)
    {
        $image = new ImageManager();
        if (!$image->isLiked($pdo, $imageId, unserialize($_SESSION['user'])->getId()))
        {
            $image->addImageLike($pdo, $imageId);
            if ($_POST['notify'] === 'ON') {
                $subject = "Camagru: Like Notification";
                $body = 'Hi '. $ownerUsername . '<br> The user '. unserialize($_SESSION['user'])->getUsername() .' liked your picture. <br>';
                $sendEmail = new EmailManager();
                $sendEmail->sendEmail($ownerEmail, $subject, $body);
            }
        }    
        else {
            $image->delImageLike($pdo, $imageId);
            if ($_POST['notify'] === 'ON') {
                $subject = "Camagru: Unlike Notification";
                $body = 'Hi '. $ownerUsername . '<br> The user '. unserialize($_SESSION['user'])->getUsername() .' unliked your picture. <br>';
                $sendEmail = new EmailManager();
                $sendEmail->sendEmail($ownerEmail, $subject, $body);
            }
        }
    }
}