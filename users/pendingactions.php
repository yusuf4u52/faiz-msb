<?php
include('connection.php');
include('adminsession.php');


    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending, Email_Id FROM thalilist";

      $query_new_transporter = $query . " WHERE Transporter = 'Transporter'  and active = 1 and Thali <> '' and Thali is not null";
    

    $result = mysqli_query($link,$query_new_transporter);

      $query_new_thali = $query . " WHERE (Thali = ''  or Thali is null) and active = 1";
    

    $result_new_thali = mysqli_query($link,$query_new_thali);

    

    
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <title>Faiz ul Mawaid il Burhaniyah (Poona Students)</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="./src/bootstrap.css" media="screen">

    <link rel="stylesheet" href="./src/custom.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>

      <script src="../bower_components/respond/dest/respond.min.js"></script>

    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <a class="navbar-brand">Faiz Students</a>

        </div>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>

      </div>

    </div>



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
                      <input type='text' name='thalino' class="form-control" required='required'></td>
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

    <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>



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