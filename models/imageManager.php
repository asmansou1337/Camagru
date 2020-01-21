<?php
class ImageManager {
   public function uploadImage($pdo)
   {
        if (!file_exists('uploads')) {
            mkdir('uploads', 0775, true);
        }
        $upload_dir = 'uploads/';
        $img = $_POST['imgToSend'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        // $fileName = date('Y-m-d-H:i:s', time());
        $fileName = date('m-d-', time()).uniqid();
        $file = $upload_dir.$fileName.'.png';
        $success = file_put_contents($file, $data);
        if (!$success)
        {
            throw new Exception("Error Uploading the image to server, Please try again !");
        } else
            $this->saveToDB($pdo, $fileName, $file);
   }

   public function saveToDB($pdo, $fileName, $path)
   {
        $id_user = unserialize($_SESSION['user'])->getId();
        $query = "INSERT INTO picture (id_user, name, img_path, creation_date) VALUES (?, ?, ?, NOW())";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$id_user, $fileName, $path]))
        {
            throw new Exception('Error Uploading the image, Please Try Again!');
        } 
   }

   public function getUserImages($pdo)
   {
        $id_user = unserialize($_SESSION['user'])->getId();
        $query = "SELECT * from picture WHERE id_user = ? ORDER BY creation_date DESC";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$id_user]))
        {
            throw new Exception('Error Uploading the image, Please Try Again!');
        } else {
            $data = $Statement->fetchAll();
            //print_r($data);
            return $data;
        }
   }

   public function deleteUserImages($pdo, $id, $name)
   {
        $query = "DELETE FROM picture WHERE id = ?";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$id]))
        {
            throw new Exception('Error Deleting the image, Please Try Again!');
        } else {
            unlink($name);
        }
   }
}