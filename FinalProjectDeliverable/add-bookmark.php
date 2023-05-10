<?php

require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("autoload.php");
require_once("WebServiceClient.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$required = array('URL','displayname');
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    $_SESSION['results'][] = 'Please input a username and password';
    die(header("Location: " . LOGIN));

}
foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['results'][][] = "Error please input a URL and a Display Name <br> Click add to try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}
if(!isset($_SESSION['inputs']->id) || empty($_SESSION['inputs']->id)){
    $_SESSION['results'][] = "Error No USER ID ";
    die(header("Location: " . BOOKMARKS));
}

if (!str_contains($_POST['URL'], "https://")) {
    $_SESSION['results'][][] = "Error incorrect format<br> URL must have 'https//:(website here)' ";
    die(header("Location: " . BOOKMARKS));

}
if(strlen($_POST['displayname']) > 10){
    $_SESSION['results'][][] = "Display Name must be between 1 and 10 characters";
    die(header("Location: " . BOOKMARKS));
}

if(!isset($_POST['shared'])){
    $_SESSION['results'][][] = "Must choose to share or not!";
    die(header("Location: " . BOOKMARKS));
}

if(isset($_SESSION['results']) && !empty($_SESSION['results'])){
    die(header("Location: " . BOOKMARKS));
}

$addBookmark = Bookmark::create()->setID($_SESSION['inputs']->id)->setURL($_POST['URL'])->setDisplayName($_POST['displayname'])->setShared($_POST['shared']);



$returnValue = $addBookmark->addBookmark($client, $_SESSION);

//var_dump($returnValue);


if(isset($returnValue)){
    $_SESSION['results'][] = $returnValue;
    die(header("Location: " . BOOKMARKS));
}


?>