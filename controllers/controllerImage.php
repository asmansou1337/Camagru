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

    public function getGalleryPage($pdo) {
        $images = new ImageManager();
        $nbrPages = $this->getTotalPages($pdo);
        $imagePerPage = 4;
        if (isset($_POST['nbr']))
        {
            if ($_POST['nbr'] > $nbrPages)
                $currentPage = $nbrPages;
            else
                $currentPage = $_POST['nbr'];
        } else {
            $currentPage = 1;
        }
        $pics = $images->getPageImages($pdo, $currentPage, $imagePerPage);
        //print_r($pics);
        return $pics;
    }
}