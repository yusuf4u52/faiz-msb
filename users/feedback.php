<?php
include('_authCheck.php');
include('connection.php');

if ($_POST)
    {  
      $_POST['address'] = str_replace("'", "", $_POST['address']);

      mysqli_query($link,"INSERT INTO feedback (`thali_no`, `feedback`, `description`)
                          VALUES ('" . $_SESSION['thali'] . "', '".addslashes($_POST['feedback'])."','" . addslashes($_POST['desc']) . "')") or die(mysqli_error($link));

      header('Location: index.php?status=Thank you for your valuable feedback');       
    }
    

?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en">
  <head>
  <?php include('_head.php'); ?>
  <?php include('_bottomJS.php'); ?>
  </head>

  <body>

      <?php include('_nav.php'); ?>
    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Feedback for today's menu</h2>

            </div>

          </div>



        <div class="row">

          <div class="col-lg-6">

            <div class="well bs-component">

              <form class="form-horizontal" method="post">

                <fieldset>

                  <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label">Feedback</label>
                    <div class="col-lg-10">
                     <div class="radio">
                        <label><input type="radio" name="feedback" value="1">Option 1</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="feedback"  value="2">Option 2</label>
                      </div>
                      <div class="radio disabled">
                        <label><input type="radio" name="feedback"  value="3">Option 3</label>
                      </div>
                      </div>
                  </div>

                  <div class="form-group">

                    <label for="inputAddress" class="col-lg-2 control-label">Description</label>

                    <div class="col-lg-10">
                      <textarea class="form-control" id="inputDesc" name="desc"></textarea>

                    </div>

                  </div>


                  <div class="form-group">

                    <div class="col-lg-10 col-lg-offset-2">

                      <button type="submit" class="btn btn-primary" name='submit'>Submit</button>

                    </div>

                  </div>

                </fieldset>

              </form>

            </div>

          </div>
         
        </div>

      </div>

    </div>


  </body>
</html>