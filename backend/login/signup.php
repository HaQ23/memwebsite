<?php


    if(isset($_POST['user-signup-submit'])) {
        require_once "../database/database.php";
        require_once "../utils/functions.php";
        $userName = $_POST['name-user'];
        $userSurrname = $_POST['surrname-user'];
        $userNickname = $_POST['nick-user'];
        $userDateOfBirth = $_POST['data-of-birth-user'];
        $userEmail = $_POST['email-user'];
        $userPwd = $_POST['user-password'];
        $userPwdRepeat = $_POST['user-password-repeat'];
        $userRole = "user";
        $userCreateDate = date("Y/m/d");

        if(!checkSignUpFormInputs($userName, $userSurrname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userPwdRepeat)) {
            header('location: ../../signUp.php?error=emptyfields');
            exit();
        }
        if(!checkUsername($userName)) {
            header('location: ../../signUp.php?error=username');
            exit();
        }
        if(!checkEmail($userEmail)) {
            header('location: ../../signUp.php?error=email');
            exit();
        }
        if(!checkPwdMatch($userPwd, $userPwdRepeat)) {
            header('location: ../../signUp.php?error=pwd');
            exit();
        }
        if(checkIfUserExists($conn, $userName, $userEmail)) {
            header('location: ../../signUp.php?error=userexists');
            exit();
        }

        createUser($conn, $userName, $userSurrname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userRole, $userCreateDate);

    } else {
        header('location: ../../signUp.php');
        exit();
    }

?>