<?php

require_once("autoload.php");;
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$_SESSION['result'] = array();

$required = array('BookmarkID');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['errors'][] = "Error please input a Bookmark ID<br> Click delete to try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}

/*if(count($_SESSION['errors']) > 0){
    die(header("Location" . LOGIN)); 
}*/



$bookmarkID = $_POST['BookmarkID'];
$id = $_SESSION['inputs']->data->id;

$data = array("bookmark_id" => $bookmarkID, "user_id" => $id);
$action = "deletebookmark";
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

    $_SESSION['result'][] = "Number of bookmarks deleted " . $obj->data->number_of_bookmarks_deleted;
    die(header("Location:" . BOOKMARKS));
} else {
    $_SESSION['errors'][] = "Error has occured";
    die(header("Location:" . BOOKMARKS));
}


?>