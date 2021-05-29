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
                $delr   = $line[0];
                $city=$line[1];
                $invoice_type=$line[2];
                $fin_no=$line[3];
                $inv_gp_no=$line[4];
                $gr_no=$line[5];
                $account_code=$line[6];
                $model_code=$line[7];
                $color=$line[8];
                $chassis_prefix=$line[9];
                $chassis_no=$line[10];
                $engine_no=$line[11];
                $invoice_dt=$line[12];
                $inv_date_for_road_permit=$line[13];
                $invoice_amt_rs=$line[14];
                $order_category=$line[15];
                $plant=$line[16];
                $tin=$line[17];
                $sent_by=$line[18];
                $trip_consignment_no=$line[19];
                $transport_reg_number=$line[20];
                $indent_allot_no=$line[21];
                $trans_name=$line[22];
                $email_id=$line[23];
                $financer=$line[24];



                // Check whether member already exists in the database with the same chassis_no
                $prevQuery = "SELECT id FROM dispatches WHERE chassis_no = '".$line[10]."' AND engine_no='".$line[11]."'";
                $prevResult = $database->query($prevQuery);

                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $database->query("UPDATE dispatches SET delr='".$delr."', city='".$city."', invoice_type='".$invoice_type."', fin_no='".$fin_no."', inv_gp_no='".$inv_gp_no."', gr_no='".$gr_no."', account_code='".$account_code."', model_code='".$model_code."', color='".$color."', chassis_prefix='".$chassis_prefix."', invoice_dt='".$invoice_dt."', inv_date_for_road_permit='".$inv_date_for_road_permit."', invoice_amt_rs='".$invoice_amt_rs."', order_category='".$order_category."', plant='".$plant."', tin='".$tin."', sent_by='".$sent_by."', trip_consignment_no='".$trip_consignment_no."', transport_reg_number='".$transport_reg_number."', indent_allot_no='".$indent_allot_no."', trans_name='".$trans_name."', email_id='".$email_id."', financer='".$financer."' WHERE chassis_no = '".$chassis_no."' AND engine_no = '".$engine_no."'");
                }else{
                    // Insert member data in the database
                    $database->query("INSERT INTO dispatches (delr, city, invoice_type, fin_no, inv_gp_no, gr_no, account_code, model_code, color, chassis_prefix, chassis_no, engine_no, invoice_dt, inv_date_for_road_permit, invoice_amt_rs, order_category, plant, tin, sent_by, trip_consignment_no, transport_reg_number, indent_allot_no, trans_name, email_id, financer) VALUES ('".$delr."', '".$city."', '".$invoice_type."', '".$fin_no."', '".$inv_gp_no."', '".$gr_no."', '".$account_code."', '".$model_code."', '".$color."', '".$chassis_prefix."', '".$chassis_no."', '".$engine_no."', '".$invoice_dt."', '".$inv_date_for_road_permit."', '".$invoice_amt_rs."', '".$order_category."', '".$plant."', '".$tin."', '".$sent_by."', '".$trip_consignment_no."', '".$transport_reg_number."', '".$indent_allot_no."', '".$trans_name."', '".$email_id."', '".$financer."')");
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
header("Location: dispatches.php".$qstring);