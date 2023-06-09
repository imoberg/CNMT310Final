<?php

require_once("autoload.php");
$_SESSION['loggedIn'] = false; 
$_SESSION['results'] = array();
$_SESSION['inputs'] = array();
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);

// Default is to POST. If you need to change to a GET, here's how:
//$client->setMethod("GET");

//$username = "alberta";
//$password = "";

$required = array('username','password');


foreach($required as $element) {
    if(!isset($_POST[$element]) ) {
        $_SESSION['results'][] = "Please input a username and password";
        header("Location: " . LOGIN);
        exit;
    }
}

foreach($required as $element) {
    if(empty($_POST[$element])) {
        $_SESSION['results'][] = "Please input a " . ucfirst($element);
        header("Location: " . LOGIN);
        exit;
    }    
}

if(count($_SESSION['results']) > 0){
    die(header("Location" . LOGIN)); 
}

$username = $_POST['username'];
$password = $_POST['password'];

$data = array("username" => $username, "password" => $password);
$action = "authenticate";
$fields = array("apikey" => APIKEY,
             "apihash" => APIHASH,
              "data" => $data,
             "action" => $action,
             );
$client->setPostFields($fields);

//For Debugging:
//var_dump($client);

$returnValue = $client->send();

$obj = json_decode($returnValue);
//possibly make a function to run this error handling
if(!property_exists($obj,"result")){
    $_SESSION['results'][] = "Error has occured";
    die(header("Location: " . LOGIN));
}



if($obj->result == 'Success'){
  $_SESSION['loggedIn'] = true;
  $_SESSION['inputs'] = $obj->data;
  die(header("Location: " . BOOKMARKS));  

} else {
    $_SESSION['results'][] = "Incorrect Username Or Password.";
    die(header("Location: " . LOGIN));
}
//print $obj->result;