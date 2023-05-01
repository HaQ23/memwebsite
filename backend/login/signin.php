<?php

    if(isset($_POST['user-signin-submit'])) {
        require_once "../database/database.php";
        require_once "../utils/functions.php";
        $userLogin = $_POST['login-user'];
        $userPwd = $_POST['user-password'];

        if(!checkSignInFormInputs($userLogin, $userPwd)) {
            header('location: ../../signIn.php?error=emptyfields');
            exit();
        }

        loginUser($conn, $userLogin, $userPwd);
    } else {
        header("location: ../../signIn.php");
        exit();
    }


?>