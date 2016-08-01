<?php

include('connection.php');

$query = "SELECT Thali, yearly_commitment, NAME, Dues, Paid, yearly_hub, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist";
$result = mysqli_query($link,$query) or die(mysqli_error($link));

while($row = mysqli_fetch_assoc($result)){   

  if($row['yearly_commitment'] == 1 && !empty($row['yearly_hub'])) {
  $reciepts_query_result_total = mysqli_fetch_assoc(mysqli_query($link,"SELECT sum(`Amount`) as total FROM `receipts` where Thali_No = '".$row['Thali']."'"));
  $total_amount_paid = $reciepts_query_result_total['total'];

  $_miqaats = array(
                    '2016-06-27' => 'Lailatul Qadr (27th June 2016)',
                    '2016-07-31' => 'Urs Syedi Abdulqadir Hakimuddin (AQ) (31st July 2016)',
                    '2016-08-29' => 'Milad Of Syedna Taher Saifuddin (RA) (29th August 2016)',
                    '2016-09-19' => 'Eid-e-Ghadeer-e-Khum (19th September 2016)',
                    '2016-10-17' => 'Urs Syedna Hatim (RA) (17th October 2016)',
                    '2016-11-20' => 'Chehlum Imam Husain (S.A) (20th November 2016)',
                    '2016-12-11' => 'Milad Rasulullah (SAW) (11th December 2016)',
                    '2017-01-18' => 'Milad Syedna Mohammed Burhanuddin (RA) (18th January 2017)'
                    );
                    
  $installment = (int)($values['Total_Pending'] + $values['Paid'])/8;
  $todays_date = date("Y-m-d");


  if ($thaliactivedate > '1437-09-19') {
	    $installment = (int)($values['Total_Pending'] + $values['Paid'])/7;
  }					

  $miqaats = array();
  $miqaats_past = array();
  foreach ($_miqaats as $mdate => $miqaat) {

    if($mdate < $todays_date)
    {
      $miqaats_past[$mdate] = $miqaat;
    }
    else
    {

      $month_installment = $installment;
      $miqaats[] = array(
                        $mdate,$miqaat,ceil($month_installment)
                        );
    }
  }

 
 $hub_baki = (count($miqaats_past) * $installment) - $total_amount_paid;

 $miqaats[0][2] += $hub_baki;

 if ($miqaats[0][2] > 0) {
 $miqaats[0][2] = round($miqaats[0][2],-2);
 }
 $next_install = $miqaats[0][2];
 mysqli_query($link,"UPDATE thalilist set next_install ='$next_install' WHERE Thali = '".$row['Thali']."'");
 } 
 }
 ?>
