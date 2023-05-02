<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    function checkSignUpFormInputs($userName, $userSurrname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userPwdRepeat) {
        $result = true;
        if(empty($userName) || empty($userSurrname) || empty($userNickname) || empty($userDateOfBirth) || empty($userEmail) || empty($userPwd) || empty($userPwdRepeat)) {
            $result = false;
        }
        return $result;
    }

    function checkSignInFormInputs($userLogin, $userPwd) {
        $result = true;
        if(empty($userLogin) || empty($userPwd)) {
            $result = false;
        }
        return $result;
    }


    function checkUsername($userName) {
        $result = true;

        if(!preg_match("/^[a-zA-Z0-9]*$/", $userName)) {
            $result = false;
        }
        return $result;
    }
    function checkEmail($userEmail) {
        $result = true;

        if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        return $result;
    }

    function checkPwdMatch($userPwd, $userPwdRepeat) {
        $result = true;

        if($userPwd !== $userPwdRepeat) {
            $result = false;
        }
        return $result;
    }
    function checkIfUserExists($conn, $userName, $userEmail) {
        $sql = "SELECT * FROM account WHERE nick = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
         header('location: ../../signUp.php?error=stmterror1');
         exit();
        } 
        mysqli_stmt_bind_param($stmt, "ss", $userName, $userEmail);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        } else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }
    function createUser($conn, $userName, $userSurrname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userRole, $userCreateDate) {
        $sql = "INSERT INTO account (nick, name, surrname, email, password, birth_date, creation_date, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header('location: ../../signUp.php?error=stmterror2');
            exit();
        }
        $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssssssss", $userNickname, $userName, $userSurrname, $userEmail, $hashedPwd, $userDateOfBirth, $userCreateDate, $userRole);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('location: ../../signUp.php?signup=success');
        exit();
    }

    function loginUser($conn, $userLogin, $userPwd) {
        $userExists = checkIfUserExists($conn, $userLogin, $userLogin);

        if(!$userExists) {
            header("location: ../../signIn.php?error=wronglogin");
            exit();
        }
        $userPwdHashed = $userExists["password"];
        $checkPwd = password_verify($userPwd, $userPwdHashed);

        if($checkPwd === false) {
            header("location: ../../signIn.php?error=wrongpassword");
            exit();
        } else {
            session_start();
            $_SESSION['userid'] = $userExists['id_user'];
            $_SESSION['username'] = $userExists['nick'];
            header("location: ../../index.php?login=success");
            exit();
        }
    }
?>