<?php
include_once "framework/main.php";


if (isset($_FILES["file"])) {
    if ($_FILES['file']['tmp_name'] == '') {
        echo danger_alert(" Select Can not be Empty");
    } else if ($_FILES['file']['type'] != 'text/csv') {
        echo danger_alert(" Please Select Only CSV File");
    } else {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $c = 0;
        $table = array();
        while (($filesop = fgetcsv($handle, 355971191, ",")) !== false) {
            $table['id'] = $filesop[0];
            $table['date'] = $filesop[1];
            $table['academic_year'] = $filesop[2];
            $table['session'] = $filesop[3];
            $table['alloted_category'] = $filesop[4];
            $table['voucher_type'] = $filesop[5];
            $table['voucher_no'] = $filesop[6];
            $table['roll_no'] = $filesop[7];
            $table['admno_uniqueId'] = $filesop[8];
            $table['status'] = $filesop[9];
            $table['fee_category'] = $filesop[10];
            $table['faculty'] = $filesop[11];
            $table['program'] = $filesop[12];
            $table['department'] = $filesop[13];
            $table['batch'] = $filesop[14];
            $table['receipt_no'] = $filesop[15];
            $table['fee_head'] = $filesop[16];
            $table['due_amount'] = $filesop[17];
            $table['paid_amount'] = $filesop[18];
            $table['concession_amount'] = $filesop[19];
            $table['scholarship_amount'] = $filesop[20];
            $table['reverse_concession_amount'] = $filesop[21];
            $table['write_off_amount'] = $filesop[22];
            $table['adjusted_amount'] = $filesop[23];
            $table['refund_amount'] = $filesop[24];
            $table['fund_tranCfer_amount'] = $filesop[25];
            $table['remarks'] = $filesop[26];
            // echo "<pre>";
            // print_r($table);
            $result =  insertAll('full_tables_data', $table);
        }
        if ($result == "success") {
            echo success_alert(" Data inserted Successfully");
        }
    }
}
