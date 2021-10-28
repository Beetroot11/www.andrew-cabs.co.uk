
<?php
    /*
 
        * File Path: api/vehicle/getAll
        * Title: Get All Vehicles
        * Purpose: Allow admin to get all vehicles 

        * In: 
            @param {key} [required] authKey - Key from config file.

        * Out:
            @return {array} vehicles - Vehicle Information.
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
            $getVehicles = "SELECT `vehicleId`, `make`, `model`, `colour`, `registration`, `vehicleTypeId` FROM `VEHICLE`";

            $results = $mysqli->query($getVehicles);
            if ($results) {
                $return->success = true;
                $vehicles = array();
                while ($row = $results->fetch_assoc()) {
                    $vehicle = new stdClass;
                    $vehicle->vehicleId = $row['vehicleId'];
                    $vehicle->make = $row['make'];
                    $vehicle->model = $row['model'];
                    $vehicle->colour = $row['colour'];
                    $vehicle->registration = $row['registration'];
                    $vehicle->vehicleTypeId = $row['vehicleTypeId'];
                    array_push($vehicles, $vehicle);
                }
                $return->vehicles = $vehicles;               
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