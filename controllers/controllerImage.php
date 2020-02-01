<?php
require_once('models/imageManager.php');
class controllerImage {

    function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        return $dst;
    }

    function resize($file, $imgpath, $type, $width, $height){
        /* Get original image x y*/
        list($w, $h) = getimagesize($file);
        /* calculate new image size with ratio */
        $ratio = max($width/$w, $height/$h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
    
        /* new file name */
        $path = $imgpath;
        /* read binary data from image file */
        $imgString = file_get_contents($file);
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);
        imagecolortransparent($image, imagecolorat($image,0,0));
        imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
        /* Save image */
        switch ($type) {
           case 'image/jpeg':
              imagejpeg($tmp, $path, 100);
              break;
           case 'image/png':
              imagepng($tmp, $path, 0);
              break;
           case 'image/gif':
              imagegif($tmp, $path);
              break;
              default:
              //exit;
              break;
            }
         return $path;
    
         /* cleanup memory */
         imagedestroy($image);
         imagedestroy($tmp);
    }

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

        $filterImg = $_POST['filterpp'];
        



        //  print_r("width ".$_POST['imgUploadedWidth']);
        //  print_r("height ".$_POST['imgUploadedHeight']);
        
        //list($filterWidth, $filterHeight) = getimagesize($filterImg);
        list($picWidth, $picHeight) = getimagesize($fileTmpName);
        // $ss = ceil($_POST['imgUploadedWidth'] / 3);
        // $sy = ceil($picHeight / 3);
       // $filterPng = $this->resize_image($filterImg, $_POST['imgUploadedWidth'] / 3, $_POST['imgUploadedWidth'] / 3);
        
        //print_r(getimagesize($filterImg));
        //$filterresize = $this->resize($filterImg, $upload_dir.'filter1.png', 'image/png', $ss, $ss);
        
        $filterImg = str_replace('data:image/png;base64,', '', $filterImg);
        //print_r($filterImg);
        $filterImg = str_replace(' ', '+', $filterImg);
        $data = base64_decode($filterImg);
        $file = $upload_dir . uniqid() . '.png';
	    $success = file_put_contents($file, $data);
    

        //list($filterWidth, $filterHeight) = getimagesize($filterresize);
        //$pp = file_put_contents($upload_dir.'myFilter.png', $data);
        $newFilter = imagecreatefromstring($data);
        
        list($filterWidth, $filterHeight) = getimagesize($newFilter);
        if ($fileType == 'image/jpeg')
        {
           // print_r(base64_encode(file_get_contents($filterImg)));
            $image1 = imagecreatefromstring(file_get_contents($fileTmpName));
            //$image2 = imagecreatefromstring(file_get_contents($filterresize));
            $merged_image = imagecreatetruecolor($picWidth, $picHeight);
            imagealphablending($merged_image, false);
            imagesavealpha($merged_image, true);

            imagecopy($merged_image, $image1, 0, 0, 0, 0, $picWidth, $picHeight);
            // after first time of "imagecopy" change "imagealphablending"
            imagealphablending($merged_image, true);
            // imagesavealpha($image2, true);
    //         // imagecolortransparent($image2, imagecolorat($image2,0,0));
            imagecopy($merged_image, $newFilter, 50, 50, 0, 0, $filterWidth, $filterHeight);
            imagejpeg($merged_image, $upload_dir.'atest.png');


    //         $image1 = imagecreatefromstring(file_get_contents($fileTmpName));
    //         $image2 = imagecreatefromstring(file_get_contents($filterImg));
    //         $ff = imagecreatefrompng($filterImg);
    //         $output = imagecreatetruecolor($_POST['imgUploadedWidth'] / 3, $_POST['imgUploadedWidth'] / 3);
    //         imagecopy($output, $ff, 0,0, $_POST['imgUploadedWidth'] / 3,$_POST['imgUploadedWidth'] / 3, $filterWidth,$filterHeight);
    //         imagepng($output, $upload_dir.'filter.png');
    //         $image3 = imagecreatetruecolor($ss, $ss);


    //         // imagesavealpha($image2, true);
    //         // imagecolortransparent($image2, imagecolorat($image2,0,0));
    //        // imagesavealpha($image2, true);
    //         // imagecolortransparent($image2, imagecolorat($image2,0,0));
    //         // imagesavealpha($image3, true);
    //         //  imagecolortransparent($image3, imagecolorat($image3,0,0));
           
    //          imagesavealpha($image2, true);
    //          imagecolortransparent($image2, imagecolorat($image2,0,0));
    //         //   imagesavealpha($image3, true);
    //         //   imagecolortransparent($image3, imagecolorat($image3,0,0));
    //         //  imagecopyresized ($image3, $image2 , 0 , 0 , 0 , 0 ,  $ss , $ss ,$filterWidth , $filterHeight);
    //         // imagecolortransparent($image2, imagecolorat($image2,0,0));
    //         imagecopymerge($image1, $image2, 50, 50, 0, 0, $filterWidth, $filterHeight, 100);
    // //         $filterPng = imagecreatefrompng($filterImg);
    // //         //imagecopyresized ( $filterPng, $filterPng , 0 , 0 , 0 , 0 ,  $ss , $ss ,$filterSize[0] , $filterSize[1]);
    // //    $imgPng = imagecreatefromjpeg($fileTmpName);
    // //    $imgSize = getimagesize($fileTmpName);
    // //    $pos = $imgSize[0] / 3;
    // //    imagesavealpha($filterPng, true);
    // //     imagecolortransparent($filterPng, imagecolorat($filterPng,0,0));
    // //    //imagecopymerge($imgPng, $filterPng, 0, 0, 0, 0, $filterSize[0], $filterSize[1], 100);
    // //    imagecopyresized ( $imgPng, $filterPng , 50 , 50 , 0 , 0 ,  $imgSize[0] , $imgSize[1] ,$filterWidth , $filterHeight);
        
    
    } else if ($fileType == 'image/png') {


    //         $filterPng = imagecreatefrompng($filterImg);
    //    $imgPng = imagecreatefrompng($fileTmpName);
    //    imagesavealpha($filterPng, true);
    //     imagecolortransparent($filterPng, imagecolorat($filterPng,0,0));
    //    imagecopymerge($imgPng, $filterPng, 0, 0, 0, 0, $filterWidth, $filterHeight, 100);
        }

    //    imagealphablending($imgPng, false);
    //     imagesavealpha($imgPng, true);
        // print_r("create filter " .getimagesize($filterPng));
        // print_r("create img " .getimagesize($imgPng));

//         $final_img = imagecreate(800, 720); // where x and y are the dimensions of the final image

// $image_1 = imagecreatefrompng($fileTmpName);
// $image_2 = imagecreatefrompng($filterImg);
// imagecopy($final_img, $image_1, 0, 0, 0, 0, $_POST['imgUploadedWidth'], $_POST['imgUploadedHeight']);
// //imagecopy($final_img, $image_2, 0, 0, 0, 0, $_POST['imgUploadedWidth'] / 3, $_POST['imgUploadedWidth'] / 3);

// imagealphablending($final_img, false);
// imagesavealpha($final_img, true);
        //$data = base64_decode($imgPng);

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 50000000) {
                    $fileName = date('m-d-', time()).uniqid();
                    $fileDestination = $upload_dir.$fileName.'.png';
                    // need to add mkdir of upload if not exist
                   // imagepng($imgPng, $fileDestination);

                   // imagepng($image1, $fileDestination);



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