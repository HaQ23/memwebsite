<?php
/**
 * @file
 * Skrypt do logowania użytkownika.
 */

/**
 * Sprawdzenie, czy formularz logowania został przesłany.
 */
if (isset($_POST['user-signin-submit'])) {
    require_once "../database/database.php";
    require_once "../utils/functions.php";
    $userLogin = $_POST['login-user'];
    $userPwd = $_POST['user-password'];

    /**
     * Sprawdzenie poprawności danych wprowadzonych w formularzu logowania.
     */
    if (!checkSignInFormInputs($userLogin, $userPwd)) {
        header('location: ../../signIn.php?error=emptyfields');
        exit();
    }

    /**
     * Logowanie użytkownika.
     */
    loginUser($conn, $userLogin, $userPwd);
} else {
    /**
     * Przekierowanie do strony logowania w przypadku braku przesłanego formularza.
     */
    header("location: ../../signIn.php");
    exit();
}
