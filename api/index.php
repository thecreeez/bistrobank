<?php
    require_once('./database.php');

    $userType = $_POST['userType'];
    $name = $_POST['name'];
    $inn = $_POST['inn'];

    echo serialize($_POST);