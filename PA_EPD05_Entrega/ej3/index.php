<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

function correctNameFormat($name) {
    /* returns true if name format is correct, false if it doens't exists or it isnt */
    $res = isset($name) && $name !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^[[:upper:]]{1} -> Primer caracter es mayuscula
         *      [a-zA-z\s]+ -> Resto son letras o espacios
         */
        $res = $res && preg_match('/^[[:upper:]]{1}[a-zA-z\s]+$/', $name);
    }
    return $res;
}

function correctEmailFormat($email) {
    /* returns true if email format is correct, false if it doens't exists or it isnt */
    $res = isset($email) && $email !== "";
    if ($res === TRUE) {
        $res = $res && filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    return $res;
}

function correctTwitterUserFormat($user) {
    /* returns true if email format is correct, false if it doens't exists or it isnt */
    $res = isset($user) && $user !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^@ -> Starts with @
         *      [^\s]+ -> Any character except whitespace " "
         */
        $res = $res && preg_match('/^@[^\s]+$/', $user);
    }
    return $res;
}

function correctPhoneFormat($phone) {
    /* returns true if phone format is correct, false if it doens't exists or it isnt */
    $res = isset($phone) && $phone !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^9 -> Starts with 9
         *      [[:digit:]]{8} -> Eight more digits
         */
        $res = $res && preg_match('/^9[[:digit:]]{8}$/', $phone);
    }
    return $res;
}

function correctMobileFormat($mobile) {
    /* returns true if mobile format is correct, false if it doens't exists or it isnt */
    $res = isset($mobile) && $mobile !== "";
    if ($res === TRUE) {
        /* Regular expression:
         *      ^6 -> Starts with 6
         *      [[:digit:]]{8} -> Eight more digits
         */
        $res = $res && preg_match('/^6[[:digit:]]{8}$/', $mobile);
    }
    return $res;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
        $user = filter_input(INPUT_GET, "twitter", FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_GET, "phone", FILTER_SANITIZE_NUMBER_INT);
        $mobile = filter_input(INPUT_GET, "mobile", FILTER_SANITIZE_NUMBER_INT);
        if (isset($_GET["formSubmitted"]) &&
                correctNameFormat($name) &&
                correctEmailFormat($email) &&
                correctTwitterUserFormat($user) &&
                correctPhoneFormat($phone) &&
                correctMobileFormat($mobile)) {
            //  ALL CORRECT, PRINT INFO
        } else {
            if (isset($_GET["formSubmitted"])) {
                // ERROR HAPPENED, PRINT FORM IN RED
            } else {
                // PRINT FORM
            }
        }
        ?>
    </body>
</html>
