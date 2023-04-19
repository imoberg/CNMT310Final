<?php
require_once("autoload.php");
require_once(__DIR__ . "/classes/Page/Page.class.php");
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) { 
    $_SESSION['errors'][] = 'Please input a username and password';
    die(header("Location: " . LOGIN));

}
$bookmark = new Page("Bookmarks");

$bookmark->addHeadElement("<link href='./css/bookmark-styles.css' rel='stylesheet' />");
$bookmark->addHeadElement("<title>Document</title>");
print $bookmark->getTopSection();
print '        <div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="logout.php" class="navLogout">Logout |</a>';
$name = $_SESSION['inputs']->data->name;//this gets the users name so that we can display it below
print '            <span class="hiUsr">Hi '. $name . ' Here Are Your Bookmarks.</span>';
print '            <a href="index.php" class="navBookmarks">Bookmarks |</a>';
//this is for any errors that may have occured while trying to add or delete a bookmark
if(isset($_SESSION['errors']) && is_array($_SESSION['errors']) && count($_SESSION['errors']) > 0){
    foreach($_SESSION['errors'] as $field => $message) {
        print '<span class="errors">' . $message . '</span>';
    }
    $_SESSION['errors'] = array();
}
//this is for if you successfully add or delete a bookmark. 
if(isset($_SESSION['result']) && is_array($_SESSION['result']) && count($_SESSION['result']) > 0){
    foreach($_SESSION['result'] as $message) {
        print '<span class="success">' . $message . '</span>';

    }
    $_SESSION['result'] = array();
}
if(isset($_POST['btnAdd'])){ //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    print '            <form action=add-bookmark.php method="POST">';//this runs the add-bookmarks.php script
    print '            <span class="addTxt">Please add a bookmark</span>';
    print '            <span class=addURL>URL: </span>';
    print '            <input type="text" name="URL" class="addFrmURL" value="https://www."/>';
    print '            <span class="addName">Display Name: </span>';
    print '            <input type="text" name="displayname" class="addFrmName"/>';
    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Add +" />';
    print '            </form>';
    print '            <form method = "POST">';
    print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel"/>';
    print '            </form>';

}
if(isset($_POST['addCancel'])) {//adding message when you cancel adding or deleting bookmark
    print '<span class="errors">Canceled</span>';
    unset($_POST['addCancel']);
}    

if(isset($_POST['btnDelete'])){ //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    print '            <form action=delete-bookmarks.php method="POST">';//this runs the delete-bookmarks.php script
    print '            <span class="addTxt">Please delete a bookmark by ID Number</span>';
    print '            <span class=addURL>ID: </span>';
    print '            <input type="text" name="BookmarkID" class="addFrmURL"/>';

    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Delete -" />';
    print '            </form>';
    print '            <form method = "POST">';
    print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel"/>';
    print '            </form>';
}
print '            <form method = "POST">';
print '           <input type="submit" class="btnAdd" name="btnAdd" value="Add +"/>';
print '           <input type="submit" class="btnDelete" name="btnDelete" value= "Delete -"/>';
print '             </form>';
print '           <form action=search-bookmarks.php method="POST">';
print '           <span class="search">Search</span>';
print '           <input type="search" id="search" name="search" class="inputSearch">';
print '           <input type="submit" class="searchSubmit"/>';
print '           </form>';
print '           <ol class="scrollable-ol">';

//if search array is not set or isn't returned run the normal getbookmarks else return array of search bookmarks
if(!isset($_SESSION['search']) || !isset($_SESSION['search'][0]) || !is_array($_SESSION['search'][0]) || count($_SESSION['search'][0]) == 0){
    $id = $_SESSION['inputs']->data->id;

    $data = array("user_id" => $id);
    $action = "getbookmarks";
    $fields = array(
        "apikey" => APIKEY,
        "apihash" => APIHASH,
        "data" => $data,
        "action" => $action
    );
    $client->setPostFields($fields);

    $returnValue = $client->send();

    $obj = json_decode($returnValue);

    if (!property_exists($obj, "result")) {
        $_SESSION['errors'][] = "Error has occured";
        die(header("Location" . LOGIN));
    }

    if ($obj->result == 'Success') {
        $urlList = $obj->data;

        if (!is_array($urlList) || count($urlList) == 0) {
            print '<span class="bookmarkList">No Bookmarks Found</span>';
        } else {
            foreach ($urlList as $bookmarks) {
                $url = $bookmarks->url;
                $displayname = $bookmarks->displayname;
                $bookmarkID = $bookmarks->bookmark_id;
                print '<li><a class="bookmarkList" href="' . $url . '" target="_blank">' . $displayname . '&emsp; id: ' . $bookmarkID . '</a></li><br>';
            }
        }
    }
} else {//displaying the returned search list. 
    $urlList = $_SESSION['search'];
    foreach($urlList as $bookmarks){
        foreach($bookmarks as $arrBook){
            //print $arrBook->url;
            $href = $arrBook->url;
            //print $href;
            $displayname = $arrBook->displayname;
            $bookmarkID = $arrBook->bookmark_id;
            print '<li><a class="bookmarkList" href="' . $href . '" target="_blank">' . $displayname . '&emsp; id: ' . $bookmarkID .'</a></li><br>';
           
        }  
    }
    $_SESSION['search'] = array();


}
print '           </ol>';         
            //</span><span class="v1_84">Most Popular Bookmarks</span><span class="v1_85">1.
print '         </div>';            
$bookmark->addBottomElement("<div class='footerBack'></div>");
$bookmark->addBottomElement("<footer class='footerTxt'>&copy Copyright Isaac Moberg UWSP 2023</footer>;");
print $bookmark->getBottomSection();


?>