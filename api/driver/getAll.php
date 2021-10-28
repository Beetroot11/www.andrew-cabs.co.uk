
<?php
    /*
 
        * File Path: api/driver/getAll
        * Title: Get All Drivers
        * Purpose: Allow admin to get all drivers 

        * In: 
            @param {key} [required] authKey - Key from config file.

        * Out:
            @return {array} drivers - Driver Information.
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
            $getDrivers = "SELECT `driverId`, `fName`, `sName`, `addedOn`, `sort` FROM `DRIVER` ORDER BY `DRIVER`.`sort` ASC;";

            $results = $mysqli->query($getDrivers);
            if ($results) {
                $return->success = true;
                $drivers = array();
                while ($row = $results->fetch_assoc()) {
                    $driver = new stdClass;
                    $driver->driverId = $row['driverId'];
                    $driver->fName = $row['fName'];
                    $driver->sName = $row['sName'];
                    $driver->addedOn = $row['addedOn'];
                    $driver->sort = $row['sort'];
                    array_push($drivers, $driver);
                }
                $return->drivers = $drivers;               
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