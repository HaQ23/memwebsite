<?php
/**
 * @file
 * Skrypt do obsługi procesu odzyskiwania hasła.
 */

/**
 * Wysłanie wiadomości e-mail.
 * 
 * Uwaga: Należy ustawić odpowiednie parametry SMTP przed użyciem.
 */
// $to = "kacper.baluszynski2001@gmail.com";
// $subject = "Sukces";
// $messages = "Wiadomość została pomyślnie wysłana z serwera lokalnego.";

// if (mail($to, $subject, $messages)) {
//   echo "Wiadomość wysłana!";
// } else {
//   echo "Niepowodzenie!";
// }

/**
 * Proces odzyskiwania hasła - krok 1.
 */
if (isset($_POST['recovery-step-one'])) {
    $email = $_POST['recovery-email'];
    require_once "../database/database.php";
    $token = random_int(100000, 999999);
    $to = $email;
    $subject = "MemHub - Przywracanie Hasła";
    $message = '<html>
    <head>
    <title>MemHub - Zmiana Hasła</title>
    </head>
    <body>
    <h1>Rozpoczęto proces zmiany hasła.</h1>
    <p>Twój wygenerowany token to: <b style="color: red;">'.$token.'</b></p>
    <br>
    <br>
    <br>
    <p>W razie problemów służymy pomocą!</p>
    <p>Z poważaniem, <br>~ Markoni McNeil</p>
    </body>
    </html>';
    $headers = 'From: biuro@memhub.pl' . "\r\n";
    $headers .= 'Reply-To: biuro@memhub.pl' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    
    if (mail($to, $subject, $message, $headers)) {
    echo "Wiadomość wysłana!";
    } else {
    echo "Niepowodzenie!";
    }
    $sql = "INSERT INTO token (id, token, user_email, used) 
    VALUES (NULL, '$token', '$email', '0')";
    $conn->query($sql);
    $conn->close();

    header("Location: ../../recovery.php?step=2&email=$email");
    exit();
}

/**
 * Proces odzyskiwania hasła - krok 2.
 */
else if (isset($_POST['recovery-step-two'])) {
    $email = $_POST['recovery-email'];
    $token = $_POST['recovery-token'];
    $newPwd = $_POST['recovery-password'];

    require_once "../database/database.php";

    $sql = "SELECT used FROM token WHERE token = $token AND user_email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $used = $row['used'];
            if ($used == 1) {
                $conn->close();
                header("Location: ../../recovery.php?step=2&email=$email&error=usedtoken");
                exit();
            } else {
                $hashedNewPwd = password_hash($newPwd, PASSWORD_DEFAULT);
                $sql2 = "UPDATE account SET password = '$hashedNewPwd' WHERE email = '$email'";
                $conn->query($sql2);
                $sql3 = "UPDATE token SET used = 1 WHERE user_email = '$email' AND token = $token";
                $conn->query($sql3);
                $conn->close();
                header("Location: ../../recovery.php?step=3");
                exit();
            }
        }
    } else {
        $conn->close();
        header("Location: ../../recovery.php?step=2&email=$email&error=notoken");
        exit();
    }
}
