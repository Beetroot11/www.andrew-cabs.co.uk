<?php
    /*
        * File Path: api/booking/delete
        * Title: Remove Booking
        * Purpose: Allow user to remove booking

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {id} [required] userId - Id of logged in user.
            @param {id} [required] bookingId - Id of booking the users wants to remove.

        * Out:
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
        $checkDataErrorMessage.= "UserId is required. ";
    } else {
        $userId = addslashes($userId);
    }

    $bookingId = $_POST['bookingId'];
    if (empty($bookingId)) {
        $checkData = false;
        $checkDataErrorMessage.= "BookingId is required. ";
    } else {
        $bookingId = addslashes($bookingId);
    }

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $findBooking = "SELECT `bookingId` FROM `BOOKING` WHERE `userId` = '$userId' AND `bookingId` = '$bookingId';";
            $findBookingResults = $mysqli->query($findBooking);

            if ($findBookingResults->num_rows === 1) {
                while ($row = $findBookingResults->fetch_assoc()) {
                    $bookingId = $row['bookingId'];

                    $deleteBooking = "DELETE FROM `BOOKING` WHERE `bookingId` = '$bookingId';";

                    if ($mysqli->query($deleteBooking) === TRUE) {
                        $return->success = true;
                    } else {
                        $return->success = false;
                        $return->failMessage = "Statement failed to execute";
                    }
                }
            } else {
                $return->success = false;
                $return->failMessage = "Failed to find the booking with that user";
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