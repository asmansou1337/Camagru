<?php
require_once('models/commentManager.php');
require_once('models/imageManager.php');
class controllerComment {

   public function addNewComment($pdo)
   {
        if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_POST['picId']) && !empty($_POST['picId'])){
            $comment = trim($_POST['comment']);
            $userId = unserialize($_SESSION['user'])->getId();
            $cm = new CommentManager();
            $cm->addComment($pdo, $_POST['picId'], $userId, $comment);
            $image = new ImageManager();
            $infos = $image->getImageOwnerInfo($pdo, $_POST['picId']);
            $ownerUsername = $infos['username'];
            $ownerEmail = $infos['email'];
            $notify = $infos['notify'];
            // send email if notification is ON
            if ($notify === 'ON') {
               $subject = "Camagru: Comment Notification";
               $body = 'Hi '. $ownerUsername . '<br> The user '. unserialize($_SESSION['user'])->getUsername() .' commented on your picture. <br>';
               $sendEmail = new EmailManager();
               $sendEmail->sendEmail($ownerEmail, $subject, $body);
           }
        } else
            throw new Exception("Error, Please Try Again!");
   }

   public function getCommentList($pdo)
   {
          $picId = $_SESSION['pic'];
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