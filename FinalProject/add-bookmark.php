<?php

require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("autoload.php");
require_once("WebServiceClient.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$required = array('URL','displayname');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['errors'][] = "Error please input a URL and a Display Name <br> Click add to try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}
if(!isset($_SESSION['inputs']->id) || empty($_SESSION['inputs']->id)){
    $_SESSION['errors'][] = "Error No USER ID ";
    die(header("Location: " . BOOKMARKS));
}
//add the https handling and displayname chars

if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])){
    die(header("Location: " . BOOKMARKS));
}

$addBookmark = Bookmark::create()->setID($_SESSION['inputs']->id)->setURL($_POST['URL'])->setDisplayName($_POST['displayname']);

$returnValue = $addBookmark->addBookmark($client, $_SESSION);



if(isset($returnValue)){
    $_SESSION['results'][] = $returnValue;
    die(header("Location: " . BOOKMARKS));
}



?>