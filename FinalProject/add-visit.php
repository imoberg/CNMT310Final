<?php

require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("autoload.php");
require_once("WebServiceClient.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$required = array('BookmarkID');
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    $_SESSION['results'][] = 'Please input a username and password';
    die(header("Location: " . LOGIN));

}
if(count($_SESSION['results']) > 0){
    $_SESSION['results'][] = "Error has occured";
    die(header("Location:" . BOOKMARKS));

}

$addVisit = Bookmark::create()->setBookmakID($_POST['bookmarkID'])->setID($_SESSION['inputs']->id);
//var_dump($addVisit);
$returnValue = $addVisit->addVisit($client, $_SESSION);


if(isset($_SESSION['results'])){
    $_SESSION['results'][] = $returnValue;
    die(header("Location:" . BOOKMARKS));

}

?>