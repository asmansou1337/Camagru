<?php
require_once('models/commentManager.php');
class controllerComment {

   public function addNewComment($pdo)
   {
        if (isset($_POST['comment']) && !empty($_POST['comment'])){
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
        }
   }

   public function getCommentList($pdo)
   {
          $picId = $_POST['picId'];
          $cm = new CommentManager();
          return $cm->getCommentsByPic($pdo, $picId);
   }

   public function delSelectedComment($pdo)
   {
        if(isset($_POST['CommentId'])){
          $cm = new CommentManager();
          $cm->deleteComment($pdo, $_POST['CommentId']);
        }
   }
}