<?php
include('connection.php');
include('adminsession.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head><?php include('_head.php'); ?></head>

  <body>

  <?php include('_nav.php'); ?>

    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Stop multiple thaalis at once (use carefully). Enter only comma saperated thaali numbers e.g. 1,2,3.</h2>

            </div>
            <div class="col-lg-6">

              <div class="well bs-component">

                <form class="form-horizontal">

                  <fieldset>


                   <div class="form-group">

                    <label for="thaliNumbers" class="col-lg-2 control-label">Thali No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="thaliNumbers" placeholder="Enter comma saperated thaali numbers" >
                      <input type="hidden" class="gregdate" id="stopDate" value="<?php echo date("Y-m-d") ?>"/>
                    </div>

                  </div>
                  <div class="form-group">

                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="button" class="btn btn-primary" id="stopThaliButton">Stop Thaali</button>
                    </div>

                  </div>

                </fieldset>

              </form>

              <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div></div>

            </div>
          </div>



        <div class="row">

          <div class="col-lg-6">
          </div>
        </div>

      </div>

    </div>
  <?php include('_bottomJS.php'); ?>
  <script src="./src/custom.js"></script>
  <script>
    $(function(){
      $('#stopThaliButton').click(function() {
        var regext = /^[0-9,]+$/;
        if(!regext.test($('#thaliNumbers').val().replace(/(^,)|(,$)/g, ""))) {
          alert('Please enter only numbers and comma.');
          return false;
        }
        var thaliNumbers = $('#thaliNumbers').val().replace(/(^,)|(,$)/g, "").split(',');
        for (var i = thaliNumbers.length - 1; i >= 0; i--) {
          var thaliNumber = thaliNumbers[i];
          if(confirm('Stop thaali #' + thaliNumber + ' ?')){
            stopThali_admin(thaliNumber, $('#stopDate').val());
          }
        }
      });
    });
  </script>

</body></html>