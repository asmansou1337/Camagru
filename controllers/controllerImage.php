<?php
require_once('models/imageManager.php');
class controllerImage {

    public function createImage($uploadedImage, $upload_dir, $type, $filename)
    {
        $uploadedImage = str_replace('data:image/'.$type.';base64,', '', $uploadedImage);
        $uploadedImage = str_replace(' ', '+', $uploadedImage);
        $data = base64_decode($uploadedImage);
        $file = $upload_dir .$filename.'.'.$type;
        file_put_contents($file, $data);
        if (filesize($file) > 50000000)
            throw new Exception("Image size should not be over 50 MB.!");
        $func = 'imagecreatefrom'.$type;
        $result = $func($file);
        return $result;
    }

    public function uploadMergeImg($pdo){
        if (!file_exists('uploads')) {
            mkdir('uploads', 0775, true);
        }
        $upload_dir = 'uploads/';
        $upload = new ImageManager();
        if (isset($_POST['imgToSend']) && $_POST['imgToSend'] != '') {
            $uploadedImage = $_POST['imgToSend'];
            if (@getimagesize($uploadedImage) == false)
                throw new Exception("Invalid Image, Please Try Again!");
            $imageSize = getimagesize($uploadedImage);
            if (isset($_POST['filterpp']) && !empty($_POST['filterpp'])){
                $filterImg = $_POST['filterpp'];
                if (@getimagesize($filterImg) == false)
                    throw new Exception("Invalid Filter, Please Try Again!");
                list($filterWidth, $filterHeight) = getimagesize($filterImg);
                // $filterWidth = $_POST['filterWidth'];
                // $filterHeight = $_POST['filterHeight'];
                $finalFilter = $this->createImage($filterImg, $upload_dir, 'png', 'filter');
                if ($imageSize['mime'] == 'image/jpeg' || $imageSize['mime'] == 'image/jpg')
                {
                    $result = $this->createImage($uploadedImage, $upload_dir, 'jpeg', 'tempImage');
                    imagecopy($result, $finalFilter, 0, 0, 0, 0, $filterWidth, $filterHeight);
                    $fileName = date('m-d-', time()).uniqid();
                    $fileDestination = $upload_dir . $fileName.'.jpeg';
                    imagejpeg($result, $fileDestination);
                    unlink($upload_dir.'filter.png');
                    unlink($upload_dir.'tempImage.jpeg');
                } else if ($imageSize['mime'] == 'image/png') {
                    $result = $this->createImage($uploadedImage, $upload_dir, 'png', 'tempImage');
                    imagecopy($result, $finalFilter, 0, 0, 0, 0, $filterWidth, $filterHeight);
                    $fileName = date('m-d-', time()).uniqid();
                    $fileDestination = $upload_dir . $fileName.'.png';
                    imagepng($result, $fileDestination);
                    unlink($upload_dir.'filter.png');
                    unlink($upload_dir.'tempImage.png');
                } else
                    throw new Exception("Only the following extentions are allowed: PNG, JPG, JPEG!");
                    // upload image info to DB
                    if (isset($_POST['title']) && isset($_POST['description']))
                    {
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $upload ->saveToDB($pdo, $fileName, $fileDestination, $title, $description);
                    }
            } else 
                throw new Exception("Error Reading Filter, Please Try Again!");
        } else
            throw new Exception("Error Reading Image, Please Try Again!");
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
        $imagePerPage = 6;
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
            else if ($nbr < 1) {
                $currentPage = 1;
            } else
                $currentPage = $nbr;
        } else {
            $currentPage = 1;
        }
        $pics = $images->getPageImages($pdo, $currentPage, $imagePerPage);
        return $pics;
    }

    public function getImageDetailPage($pdo)
    {
        $imgId = $_POST['picId'];
        $image = new ImageManager();
        if (isset($imgId) && !empty($imgId)){
            $pic = $image->getImageById($pdo, $imgId);
            return $pic[0];
        } else
            throw new Exception("Error, Please Try Again!");
    }


    public function addLikeToImage($pdo)
    {
        $image = new ImageManager();
        $imageId = $_POST['picId'];
        $ownerUsername = $_POST['ownerUsername'];
        $ownerEmail = $_POST['ownerEmail'];
        if (isset($imageId) && isset($ownerUsername) && isset($ownerEmail) && isset($_POST['notify']) 
        && !empty($imageId) && !empty($ownerUsername) && !empty($ownerEmail) && !empty($_POST['notify'])) {
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
        } else {
            throw new Exception("Error, Please Try Again!");
        }
    }
}