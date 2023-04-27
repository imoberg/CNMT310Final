<?php

require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("autoload.php");
require_once("WebServiceClient.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);

$required = array('search');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) ) {
        $_SESSION['results'][][] = "Error please input a Display Name <br>  Try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}
if(!isset($_SESSION['inputs']->id) || empty($_SESSION['inputs']->id)){
    $_SESSION['results'][][] = "Error Has Occured";
    die(header("Location: " . BOOKMARKS));
}

$searchBookmark = Bookmark::create()->setID($_SESSION['inputs']->id)->setSearchTerm($_POST['search']);

$returnValue = $searchBookmark->searchBookmark($client, $_SESSION);

if(isset($returnValue)){
    $_SESSION['search'] = $returnValue;
    die(header("Location: " . BOOKMARKS));
}


?>