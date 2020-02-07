<?php
require_once('models/Validation.php');
class ImageManager {

   public function saveToDB($pdo, $fileName, $path, $title, $description)
   {
        $validation = new Validation();
        if ($title != '' || $description != '')
        {
            $title = $validation->validateStringOrigin($title);
            $description = $validation->validateStringOrigin($description);
        }
        $id_user = unserialize($_SESSION['user'])->getId();
        $query = "INSERT INTO picture (id_user, name, img_path, title, description, creation_date) VALUES (?, ?, ?, ?, ?, NOW())";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$id_user, $fileName, $path, $title, $description]))
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

   public function getCountImages($pdo)
   {
        $query = "SELECT count(*) AS totalImages from picture";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute())
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            $count = $Statement->fetch();
            return $count['totalImages'];
        }
   }

   public function getPageImages($pdo, $currentPage, $imagePerPage)
   {
        isset($_SESSION['loggedIn']) ? $id_user = unserialize($_SESSION['user'])->getId(): $id_user = '';
        $picLimit = ($currentPage - 1) * $imagePerPage;
        $query = 'SELECT p.id as picId, p.name, p.img_path, p.creation_date, u.id as userId, u.firstName, u.lastName,
        u.username, u.email, u.notify, (SELECT count(id_picture) FROM picture_like WHERE id_picture = p.id) countLikes,
        (SELECT count(comment) FROM comment WHERE id_picture = p.id) countComments,
        (SELECT count(*) FROM picture_like WHERE id_picture = p.id AND id_user = ?) isLiked
        FROM picture p
        INNER JOIN user_account u ON u.id = p.id_user
        ORDER BY p.creation_date DESC LIMIT ? , ?';
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$id_user, $picLimit, $imagePerPage]))
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            $pics = $Statement->fetchAll();
            return $pics;
        }
   }

   public function getImageById($pdo, $imgId)
   {
        isset($_SESSION['loggedIn']) ? $id_user = unserialize($_SESSION['user'])->getId(): $id_user = '';
        $query = 'SELECT p.id as picId, p.name, p.img_path, p.title, p.description, p.creation_date, u.id as userId, u.firstName, u.lastName,
        u.username, u.email, u.notify, (SELECT count(id_picture) FROM picture_like WHERE id_picture = p.id) countLikes,
        (SELECT count(*) FROM picture_like WHERE id_picture = p.id AND id_user = ?) isLiked
        FROM picture p
        INNER JOIN user_account u ON u.id = p.id_user AND p.id = ?';
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$id_user, $imgId]))
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            $pics = $Statement->fetchAll();
            return $pics;
        }
   }

   public function isLiked($pdo, $picId, $userId) 
   {
        $query = "SELECT * from picture_like WHERE id_picture = ? AND id_user = ?";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$picId, $userId]))
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            if ($Statement->rowcount() == 0)
                return 0;
            else 
                return 1;
        }
   }

   public function addImageLike($pdo, $picId) 
   {
        $id_user = unserialize($_SESSION['user'])->getId();
        $query = "INSERT INTO picture_like (id_user, id_picture) VALUES (?, ?)";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$id_user, $picId]))
        {
            throw new Exception('Error, Please Try Again!');
        } 
   }

   public function delImageLike($pdo, $picId) 
   {
        $id_user = unserialize($_SESSION['user'])->getId();
        $query = "DELETE FROM picture_like WHERE id_picture = ? AND id_user = ?";
        $Statement=$pdo->prepare($query);
        if(!$Statement->execute([$picId, $id_user]))
        {
            throw new Exception('Error, Please Try Again!');
        } 
   }

   public function getImageLike($pdo)
   {
        $query = "SELECT like_nbr from picture_like WHERE id_picture = ?";
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute())
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            $count = $Statement->fetch();
            return $count['like_nbr'];
        }
   }
}