<?php
require_once('models/imageManager.php');
class controllerImage {

    public function uploadMergeImg($pdo){ 
        if (!file_exists('uploads')) {
            mkdir('uploads', 0775, true);
        }
        $upload_dir = 'uploads/';
       $upload = new ImageManager();
    //    print_r('image src -- ');
    //    print_r($_FILES['localImage']);
    //    print_r('image filter -- ');
    //    print_r($_POST['img_filter']);
    //    print_r(base64_encode($_FILES['localImage']['tmp_name']));
       $fileName = $_FILES['localImage']['name'];
       $fileTmpName = $_FILES['localImage']['tmp_name'];
        $fileSize = $_FILES['localImage']['size'];
        $fileError = $_FILES['localImage']['error'];
        $fileType = $_FILES['localImage']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $filterImg = $_POST['img_filter'];

       // $filterPng = imageCreateFromPng($filterImg);
       // $imgPng = imageCreateFromPng($fileTmpName);
      //  imagecopy($imgPng, $filterPng, 0, 0, 0, 0, 120, 120);


        $final_img = imagecreate(640, 480); // where x and y are the dimensions of the final image

$image_1 = imagecreatefrompng($fileTmpName);
$image_2 = imagecreatefrompng($filterImg);
imagecopy($final_img, $image_1, 0, 0, 0, 0, 640, 480);
imagecopy($final_img, $image_2, 0, 0, 0, 0, 640, 480);

imagealphablending($final_img, false);
imagesavealpha($final_img, true);
        //$data = base64_decode($imgPng);

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 50000000) {
                    $fileName = date('m-d-', time()).uniqid();
                    $fileDestination = $upload_dir.$fileName.'.png';
                    // need to add mkdir of upload if not exist
                   // imagepng($imgPng, $fileDestination);

                    imagepng($final_img, $fileDestination);
                    //file_put_contents($fileDestination, imagepng($imgPng, $fileDestination));
                    //move_uploaded_file($imgPng, $fileDestination);
                    //header("Location: index.php?uploadSucess");
                } else {
                    throw new Exception("Image size should not be over 50 MB.!");
                }
            } else {
                throw new Exception("There was an error uploading your file!! Please Try Again");
            }
        } else {
            throw new Exception("Only the following extentions are allowed: PNG, JPG, JPEG!");
        }

    //    $img = $_FILES['imgUploaded'];
    //     $img = str_replace('data:image/png;base64,', '', $img);
    //     $img = str_replace(' ', '+', $img);
    //     $data = base64_decode($img);
    //     print_r($data);
       //$upload->uploadImage($pdo);
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

    public function getImageDetailPage($pdo)
    {
        $imgId = $_POST['picId'];
        $image = new ImageManager();
        $pic = $image->getImageById($pdo, $imgId);
        return $pic[0];
    }

    public function getLikeStatus()
    {
        $image = new ImageManager();
        // if (!$image->isLiked($pdo, $imageId, $ownerId)){
        // }else {

        // }
    }

    public function addLikeToImage($pdo)
    {
        $image = new ImageManager();
        $imageId = $_POST['picId'];
        $ownerId = $_POST['ownerId'];
        $ownerUsername = $_POST['ownerUsername'];
        $ownerEmail = $_POST['ownerEmail'];
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