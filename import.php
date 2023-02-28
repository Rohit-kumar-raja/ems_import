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
            // parent table branch insertion 
            $branch['branch_name'] = $filesop[11];
            $brnach_id =  insertGetId('branches_faculties', $branch);
            if ($brnach_id == 0 || $brnach_id == '') {
                $brnach_id =  fetchRow('branches_faculties', ' branch_name="' . $branch['branch_name'] . '"')['id'];
            }

            // inserting the data of the fee_category tabll
            $fee_category['fee_category'] = $filesop[10];
            $fee_category['br_id'] = $brnach_id;
            $fee_category['description'] = $filesop[10];
            $feecategory_id = insertGetId('feecategory_feecategories', $fee_category);
            if ($feecategory_id == 0 || $feecategory_id == '') {
                $feecategory_id =  fetchRow('feecategory_feecategories', ' fee_category="' . $fee_category['fee_category'] . '"')['id'];
            }

            // inserting the data of the feecollectiontypes table
            $feecollectiontypes['collectionhead'] = $filesop[16];
            $feecollectiontypes['br_id'] = $brnach_id;
            $feecollectiontypes['collectiondesc'] = $filesop[16];
            $feecollectiontypes_id = insertGetId('feecollectiontypes', $feecollectiontypes);
            if ($feecollectiontypes_id == 0 || $feecollectiontypes_id == '') {
                $feecollectiontypes_id =  fetchRow('feecollectiontypes', ' collectionhead="' . $feecollectiontypes['collectionhead'] . '"')['id'];
            }

            // inserting the data of the Finecial Transactions datails table
            $feetypes_fees['fee_category'] = $feecategory_id;
            $feetypes_fees['f_name'] = $filesop[10];
            $feetypes_fees['fee_collection_id'] = $feecollectiontypes_id;
            $feetypes_fees['br_id'] = $brnach_id;
            //  Seq_id  is a number which is same  for each fname irrespecti+ve of branch (ex: tution fee =1 where ever we have tuition fee it is 1 irrespective of branch)          
            $total_f_name = fetchCount('feetypes_fees', 'f_name="' . $feetypes_fees['f_name'] . '"');
            $feetypes_fees['seq_id'] = $total_f_name + 1;
            $feetypes_fees['fee_type_ledger'] = $filesop[10];
            //  $feetypes_fees['fee_headtype'] = $brnach_id; // module id data not availble
            $feetypes_fees['created_at'] = date('Y-m-d h:m:i');
            $feetypes_fees_id = insertGetId('feetypes_fees', $feetypes_fees);

            // inserting the data of the modules  table
            // $modules['module_name'] = $filesop[16];
            // $modules['collectiondesc'] = $filesop[26];
            // $modules_id = insertGetId('modules', $modules);
            // if ($modules_id == 0 || $modules_id == '') {
            //     $modules_id =  fetchRow('modules', 'module_name="' . $modules['module_name'] . '"')['id'];
            // }


            // inserting the data of the Entery Mode  table
            // $entrymodes['entry_modename'] = $filesop[16];
            // $entrymodes['crdr'] = $filesop[16];
            // $entrymodes['entrymodeno'] = $filesop[16];
            // $entrymodes['collectiondesc'] = $filesop[26];
            // $entrymodes_id = insertGetId('entrymodes', $entrymodes);
            // if ($entrymodes_id == 0 || $entrymodes_id == '') {
            //     $entrymodes_id =  fetchRow('entrymodes', 'entry_modename="' . $entrymodes['entry_modename'] . '"')['id'];
            // }

            // inserting the data of the Finecial Transactions table
            $financialtrans['tranid'] = rand(1000000000, 9999999999);
            $financialtrans['admno'] = $filesop[8];

            $previous_data =  fetchRow('financialtrans', ' admno="' .  $financialtrans['admno'] . '"  ORDER BY id DESC ');
            if ($previous_data != '') {
                $total_amount = $previous_data['amount'] + $filesop[18];
            } else {
                $total_amount = $filesop[18];
            }

            $financialtrans['amount'] = $total_amount;
            $financialtrans['crdr'] = 'C';
            $financialtrans['tran_date'] = date('Y-m-d', strtotime($filesop[1]));
            $financialtrans['acad_year'] = $filesop[2];
            $financialtrans['entry_mode'] = '0';
            $financialtrans['voucherno'] = $filesop[6];
            $financialtrans['br_id'] = $brnach_id;
            if ($filesop[5] == 'CONCESSION') {
                $type_of_concession = 1;
            } else  if ($filesop[5] == 'SCHOLARSHIP') {
                $type_of_concession = 2;
            } else {
                $type_of_concession = 0;
            }
            $financialtrans['type_of_concession'] = $type_of_concession;
            $financialtrans['created_at'] = date('Y-m-d h:m:i');
            $financialtrans_id = insertGetId('financialtrans', $financialtrans);
            if ($financialtrans_id == 0 || $financialtrans_id == '') {
                updateAll('financialtrans', $financialtrans, ' admno="' . $financialtrans['admno'] . '"');
                $financialtrans_id =  fetchRow('financialtrans', 'admno="' . $financialtrans['admno'] . '"')['id'];
            }

            // inserting the data of the Finecial Transactions datails table
            $financialtrandetails['financialTranId'] = $financialtrans_id;
            $financialtrandetails['amount'] = $total_amount;
            $financialtrandetails['crdr'] = 'C';
            $financialtrandetails['head_id'] = $feecollectiontypes_id;
            $financialtrandetails['head_name'] = $filesop[16];
            $financialtrandetails['br_id'] = $brnach_id;
            $financialtrandetails['created_at'] = date('Y-m-d h:m:i');
            $financialtrandetails_id = insertGetId('financialtrandetails', $financialtrandetails);



            // inserting the data of the Common_fee_collection table
            $commonfeecollections['trans_id'] = rand(1000000000, 9999999999);
            $commonfeecollections['admno'] = $filesop[8];
            $commonfeecollections['rollno'] = $filesop[7];

            $previous_data =  fetchRow('commonfeecollections', ' admno="' .  $commonfeecollections['admno'] . '" ORDER BY id DESC ');
            if ($previous_data != '') {
                $total_amount = $previous_data['amount'] + $filesop[18];
            } else {
                $total_amount = $filesop[18];
            }

            $commonfeecollections['amount'] = $total_amount;
            $commonfeecollections['br_id'] = $brnach_id;
            $commonfeecollections['acadamic_year'] = $filesop[2];
            $commonfeecollections['financial_year'] = $filesop[3];
            $commonfeecollections['display_receipt_no'] = $filesop[15];
            $commonfeecollections['entry_mode'] = '0';
            $commonfeecollections['paid_date'] =  date('Y-m-d', strtotime($filesop[1]));
            $commonfeecollections['inactive'] = 1;
            $commonfeecollections['created_at'] =  date('Y-m-d h:m:i');

            $commonfeecollections_id = insertGetId('commonfeecollections', $commonfeecollections);
            if ($commonfeecollections_id == 0 || $commonfeecollections_id == '') {
                updateAll('commonfeecollections', $commonfeecollections, ' admno="' . $commonfeecollections['admno'] . '"');
                $commonfeecollections_id =  fetchRow('commonfeecollections', ' admno="' . $commonfeecollections['admno'] . '"')['id'];
            }

            // inserting the data of the Finecial Transactions datails table
            $commonfeecollectionheadwises['receipt_id'] = $commonfeecollections_id;
            $commonfeecollectionheadwises['amount'] = $filesop[18];
            $commonfeecollectionheadwises['head_id'] = $feecollectiontypes_id;
            $commonfeecollectionheadwises['head_name'] = $filesop[16];
            $commonfeecollectionheadwises['br_id'] = $brnach_id;
            $commonfeecollectionheadwises['created_at'] = date('Y-m-d h:m:i');
            $commonfeecollectionheadwises_id = insertGetId('commonfeecollectionheadwises', $commonfeecollectionheadwises);
      
        }

        if ($commonfeecollectionheadwises_id > 0) {
            echo success_alert(" Data inserted Successfully");
        }
    }
}
