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
}