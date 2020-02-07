<?php
    $title = 'Home';
    require('controllers/controller.php');
    require('config/setup.php');
    require('config/database.php');
    $pdoDB = new PDO($DSN_1, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
    $setupDB = new Setup($pdoDB);
    $setupDB->createDB();
    $pdo = new PDO($DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
    $setup = new Setup($pdo);
    $setup->createTables();
    $ctrl = new Controller($pdo);
    $ctrl->index();
