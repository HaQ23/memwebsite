<?php
/**
 * @file
 * Niezbędne funkcje potrzebne do poprawnego działania systemu Logowania oraz Rejestracji
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * @brief Sprawdza poprawność wprowadzonych danych rejestracji.
 *
 * @param[in] $userName - Nazwa użytkownika.
 * @param[in] $userSurrname - Nazwisko użytkownika.
 * @param[in] $userNickname - Nick użytkownika.
 * @param[in] $userDateOfBirth - Data urodzenia użytkownika.
 * @param[in] $userEmail - Adres e-mail użytkownika.
 * @param[in] $userPwd - Hasło użytkownika.
 * @param[in] $userPwdRepeat - Powtórzone hasło użytkownika.
 *
 * @return bool - Wartość true, jeśli dane są poprawne; w przeciwnym razie false.
 */
function checkSignUpFormInputs($userName, $userSurrname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userPwdRepeat) {
    $result = true;
    if(empty($userName) || empty($userSurrname) || empty($userNickname) || empty($userDateOfBirth) || empty($userEmail) || empty($userPwd) || empty($userPwdRepeat)) {
        $result = false;
    }
    return $result;
}

/**
 * @brief Sprawdza poprawność wprowadzonych danych logowania.
 *
 * @param[in] $userLogin - Login użytkownika.
 * @param[in] $userPwd - Hasło użytkownika.
 *
 * @return bool - Wartość true, jeśli dane są poprawne; w przeciwnym razie false.
 */
function checkSignInFormInputs($userLogin, $userPwd) {
    $result = true;
    if(empty($userLogin) || empty($userPwd)) {
        $result = false;
    }
    return $result;
}

/**
 * @brief Sprawdza poprawność nazwy użytkownika.
 *
 * @param[in] $userName - Nazwa użytkownika.
 *
 * @return bool - Wartość true, jeśli nazwa użytkownika jest poprawna; w przeciwnym razie false.
 */
function checkUsername($userName) {
    $result = true;

    if(!preg_match("/^[a-zA-Z0-9]*$/", $userName)) {
        $result = false;
    }
    return $result;
}

/**
 * @brief Sprawdza poprawność adresu e-mail.
 *
 * @param[in] $userEmail - Adres e-mail użytkownika.
 *
 * @return bool - Wartość true, jeśli adres e-mail jest poprawny; w przeciwnym razie false.
 */
function checkEmail($userEmail) {
    $result = true;

    if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $result = false;
    }
    return $result;
}

/**
 * @brief Sprawdza, czy wprowadzone hasła są zgodne.
 *
 * @param[in] $userPwd - Hasło użytkownika.
 * @param[in] $userPwdRepeat - Powtórzone hasło użytkownika.
 *
 * @return bool - Wartość true, jeśli hasła są zgodne; w przeciwnym razie false.
 */
function checkPwdMatch($userPwd, $userPwdRepeat) {
    $result = true;

    if($userPwd !== $userPwdRepeat) {
        $result = false;
    }
    return $result;
}

/**
 * @brief Sprawdza, czy użytkownik o podanej nazwie użytkownika lub adresie e-mail już istnieje w bazie danych.
 *
 * @param[in] $conn - Połączenie z bazą danych.
 * @param[in] $userName - Nazwa użytkownika.
 * @param[in] $userEmail - Adres e-mail użytkownika.
 *
 * @return array|bool - Tablica zawierająca dane użytkownika, jeśli istnieje; w przeciwnym razie false.
 */
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

/**
 * @brief Tworzy nowego użytkownika w bazie danych.
 *
 * @param[in] $conn - Połączenie z bazą danych.
 * @param[in] $userName - Nazwa użytkownika.
 * @param[in] $userSurrname - Nazwisko użytkownika.
 * @param[in] $userNickname - Nick użytkownika.
 * @param[in] $userDateOfBirth - Data urodzenia użytkownika.
 * @param[in] $userEmail - Adres e-mail użytkownika.
 * @param[in] $userPwd - Hasło użytkownika.
 * @param[in] $userRole - Rola użytkownika.
 * @param[in] $userCreateDate - Data utworzenia użytkownika.
 *
 * @return void
 */
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

    header('location: ../../index.php?signUp=success');
    exit();
}

/**
 * @brief Loguje użytkownika.
 *
 * @param[in] $conn - Połączenie z bazą danych.
 * @param[in] $userLogin - Login użytkownika.
 * @param[in] $userPwd - Hasło użytkownika.
 *
 * @return void
 */
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
        $_SESSION['role'] = $userExists['role'];
        header("location: ../../index.php?login=success");
        exit();
    }
}
?>
