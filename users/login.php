
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
          <a class="navbar-brand font-bold" href="/users/">Poona Students Faiz</a>
        </div>
      </div>
    </nav>

    <div class="container">

      <!-- Forms

      ================================================== -->


        <div class="row">
          <div  class="col-lg-12">


<?php
session_start(); //session start

require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '765033679687-his12u278lmi6g3q7ltdmjsi64on8t0i.apps.googleusercontent.com'; 
$client_secret = 'BsR0zpEufi97oah8pZ_H1XA6';
$redirect_uri = 'http://www.faizstudents.com/users/login.php';

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
echo '<div style="margin:20px">';
if (isset($authUrl)){ 
  //show login url
  echo '<div align="center">';
  echo '<h1>Login with Google</h1>';
  echo '<div><h3>Please click login button to connect to Google.</h3></div>';
  echo '<a class="login" href="' . $authUrl . '"><img src="images/google-login-button.png" /></a>';
  echo '</div>';
  
} else {
  
  $user = $service->userinfo->get(); //get user info 

  $_SESSION['fromLogin'] = "true";
  $_SESSION['email'] = $user->email;
  header('Location: index.php');
}
echo '</div>';


?>





          </div>


      </div>

    </div>

      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <?php
      if(isset($_GET['status']))
      {
      ?>
      <script type="text/javascript">
      alert('<?php echo $_GET['status']; ?>');
      </script>

            <?php } ?>

</body></html>