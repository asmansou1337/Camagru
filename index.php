<?php
$title = 'Hello';
//require('views/header.php');
//require('views/messageView.php');
//require('views/signUpView.php');
//require('views/homeView.php');
//require('views/loginView.php');
//require('views/reinitialisationEmailView.php');
//require('views/reinitialisationPasswordView.php');
//require('views/editProfileView.php');
//require('views/editPasswordView.php');
//require('views/notificationView.php');
//require('views/galleryView.php');
//require('views/footer.php');
require('controllers/controller.php');
require('config/setup.php');

//try {
    require('config/database.php');
    $pdoDB = new PDO($DSN_1, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
    $setupDB = new Setup($pdoDB);
    $setupDB->createDB();
    $pdo = new PDO($DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
    $setup = new Setup($pdo);
    $setup->createTables();
    $ctrl = new Controller($pdo);
    $ctrl->index();
/*} catch (Exception $e) {
    //echo 'Error : '.  $e->getMessage(). "\n";
    print_r($e->getMessage());
}*/
