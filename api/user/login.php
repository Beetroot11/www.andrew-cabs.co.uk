<?php
    /*
        * File Path: api/user/login
        * Title: Allow user to login
        * Purpose: Let user login once email and password are provided

        * In: 
            @param {key} [required] authKey - Key from config file.
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
        $sql = "SELECT `userId`, `password` FROM  `USER` WHERE  `email` =  '$email'";
        $result = $mysqli->query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {	
                $userId = $row['userId'];
                $hashed_password = $row['password'];
                if(!password_verify($password, $hashed_password)) {
                    $checkData = false;
                    $checkDataErrorMessage.= "Password is incorrect. ";
                } 
            }
        } else {
            $checkData = false;
            $checkDataErrorMessage.= "Email doesn't have an account. ";
        }
    }
    
    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $return->success = true;
            $return->userId = $userId;
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