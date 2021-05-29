<?php
// Load the database configuration file
include_once 'includes/init.php';

if(isset($_POST['importSubmit'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $chassis_no=$line[0];
                $engine_no=$line[1];
                $sms_inv_no=$line[2];
                $sms_inv_dt=$line[3];



                // Check whether member already exists in the database with the same chassis_no
                $prevQuery = "SELECT id FROM dispatches WHERE chassis_no = '".$line[0]."' AND engine_no='".$line[1]."'";
                $prevResult = $database->query($prevQuery);

                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $database->query("UPDATE dispatches SET sms_inv_no='".$sms_inv_no."', sms_inv_dt='".$sms_inv_dt."' WHERE chassis_no = '".$chassis_no."' AND engine_no = '".$engine_no."'");
                }else{
                    // Insert member data in the database
                    $qstring='?status=err';
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: sms.php".$qstring);