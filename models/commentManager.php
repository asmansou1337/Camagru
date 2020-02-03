<?php
require_once('models/Validation.php');

class CommentManager {
   public function addComment($pdo, $picId, $userId, $comment)
   {
    $val = new Validation();
    $comment = $val->validateStringOrigin($comment);
    $query = "INSERT INTO comment (id_user, id_picture, comment, creation_date) VALUES (?, ?, ?, NOW())";
    $Statement = $pdo->prepare($query);
    if(!$Statement->execute([$userId, $picId, $comment]))
    {
        throw new Exception('Error, Please Try Again!');
    }
   }

   public function getCommentsByPic($pdo, $imgId)
   {
        //$id_user = unserialize($_SESSION['user'])->getId();
        $query = 'SELECT c.id as commentId, c.comment, c.creation_date, u.id as userId, u.firstName, u.lastName,
        u.username, u.email, u.notify, (SELECT count(comment) FROM comment WHERE id_picture = ?) countComments
        FROM comment c
        INNER JOIN user_account u ON u.id = c.id_user AND c.id_picture = ?
        ORDER BY c.creation_date DESC';
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$imgId, $imgId]))
        {
            throw new Exception('Error, Please Try Again!');
        } else {
            $pics = $Statement->fetchAll();
            //print_r($pics);
            return $pics;
        }
   }

   public function deleteComment($pdo, $commentId)
   {
        $query = 'DELETE FROM comment WHERE id = ?';
        $Statement = $pdo->prepare($query);
        if(!$Statement->execute([$commentId]))
        {
            throw new Exception('Error, Please Try Again!');
        }
   }
}

?>