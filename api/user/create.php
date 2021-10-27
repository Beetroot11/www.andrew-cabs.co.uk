<?php
    /*
        * File Path: api/user/create
        * Title: Create a user account
        * Purpose: Allow user to create an account

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {string} [required] firstName - First name of the new user.
            @param {string} [required] surname - Surname of the new user.
            @param {string} [required] email - Email of the new user.
            @param {string} [required] password - Password of new user in plain text.

        * Out:
            @return {id} userId - Returned userId from insert.
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.
    */

    require '../../network.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";

    $firstName = $_POST['firstName'];
    if (empty($firstName)) {
        $checkData = false;
        $checkDataErrorMessage.= "First Name is required. ";
    } else {
        $firstName = addslashes($firstName);
    }

    $surname = $_POST['surname'];
    if (empty($surname)) {
        $checkData = false;
        $checkDataErrorMessage.= "Surname is required. ";
    } else {
        $surname = addslashes($surname);
    }

    $email = $_POST['email'];
    if (empty($email)) {
        $checkData = false;
        $checkDataErrorMessage.= "Email is required. ";
    } else {
        $email = addslashes($email);
    }
    

    $password = $_POST['password'];
    if (empty($password)) {
        $checkData = false;
        $checkDataErrorMessage.= "Password is required. ";
    } else {
        $password = addslashes($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checkEmail = "SELECT `userId` FROM `USER` WHERE `email` = '$email'";
                
                if ($mysqli->query($checkEmail)->num_rows === 0) {
                    $insertUser = "INSERT INTO `USER`(`email`, `password`) VALUES ('$email', '$password');";

                    if ($mysqli->query($insertUser) === TRUE) {
                        $return->userId = $mysqli->insert_id;
                        $return->success = true;
                    } else {
                        $return->success = false;
                        $return->failMessage = "Statement failed to execute";
                    }

                } else {
                    $return->success = false;
                    $return->failMessage = "Email already exists in system";
                }
            } else {
                $return->success = false;
                $return->failMessage = "Invalid email format";
            }
        } else {
            $return->success = false;
            $return->failMessage = "You are not authorized to make this call";
        }
    } else {
        $return->success = false;
        $return->failMessage = $checkDataErrorMessage;
    }

    header('Content-type: application/json');
    echo json_encode($return);
?>