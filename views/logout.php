<?php

    include_once 'helpers/user_session.php';

    $userSession = new UserSession();
    $userSession->closeSession();

    header("location: index.php");


?>
