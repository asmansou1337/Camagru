<?php
require_once('models/commentManager.php');
class controllerComment {

   public function addNewComment($pdo)
   {
        if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_POST['picId']) && !empty($_POST['picId']) && 
        isset($_POST['ownerUsername']) && !empty($_POST['ownerUsername']) && isset($_POST['ownerEmail']) && !empty($_POST['ownerEmail']) && 
        isset($_POST['notify']) && !empty($_POST['notify'])){
            $comment = trim($_POST['comment']);
            $userId = unserialize($_SESSION['user'])->getId();
            $cm = new CommentManager();
            $cm->addComment($pdo, $_POST['picId'], $userId, $comment);
            // send email if notification is ON
            if ($_POST['notify'] === 'ON') {
               $subject = "Camagru: Comment Notification";
               $body = 'Hi '. $_POST['ownerUsername'] . '<br> The user '. unserialize($_SESSION['user'])->getUsername() .' commented on your picture. <br>';
               $sendEmail = new EmailManager();
               $sendEmail->sendEmail($_POST['ownerEmail'], $subject, $body);
           }
        } else
            throw new Exception("Error, Please Try Again!");
   }

   public function getCommentList($pdo)
   {
          $picId = $_POST['picId'];
          if (isset($picId) && !empty($picId)){
          $cm = new CommentManager();
            return $cm->getCommentsByPic($pdo, $picId);
         } else
            throw new Exception("Error, Please Try Again!");
   }

   public function delSelectedComment($pdo)
   {
        if(isset($_POST['CommentId']) && !empty($_POST['CommentId'])){
          $cm = new CommentManager();
          $cm->deleteComment($pdo, $_POST['CommentId']);
        } else
            throw new Exception("Error, Please Try Again!");
   }
}