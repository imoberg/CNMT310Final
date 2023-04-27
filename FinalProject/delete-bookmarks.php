<?php

require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("autoload.php");
require_once("WebServiceClient.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
$required = array('BookmarkID');

foreach($required as $element) {
    if(!isset($_POST[$element]) || empty($_POST[$element]) || !is_numeric($_POST[$element])) {
        $_SESSION['results'][][] = "Error please input a Bookmark ID Number<br> Click delete to try again!";
        header("Location: " . BOOKMARKS);
        exit;
    }
}
if(!isset($_SESSION['inputs']->id) || empty($_SESSION['inputs']->id)){
    $_SESSION['results'][] = "Error Has Occured";
    die(header("Location: " . BOOKMARKS));
}

$deleteBookmark = Bookmark::create()->setBookmakID($_POST['BookmarkID'])->setID($_SESSION['inputs']->id);

$returnValue = $deleteBookmark->deleteBookmark($client, $_SESSION);



if(isset($returnValue)){
    $_SESSION['results'][] = $returnValue;
    die(header("Location: " . BOOKMARKS));
}

?>