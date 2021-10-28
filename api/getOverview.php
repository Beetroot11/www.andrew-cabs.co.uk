
<?php
    /*
 
        * File Path: api/getOverview
        * Title: Get Overview
        * Purpose: Get all key information to show home

        * In: 
            @param {key} [required] authKey - Key from config file.

        * Out:
            @return {int} drivers - Drivers on the system.
            @return {int} users - Users on the system.
            @return {int} vehicles - Vehicles in the system.
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.

    */

    require '../network.php';
    require '../config.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";
    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $getDrivers = "SELECT `driverId` FROM `DRIVER`;";
            $resultsDrivers = $mysqli->query($getDrivers);
            $drivers = $resultsDrivers->num_rows;

            if ($resultsDrivers) {
                $return->drivers = $drivers;               
            }

            $getUsers = "SELECT `userId` FROM `USER`;";
            $resultsUsers = $mysqli->query($getUsers);
            $users = $resultsUsers->num_rows;

            if ($resultsUsers) {
                $return->users = $users;               
            }

            $getVehicle = "SELECT `vehicleId` FROM `VEHICLE`;";
            $resultsVehicles = $mysqli->query($getVehicle);
            $vehicles = $resultsVehicles->num_rows;

            if ($resultsVehicles) {
                $return->users = $users;               
            }
            
            $return->success = ($resultsDrivers && $resultsUsers && $resultsVehicles);
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