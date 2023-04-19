<?php

require_once("autoload.php");;
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$_SESSION['result'] = array();

$required = array('URL','displayname');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['errors'][] = "Error please input a URL and a Display Name <br> Click add to try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}

if(count($_SESSION['errors']) > 0){
    die(header("Location" . LOGIN)); 
}
if(!str_contains($_POST['URL'], "https://www.")){
    $_SESSION['errors'][] = "Error incorrect format<br> URL must have 'https//:www.(website here)' ";
    die(header("Location:" . BOOKMARKS));
}

$url = $_POST['URL'];
$displayName = $_POST['displayname'];
$id = $_SESSION['inputs']->data->id;



$data = array("url" => $url, "displayname" => $displayName, "user_id" => $id);
$action = "addbookmark";
$fields = array("apikey" => APIKEY,
                "apihash" => APIHASH,
                "data" => $data,
                "action" => $action,
                );

$client->setPostFields($fields);

$returnValue = $client->send();

$obj = json_decode($returnValue);
//possibly make a function to run this error handling
if(!property_exists($obj,"result")){
    $_SESSION['errors'][] = "Error has occured";
    die(header("Location: " . LOGIN));
}

if ($obj->result == "Success") {
    $_SESSION['result'][] = "Success";
    die(header("Location:" . BOOKMARKS));
} else {
    $_SESSION['errors'][] = "Error has occured";
    die(header("Location:" . BOOKMARKS));
}
/*will need to know the user ID which is returned when they log in 
isset and empty if they include http/https and if we should handle that. 

*/
?>