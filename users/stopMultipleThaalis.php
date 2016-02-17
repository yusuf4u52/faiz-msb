<?php
include('connection.php');
include('adminsession.php');
?>
<!DOCTYPE html>
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

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Thali Search</h2>

            </div>
            <div class="col-lg-6">

              <div class="well bs-component">

                <form class="form-horizontal">

                  <fieldset>


                   <div class="form-group">

                    <label for="thaliNumbers" class="col-lg-2 control-label">Thali No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="thaliNumbers" placeholder="Thali No" name="thalino">
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

  <script src="javascript/jquery-2.2.0.min.js"></script>
  <script src="javascript/bootstrap-3.3.6.min.js"></script>
  <script src="javascript/moment-2.11.1-min.js"></script>
  <script src="javascript/moment-hijri.js"></script>
  <script src="javascript/hijriDate.js"></script>
  <script src="javascript/index.js"></script>
  <script src="./src/custom.js"></script>
  <script>
    $(function(){
      $('#stopThaliButton').click(function() {
        var thaliNumbers = $('#thaliNumbers').val().split(',');
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