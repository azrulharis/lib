<?php
session_start();
 

date_default_timezone_set("Asia/Kuala_Lumpur");


if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
 

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR']; 
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED']; 
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
} 
 

 // http://hq.mytsg.com.my:7331/rps/';

$version = 1.1;

$date = date('Y-m-d H:i:s'); 

$status = 0;

$path = '/';

//$api = "http://hq.mytsg.com.my:7331/rps/";
$api = "http://hq.mytsg.com.my:7331/rps/";

$attendance = array();
$user = array();

$attendance['code'] = '';
$attendance['name'] = '';
$attendance['phone'] = '';

$attendance['branch'] = '';
$attendance['temperature'] = '';

$attendance['clock_in'] = '';

$success = false;
$message = '';
$token = '';

$user_id = 0;
 
if(isset($_POST['name'])) {

  $_SESSION['USUCCESS'] = 0;

  if($_POST['name'] != '' && $_POST['username'] != '' && $_POST['phone'] != '' && $_POST['site'] != '') {
    if($_POST['address'] != '') {
      
      $_POST['u'] = $user_id;
      $url = $api . "attendances/ajax_mco_attendance";

      $_POST['ip'] = get_client_ip(); 
      $_POST['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

      $postdata = json_encode($_POST);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      $result = curl_exec($ch);

      // var_dump($result);
 

      if (curl_errno($ch)) { 
         print curl_error($ch) . ' ' . curl_error($ch); 
      } 

      $result = json_decode($result, true); 

      curl_close($ch);

      if($result['status'] == true) {
        $success = true;
        $message = $result['message'];   

        $user_id = $result['data']['User']['id'];

        ob_start();

        setcookie(
          "att_user_id",
          $user_id,
          time() + 60 * 60 * 24
        );

        $_SESSION['USUCCESS'] = 1;
        header('location: ' . $path);
      } else {
        $message = $result['message']; 
      } 

    } else {
      $message = 'Please enable Device Location.';
    }
  } else {
    $message = 'Please fill all fields.';
  } 

  $attendance = $_POST;
  $attendance['code'] = $_POST['username'];
}

if(isset($_GET['message']) && isset($_GET['success'])) {
  $message = $_GET['message']; 
  $success = $_GET['success']; 
}
  

if(isset($_COOKIE['att_user_id'])) {
  if(is_numeric($_COOKIE['att_user_id'])) { 

    $user_id = $_COOKIE['att_user_id']; 

    $url = $api . "attendances/mco_api?user_id=" . $user_id . '&type=6';
      
    //  Initiate curl
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    // Execute
    $result = curl_exec($ch);
    // Closing  

    curl_close($ch);

    // Will dump a beauty json :3
    $json = json_decode($result, true); 
 
 
    if($json['attendance']) {

      $status = 1;

      $attendance = $json['attendance']['Attendance'];
      $attendance['clock_in'] = $json['attendance']['Attendance']['clock_in'];
      
    }

    if($json['user']) {

      $user = $json['user']['User']; 

      $attendance['code'] = $user['username'];
      $attendance['name'] = $user['firstname'];
      $attendance['phone'] = $user['mobile_number'];
    }
  }
}  



?>

<!DOCTYPE html>
<html lang="en"> 
  <head> 
    <!-- Behavioral Meta Data -->
    <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="apple-mobile-web-app-capable" content="yes">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#46556b">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">


    <link rel="apple-touch-icon" sizes="57x57" href="ico/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="ico/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="ico/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="ico/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="ico/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="ico/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="ico/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="ico/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="ico/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="ico/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="ico/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
<link rel="manifest" href="ico/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="ico/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

    <!-- SEO Meta Data -->
    <title>TSG Site Attendance</title>
          <meta name="author" content="">
          <meta name="description" content="Site Attendance">
          <meta name="keywords" content="">

    <!-- Styles -->
          <link rel="stylesheet" type="text/css" href="css/styles.min.css?ver=<?php echo $version; ?>">
          <link rel="stylesheet" type="text/css" href="jquery_UI/jquery-ui.min.css"/>
          <link rel="stylesheet" type="text/css" href="jquery_UI/jquery-ui-timepicker-addon.css"/>

  </head>

  <body>

    
    <div class="section section-2 blue-white center">
      <div class="inner" > 
        
        <div class="row"> 
  <div class="col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>TSG Site Attendance</h2>

        <div class="clearfix"></div>

        <a href="manual.php" style="color: #fff">User Manual</a> 

        <?php if($attendance['code']) { ?>
          &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; 
          <a href="<?php echo $api . 'attendances/site_history/' . $attendance['code']; ?>" style="color: #fff">History</a>
        <?php } ?>  
        <br/>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
<?php  
if($message != '' && $success == false) { ?>
  <div class="error" id="error"><p><?php echo $message; ?></p></div>
<?php } 

if($message != '' && $success == true) { ?>
  <div class="success" id="success"><p><?php echo $message; ?></p></div>
<?php }  
?>  

<div id="geoLocationErr" class="error" style="display: none"></div>
    
<form action="" id="submitForm" class="form-horizontal" method="post" accept-charset="utf-8">



<div id="showHide">

  <div class="form-group">
    <label class="col-sm-3 col-xs-12">Status</label>
    <div class="col-sm-9 col-xs-12">
      <?php 
      $button = 'Clock In';
      if($status == 1) { 
        $button = 'Clock out';
      ?> 
        <b>You are clocked in on <?php echo $attendance['clock_in']; ?></b>
      <?php } else { ?>
        <b>You are out. Please clock in</b>
      <?php } ?>
    </div>  
  </div>
  
  <div class="form-group">
  <label class="col-sm-3 col-xs-12">TSG ID *</label>
  <div class="col-sm-9 col-xs-12">
    <input name="username" id="username" class="form-control" placeholder="TSG ID" required="required" maxlength="125" type="text" value="<?php echo $attendance['code']; ?>" autocomplete="off"/>  
    </div>  
  </div>   

  <div class="form-group">
  <label class="col-sm-3 col-xs-12">Full Name *</label>
  <div class="col-sm-9 col-xs-12">
    <input name="name" id="name" class="form-control" placeholder="Full Name" required="required" maxlength="255" type="text" value="<?php echo $attendance['name']; ?>" autocomplete="off"/>          
  </div> 
  </div>

  <div class="form-group">
  <label class="col-sm-3 col-xs-12">Phone No *</label>
  <div class="col-sm-9 col-xs-12">
    <input name="phone" id="phone" class="form-control" placeholder="Phone no" required="required" maxlength="255" type="text" value="<?php echo $attendance['phone']; ?>" autocomplete="off"/>          
  </div> 
  </div>

  <div class="form-group">
  <label class="col-sm-3 col-xs-12">Site Name *</label>
  <div class="col-sm-9 col-xs-12">
    <input value="<?php echo $attendance['branch']; ?>" name="site" id="site" class="form-control" placeholder="Site name / location" required="required" maxlength="255" type="text" autocomplete="off" />          
  </div> 
  </div>
  
  <div class="form-group">
  <label class="col-sm-3 col-xs-12">Temperature *</label>
  <div class="col-sm-9 col-xs-12">
    <input value="<?php echo $attendance['temperature']; ?>" name="temperature" id="temperature" class="form-control" placeholder="Body Temperature" required="required" type="text" autocomplete="off" />          
  </div> 
  </div>

  <div class="form-group">
  <label class="col-sm-3 col-xs-12">Health Status *</label>
  <div class="col-sm-9 col-xs-12">
    <select name="wfh_health" id="wfh_health" class="form-control" required="required">
      <option value="">-Select Health Status-</option> 
    <option value="Good">Good</option> 
    <option value="Not Well">Not Well</option>    
    </select>    
  </div> 
  </div>

  
      <input type="hidden" name="reason" id="activity"/>    
      <input type="hidden" name="status" id="status" value="0"/>      
              
      <input type="hidden" name="type" id="type" value="3"/>

          <input type="hidden" name="lat" id="lat"/>
          <input type="hidden" name="long" id="long"/>
          <input type="hidden" name="address" id="address"/> 

          <input type="hidden" name="t" id="time" value="<?php echo $date; ?>"/>   

<div class="separator"> 
            <div class="clearfix"></div> 
            <div id="response"></div> 
            <div id="loading" style="display:none">Please wait...</div>
          </div>  

      <div class="form-group">
        <label class="col-sm-3 col-xs-12">&nbsp;</label>
        <div class="col-sm-9 col-xs-12">
          <button class="button btn-success pull-right" type="submit" name="submit" id="submit"><?php echo $button; ?></button>        
        </div>
      </div>
<p>If you see any geolocation error message, open app.mytsg.com.my by using chrome, go to Settings > Site Settings > Location and allow access location for app.mytsg.com.my.</p>
      <p>Once submit, your information will be saved for the next Clock in/out unless you're disabled or clearing <b>Cookie or Browsing Histories</b></p>
</div>

         

 
        </form>

          
    </div> 
  </div>
</div>
</div>

      </div>
    </div>
<input type="hidden" name="u" id="u">
 

    <!-- S C R I P T S -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>

    <script type="text/javascript" src="jquery_UI/jquery-ui.min.js"></script>
    <script type="text/javascript" src="jquery_UI/jquery-ui-timepicker-addon.js"></script>


<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
  type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
  type="text/javascript" charset="utf-8"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-35302878-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-35302878-1');
</script>

<script type="text/javascript">  

  function geocode(query){
    $('#loading').show();
    $.ajax({
      url: 'https://api.opencagedata.com/geocode/v1/json',
      method: 'GET',
      data: {
        'key': '3423837a58d04513a4cff337a76adc93',
        'q': query,
        'no_annotations': 1
        // see other optional params:
        // https://opencagedata.com/api#forward-opt
      },
      dataType: 'json',
      success: function(response) {
          $('#address').val(response.results[0].formatted);
            $('#loading').hide();

            $('#geoLocationErr').html('Device location turned on');
            $('#geoLocationErr').removeClass('error').addClass('success');
        },
      statusCode: {
        200: function(response){  // success
          console.log(response.results[0].formatted);
          $('#address').val(response.results[0].formatted);
          $('#loading').hide();
        },
        402: function(){
          console.log('hit free-trial daily limit'); 
          $('#loading').hide();
        }
        // other possible response codes:
        // https://opencagedata.com/api#codes
      }
    });
  }

function successFunction(position) {
  var lat = position.coords.latitude;
  var long = position.coords.longitude;
  console.log('Your latitude is :'+lat+' and longitude is '+long);
  $('#lat').val(lat);
  $('#long').val(long);
  
  var query = lat + ',' + long;
  geocode(query);
}

function errorFunction(err) {
  //console.log(err); 
  $('#geoLocationErr').show();
  $('#geoLocationErr').html(err.message);
}

$(document).ready(function() { 

  document.hidden; // Returns true if the page is in a state considered to be hidden to the user, and false otherwise.

  document.visibilityState;

  setTimeout(function(){ 
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction); 
  }, 3000);
  

  $('#wfh_health').on('change', function() {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);  
  })
 
});
 

  function findUser(val) {
    $('#username').autocomplete({ 
        source: function (request, response){ 
            $.ajax({
                type: "GET",                        
                url: 'ajax_user.php',           
                contentType: "application/json",
                dataType: "json",
                data: "term=" + val,                                                    
                success: function (data) { 
                  response($.map(data, function (item) {
                      return {
                          id: item.id,
                          value: item.username,
                          name : item.name,
                          email: item.email,
                          group: item.group,
                          mobile_number: item.mobile_number 
                      }
                  }));
              }
            });
        },
        select: function (event, ui) {   
            $('#name').val(ui.item.name);
            $('#phone').val(ui.item.mobile_number);
            $('#u').val(ui.item.id);
        },
        minLength: 3
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" ).append( "<div>" + item.value + "<br><small>" + item.name + "</small>" +  "</div>" ).appendTo( ul );
    }; 
  }

$(document).ready(function() { 

  $('#submitForm').on('submit', function(e) {
    //e.preventDefault();


  })

  $('#username').on('keyup change', function() {
    var val = $('#username').val();
 
    var val = val.replace(/[^a-zA-Z0-9]/g,'');

    $(this).val(val);

    console.log(val);
    findUser(val);
  });
  
  $('.focus').focus(); 
  
});
</script>

</body>
</html> 