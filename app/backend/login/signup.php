<?php
/**
 * @file
 * Skrypt do rejestracji użytkownika.
 */

/**
 * Sprawdzenie, czy formularz rejestracji został przesłany.
 */
if (isset($_POST['user-signup-submit'])) {
    require_once "../database/database.php";
    require_once "../utils/functions.php";
    $userName = $_POST['name-user'];
    $userSurname = $_POST['surname-user'];
    $userNickname = $_POST['nick-user'];
    $userDateOfBirth = $_POST['data-of-birth-user'];
    $userEmail = $_POST['email-user'];
    $userPwd = $_POST['user-password'];
    $userPwdRepeat = $_POST['user-password-repeat'];
    $userRole = "user";
    $userCreateDate = date("Y/m/d");

    /**
     * Sprawdzenie poprawności danych wprowadzonych w formularzu rejestracji.
     */
    if (!checkSignUpFormInputs($userName, $userSurname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userPwdRepeat)) {
        header('location: ../../signUp.php?error=emptyfields');
        exit();
    }
    if (!checkUsername($userName)) {
        header('location: ../../signUp.php?error=username');
        exit();
    }
    if (!checkEmail($userEmail)) {
        header('location: ../../signUp.php?error=email');
        exit();
    }
    if (!checkPwdMatch($userPwd, $userPwdRepeat)) {
        header('location: ../../signUp.php?error=pwd');
        exit();
    }
    if (checkIfUserExists($conn, $userNickname, $userEmail)) {
        header('location: ../../signUp.php?error=userexists');
        exit();
    }

    /**
     * Utworzenie nowego użytkownika.
     */
    createUser($conn, $userName, $userSurname, $userNickname, $userDateOfBirth, $userEmail, $userPwd, $userRole, $userCreateDate);
} else {
    /**
     * Przekierowanie do strony rejestracji w przypadku braku przesłanego formularza.
     */
    header('location: ../../signUp.php');
    exit();
}
