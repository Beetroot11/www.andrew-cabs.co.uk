
<?php
    /*
 
        * File Path: api/vehicle/create
        * Title: Create New Vehicle
        * Purpose: Allow admin to create a new vehicle 

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {string} [required] model - Model of Vehicle.
            @param {string} [required] make - Model of Vehicle.
            @param {string} [required] colour - Colour of Vehicle. 
            @param {string} [required] registration - Registration of Vehicle. 
            @param {int} [required] capacity - Capacity of Vehicle. 
            @param {id} [required] vehicleTypeId - Types of Vehicle. 


        * Out:
            @return {id} vehicleId - Id from newly inserted vehicle.
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.

    */

    require '../../network.php';
    require '../../config.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";

    $model = $_POST['model'];
    if (empty($model)) {
        $checkData = false;
        $checkDataErrorMessage.= "Model is required. ";
    } else {
        $model = addslashes($model);
    }

    $make = $_POST['make'];
    if (empty($make)) {
        $checkData = false;
        $checkDataErrorMessage.= "Make is required. ";
    } else {
        $make = addslashes($make);
    }

    $colour = $_POST['colour'];
    if (empty($colour)) {
        $checkData = false;
        $checkDataErrorMessage.= "Colour is required. ";
    } else {
        $colour = addslashes($colour);
    }

    $registration = $_POST['registration'];
    if (empty($colour)) {
        $checkData = false;
        $checkDataErrorMessage.= "Registration is required. ";
    } else {
        $registration = addslashes($registration);
    }

    $capacity = $_POST['capacity'];
    if (empty($capacity)) {
        $checkData = false;
        $checkDataErrorMessage.= "Capacity is required. ";
    }

    $vehicleTypeId = $_POST['vehicleTypeId'];
    if (empty($vehicleTypeId)) {
        $checkData = false;
        $checkDataErrorMessage.= "Vehicle Type is required. ";
    } 

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $insertVehicle = "INSERT INTO `VEHICLE`(`model`, `make`, `colour`, `registration`, `capacity`, `vehicleTypeId`) 
                                        VALUES ('$model','$make','$colour','$registration','$capacity','$vehicleTypeId')";

            if ($mysqli->query($insertVehicle) === TRUE) {
                $return->vehicleId = $mysqli->insert_id;
                $return->success = true;
            } else {
                $return->success = false;
                $return->failMessage = "Statement failed to execute 1";
                $return->sql = $insertDriver;
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