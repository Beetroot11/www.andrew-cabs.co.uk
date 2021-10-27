
<?php
    /*
 
        * File Path: api/booking/create
        * Title: Create New Booking
        * Purpose: Allow user to book a vehicle 

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {id} [required] userId - User carrying out booking. 
            @param {id} [required] vehicleId - Vehicle that has been selected for booking. 
            @param {datetime} [required] timeDate - Time of pickup. 

        * Out:
            @return {id} bookingId - Id from newly inserted booking.
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.

    */

    require '../../network.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";

    $userId = $_POST['userId'];
    if (empty($userId)) {
        $checkData = false;
        $checkDataErrorMessage.= "User is required. ";
    } else {
        $userId = addslashes($userId);
    }

    $vehicleId = $_POST['vehicleId'];
    if (empty($vehicleId)) {
        $checkData = false;
        $checkDataErrorMessage.= "Vehicle is required. ";
    } else {
        $vehicleId = addslashes($vehicleId);
    }

    $timeDate = $_POST['timeDate'];
    if (empty($timeDate)) {
        $checkData = false;
        $checkDataErrorMessage.= "Time and Date is required. ";
    }

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $insertBooking = "INSERT INTO `BOOKING`(`userId`, `vehicleId`, `timeDate`)  VALUES ('$userId', '$vehicleId', '$timeDate');";

            if ($mysqli->query($insertBooking) === TRUE) {
                $return->categoryId = $mysqli->insert_id;
                $return->success = true;
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