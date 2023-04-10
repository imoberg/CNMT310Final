<?php

//Nick's authentication attempt

require_once("autoload.php");
$_SESSION['loggedIn'] = false; 
$_SESSION = array();
//  __DIR__. "/../tos.php"
require_once("WebServiceClient.php");
require_once( "../../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);

// Default is to POST. If you need to change to a GET, here's how:
//$client->setMethod("GET");

//$apihash = "abdihjefij2fj2";
//$apikey = "api92859275";
//$username = "alberta";
//$password = "K9EWw9whx";

$required = array('username','password');
foreach ($required as $element){
	if(!isset($_POST[$element]) || (empty($_POST[$element]))) 
	die(header("Location: " . HOME));

	if(isset($_POST[$element]) && (!empty($_POST[$element]))) 
	$_SESSION['loggedIn'] = true;	
	//header('Location: ' . BOOKMARKS);
	//exit;
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

if(!property_exists($obj,"result")){
	die(print("Error"));
}

print $obj->result;