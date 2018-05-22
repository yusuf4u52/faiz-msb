<?php

include('connection.php');

function getMiqaats($start_date)
{
    $_miqaats = array(
                    '2017-06-16' => 'Lailatul Qadr (16th June 2017)',
                    '2017-07-21' => 'Urs Syedi Abdulqadir Hakimuddin (AQ) (21st July 2017)',
                    '2017-08-19' => 'Milad Of Syedna Taher Saifuddin (RA) (19th August 2017)',
                    '2017-09-09' => 'Eid-e-Ghadeer-e-Khum (9th September 2017)',
                    '2017-10-06' => 'Urs Syedna Hatim (RA) (6th October 2017)',
                    '2017-11-09' => 'Chehlum Imam Husain (S.A) (9th November 2017)',
                    '2017-11-30' => 'Milad Rasulullah (SAW) (30th November 2017)',
                    '2018-01-07' => 'Milad Syedna Mohammed Burhanuddin (RA) (7th January 2018)',
                    '2018-02-01' => '16 Jumadil Awwal (1st February 2018)',
                    '2018-03-03' => '16 Jumadil Akhar (3rd March 2018)',
                    '2018-04-01' => '16 Rajab (1st April 2018)',
                    '2018-05-01' => '16 Shabaan (1st May 2018)'
                    );
    $return_array = array();
    $i = 0;
    foreach ($_miqaats as $date => $value) {
      if($start_date <=  $date && $i < 8)
      {
         $return_array[$date] = $value;
         $i++;
      }
    }
    return $return_array;
}

$query = "SELECT * FROM thalilist";
$result = mysqli_query($link,$query) or die(mysqli_error($link));

while($row = mysqli_fetch_assoc($result)){   

  if($row['yearly_commitment'] == 1 && !empty($row['yearly_hub'])) {
  $reciepts_query_result_total = mysqli_fetch_assoc(mysqli_query($link,"SELECT sum(`Amount`) as total FROM `receipts` where Thali_No = '".$row['Thali']."'"));
  $total_amount_paid = $reciepts_query_result_total['total'];
  $thaliactivedate_query = mysqli_fetch_assoc(mysqli_query($link,"SELECT Date(datetime) as datetime FROM `change_table` where Thali = '".$row['Thali']."' AND operation = 'Start Thali' AND id > 3596 ORDER BY id limit 1"));
  $thaliactivedate = $thaliactivedate_query['datetime'];

  //$_miqaats = getMiqaats($thaliactivedate);
  $sql = mysqli_query($link,"select miqat_date,miqat_description from sms_date");

  while($record = mysqli_fetch_assoc($sql))
    {
      $_miqaats[$record['miqat_date']] = $record['miqat_description'];
    }

  $row['Total_Pending'] = $row['Previous_Due'] + $row['Dues'] + $row['yearly_hub'] + $row['Zabihat'] + $row['Reg_Fee'] + $row['TranspFee'] - $row['Paid'];
  
  $installment = (int)($row['Total_Pending'] + $row['Paid'])/count($_miqaats);;
  $todays_date = date("Y-m-d");
  $miqaat_gone = 0;

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

 
 $hub_baki = ((count($miqaats_past) - $miqaat_gone) * $installment) - $total_amount_paid;

 $miqaats[0][2] += $hub_baki;

 if ($miqaats[0][2] > 0) {
 $miqaats[0][2] = round($miqaats[0][2],-2);
 }
 $next_install = $miqaats[0][2];


 mysqli_query($link,"UPDATE thalilist set next_install ='$next_install' WHERE Thali = '".$row['Thali']."'") or die(mysqli_error($link));
 mysqli_query($link,"UPDATE thalilist set prev_install_pending ='$hub_baki' WHERE Thali = '".$row['Thali']."'") or die(mysqli_error($link));

 } 
 }
 ?>
