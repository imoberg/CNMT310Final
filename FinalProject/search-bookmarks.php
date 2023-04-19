<?php

require_once("autoload.php");;
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$_SESSION['search'] = array();

$required = array('search');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['errors'][] = "Error please input a Display Name <br>  Try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}

if(count($_SESSION['errors']) > 0){
    die(header("Location" . LOGIN)); 
}


$term = $_POST['search'];
$id = $_SESSION['inputs']->data->id;




$data = array( "user_id" => $id, "term" => $term);
$action = "searchbookmarks";
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

if ($obj->result == "Success" && !empty($obj->data)) {
    $_SESSION['result'][] = "Success";
    $_SESSION['search'][] = $obj->data;
    die(header("Location:" . BOOKMARKS));
} else {
    $_SESSION['errors'][] = "No Bookmarks Found";
    die(header("Location:" . BOOKMARKS));
}
/*will need to know the user ID which is returned when they log in 
isset and empty if they include http/https and if we should handle that. 

*/
?>