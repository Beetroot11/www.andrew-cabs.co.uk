
<?php
    /*
 
        * File Path: api/user/getAll
        * Title: Get All Users
        * Purpose: Allow admin to get all users 

        * In: 
            @param {key} [required] authKey - Key from config file.

        * Out:
            @return {array} users - User Information.
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.

    */

    require '../../network.php';
    require '../../config.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";
    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $getUsers = "SELECT `userId`, `fName`, `sName` FROM `USER`";

            $results = $mysqli->query($getUsers);
            if ($results) {
                $return->success = true;
                $users = array();
                while ($row = $results->fetch_assoc()) {
                    $user = new stdClass;
                    $user->userId = $row['userId'];
                    $user->fName = $row['fName'];
                    $user->sName = $row['sName'];
                    array_push($users, $user);
                }
                $return->users = $users;               
            } else {
                $return->success = false;
                $return->failMessage = "Statement failed to execute";
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