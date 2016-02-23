<?php
include('connection.php');
include('adminsession.php');

error_reporting(0);

    $mh_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Moharram"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$mh_hub[0]."' WHERE Months = 'Moharram'");
    $mh_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Moharram"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$mh_zabihat[0]."'  WHERE Months = 'Moharram'");

    $sf_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Safar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$sf_hub[0]."' WHERE Months = 'Safar'");
    $sf_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Safar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$sf_zabihat[0]."' WHERE Months = 'Safar'"); 

    $ra1_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_RabiulAwwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ra1_hub[0]."' WHERE Months = 'RabiulAwwal'");
    $ra1_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_RabiulAwwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ra1_zabihat[0]."' WHERE Months = 'RabiulAwwal'");

    $ra2_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_RabiulAkhar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ra2_hub[0]."' WHERE Months = 'RabiulAkhar'");
    $ra2_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_RabiulAkhar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ra2_zabihat[0]."' WHERE Months = 'RabiulAkhar'");

    $ja1_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_JamadalAwwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ja1_hub[0]."' WHERE Months = 'JamadalAwwal'");
    $ja1_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_JamadalAwwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ja1_zabihat[0]."' WHERE Months = 'JamadalAwwal'");

    $ja2_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_JamadalAkhar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ja2_hub[0]."' WHERE Months = 'JamadalAkhar'");
    $ja2_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_JamadalAkhar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ja2_zabihat[0]."' WHERE Months = 'JamadalAkhar'");

    $rjb_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Rajab"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$rjb_hub[0]."' WHERE Months = 'Rajab'");
    $rjb_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Rajab"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$rjb_zabihat[0]."' WHERE Months = 'Rajab'");   

    $shb_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Shaban"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$shb_hub[0]."' WHERE Months = 'Shaban'");
    $shb_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Shaban"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$shb_zabihat[0]."' WHERE Months = 'Shaban'");

    $rmz_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Ramazan"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$rmz_hub[0]."' WHERE Months = 'Ramazan'");
    $rmz_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Ramazan"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$rmz_zabihat[0]."' WHERE Months = 'Ramazan'");

    $shw_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Shawwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$shw_hub[0]."' WHERE Months = 'Shawwal'");
    $shw_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Shawwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$shw_zabihat[0]."' WHERE Months = 'Shawwal'");

    $zq_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Zilqad"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$zq_hub[0]."' WHERE Months = 'Zilqad'");
    $zq_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Zilqad"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$zq_zabihat[0]."' WHERE Months = 'Zilqad'");

    $zh_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Zilhaj"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$zh_hub[0]."' WHERE Months = 'Zilhaj'");
    $zh_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Zilhaj"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$zh_zabihat[0]."' WHERE Months = 'Zilhaj'");

    $result = mysqli_query($link,"select * from hisab");

?>
<html>
<head>
  <link rel="stylesheet" href="./src/bootstrap.css" media="screen" />
  <body>
    <div class="container">
<table class="table table-striped table-hover table-responsive">

                <thead>

                  <tr>
                    <th>Months</th>
                    <th>Hub Received</th>
                    <th>Amount Given</th>
                    <th>Fixed Cost</th>
                    <th>Total Savings</th>
                    <th>Zabihat Maula(TUS)</th>
                    <th>Zabihat Students</th>
                    <th>Used</th>
                    <th>Remaining</th>
                  </tr>
                </thead>

                <tbody>

                    <?php
                    while($values = mysqli_fetch_assoc($result))
                    {
                    ?>
                    <tr>
                    <td><?php echo $values['Months']; ?></td>
                    <td><?php echo $values['Hub_Received']; ?></td>
                    <td><?php echo $values['Amount_for_Jaman_to_SF']; ?></td>
                    <td><?php echo $values['Fixed_Cost']; ?></td>
                    <td><?php echo $values['Total_Savings']; ?></td>
                    <td><?php echo $values['Frm_MaulaTUS']; ?></td>
                    <td><?php echo $values['Frm_Students']; ?></td>
                    <td><?php echo $values['Used']; ?></td>
                    <td><?php echo $values['Remaining']; ?></td>
                  </tr>                 
                   <?php } ?>
              
                </tbody>
              </table> 
</div>
</body>
</head>
</html>