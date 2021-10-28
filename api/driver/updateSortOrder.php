
<?php
    /*
 
        * File Path: api/driver/create
        * Title: Create New Driver
        * Purpose: Allow admin to create a new driver 

        * In: 
            @param {key} [required] authKey - Key from config file.
            @param {array} [required] sortOrder - Sort Order.

        * Out:
            @return {bool} success - True/False if this was successful.
            @return {string} failMessage (optional) - Detail of error returned.

    */

    require '../../network.php';
    require '../../config.php';

    $postedAuthKey = $_POST['authKey'];

    $checkData = true;
    $checkDataErrorMessage = "";

    $sortOrder = $_POST['sortOrder'];
    if (empty($sortOrder)) {
        $checkData = false;
        $checkDataErrorMessage.= "Sorted Order Array is required. ";
    }

    $return = new stdClass;

    if ($checkData) {       
        if ($postedAuthKey == $authKey) {
            $sortOrderArray = json_decode($sortOrder);

            foreach($sortOrderArray as $driverSort) {
                $driverId = $driverSort['driverId'];
                $sort = $driverSort['sort'];

                $updateSort = "UPDATE `DRIVER` SET `sort`='$sort' WHERE `driverId` = '$driverId'";
                $mysqli->query($updateSort);
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