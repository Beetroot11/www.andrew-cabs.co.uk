
<?php
    /*
 
        * File Path: api/driver/create
        * Title: Create New Driver
        * Purpose: Allow admin to create a new driver 

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {string} [required] firstName - First Name of Driver.
            @param {string} [required] surname - Surname of Driver.
            @param {date} [required] dob - Date of Birth. 
            @param {string} [required] licenceNumber - Drivers Licence Number. 
            @param {string} [required] licenceToDrive - Types of Vehicle the Driver is Licenced to. 


        * Out:
            @return {id} driverId - Id from newly inserted driver.
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

    $dob = $_POST['dob'];
    if (empty($dob)) {
        $checkData = false;
        $checkDataErrorMessage.= "Date of Birth is required. ";
    }

    $licenceNumber = $_POST['licenceNumber'];
    if (empty($licenceNumber)) {
        $checkData = false;
        $checkDataErrorMessage.= "Licence Number is required. ";
    } else {
        $licenceNumber = addslashes($licenceNumber);
    }

    $licenceToDrive = $_POST['licenceToDrive'];
    if (empty($licenceToDrive)) {
        $checkData = false;
        $checkDataErrorMessage.= "Licence To Drive is required. ";
    } else {
        $licenceToDrive = addslashes($licenceToDrive);
    }

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $insertLicence = "INSERT INTO `LICENCE`(`number`, `allowedVehicleTypes`)  VALUES ('$licenceNumber', '$licenceToDrive');";

            if ($mysqli->query($insertLicence) === TRUE) {
                $licenceId = $mysqli->insert_id;
                $return->licenceId = $licenceId;

                $insertDriver = "INSERT INTO `DRIVER`(`fName`, `sName`, `dob`, `licenceId`)  VALUES ('$firstName', '$surname', '$dob', '$licenceId');";

                if ($mysqli->query($insertDriver) === TRUE) {
                    $return->driverId = $mysqli->insert_id;
                    $return->success = true;
                } else {
                    $return->success = false;
                    $return->failMessage = "Statement failed to execute";
                }
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