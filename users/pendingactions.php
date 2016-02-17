<?php
include('connection.php');
include('adminsession.php');


    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending, Email_Id FROM thalilist";
    $query_new_transporter = $query . " WHERE Transporter = 'Transporter'  and active = 1 and Thali <> '' and Thali is not null";
    $result = mysqli_query($link,$query_new_transporter);
    $query_new_thali = $query . " WHERE (Thali = ''  or Thali is null) and active = 0";
    $result_new_thali = mysqli_query($link,$query_new_thali);  

    
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

      <meta charset="utf-8" />

      <title>Faiz ul Mawaid il Burhaniyah (Poona Students)</title>

      <meta name="viewport" content="width=device-width, initial-scale=1" />

      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      <link rel="stylesheet" href="./src/bootstrap.css" media="screen" />

      <link rel="stylesheet" href="./src/custom.min.css" />

      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

      <!--[if lt IE 9]>

      <script src="javascript/html5shiv-3.7.0.min.js"></script>

      <script src="javascript/respond-1.4.2.min.js"></script>

      <![endif]-->
    </head>

  <body>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand font-bold" href="/users/">Poona Students Faiz</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>



    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

        <div class="row">

           <div class="col-lg-12">



          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="tables">Transporter request</h2>

            </div>

            <div class="bs-component">

              <table class="table table-striped table-hover ">

                <thead>

                  <tr>
                    
                    <th>Thali No</th>
                    <th>Transporter</th>
                    <th>Address</th>
                    <th>Name</th>
                    <th>Active</th>
                    
                  </tr>

                </thead>

                <tbody>
                  <?php
                    while($values = mysqli_fetch_assoc($result))
                    {
                  ?>
                  <tr>

                    
                    <td><?php echo $values['Thali']; ?></td>
                    <td>
                          <select class='transporter'>
                            <option>Select</option>
                            <option value='<?php echo $values['Thali']; ?>|Azhar Bhai'>Azhar Bhai</option>
                            <option value='<?php echo $values['Thali']; ?>|Mustafa Bhai'>Mustafa Bhai</option>
                            <option value='<?php echo $values['Thali']; ?>|Saifee Bhai'>Saifee bhai</option>
                          </select>
                    </td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    


                  </tr>
                  <?php } ?>

                </tbody>

              </table> 

            </div><!-- /example -->
            

          </div>


          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="tables">New Thali</h2>

            </div>

            <?php 
            $sql = mysqli_query($link,"SELECT MAX(Thali) from thalilist");
            $row = mysqli_fetch_row($sql);
            $plusone = $row[0] + 1;

            echo "Thali No. :: $plusone  can be given" ;
            ?> 

            <div class="bs-component">

              <table class="table table-striped table-hover ">

                <thead>

                  <tr>
                    
                    <th>Thali No</th>
                    <th>Transporter</th>
                    <th>Address</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th></th>
                    
                  </tr>

                </thead>

                <tbody>
                  <?php
                    while($values = mysqli_fetch_assoc($result_new_thali))
                    {
                  ?>
                  <form action='activatethali.php' method='post'>
                  <tr>

                    
                    <td>
                      <input type='hidden' value='<?php echo $values['Email_Id']; ?>' name='email'>
                      <input type='hidden' value='<?php echo $values['NAME']; ?>' name='name'>
                      <input type='hidden' value='<?php echo $values['CONTACT']; ?>' name='contact'>
                      <input type='hidden' value='<?php echo $values['Full_Address']; ?>' name='address'>
                      <input type='hidden' value='<?php echo $values['Transporter']; ?>' name='trasnporter'>
                      <input type='text' name='thalino' class='' required='required'></td>
                    <td>
                        <?php if($values['Transporter'] == 'Transporter') { ?>
                          <select name="transporter"  required='required'>
                            <option value=''>Select</option>
                            <option value='Azhar Bhai'>Azhar Bhai</option>
                            <option value='Mustafa Bhai'>Mustafa Bhai</option>
                            <option value='Saifee Bhai'>Saifee bhai</option>
                          </select>
                          <?php }
                          else
                          {
                            echo "Pick up";
                          }
                          ?>
                    </td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    <td><input type='submit' value='Activate'></td>
                    <td><input type='submit' value='Reject' formaction="reject.php"></td>
                  </tr>
                </form>
                  <?php } ?>

                </tbody>

              </table> 

            </div><!-- /example -->
            

          </div>

      



          </div>
        </div>

      </div>

    </div>

    <script src="javascript/jquery-2.2.0.min.js"></script>
    <script src="javascript/bootstrap-3.3.6.min.js"></script>

    <script type="text/javascript">

    
      $(function() {
  // Handler for .ready() called.
  
  $(".transporter").change(function() {

            if(confirm('Are you sure?'))
            {
            $.ajax({
              type: "POST",
              url: "savetransporter.php",
              data: {'data':this.value},
              success:function(data) {
                window.location.href = window.location.href;
              }
          }); 
          }
          else
          {
            return false;
          }

      });
});
    </script>

    

</body></html>