<?php
require_once("autoload.php");
require_once(__DIR__ . "/classes/Page/Page.class.php");
require_once(__DIR__ . "/classes/Bookmark/Bookmark.class.php");
require_once("WebServiceClient.php");
require_once(__DIR__ . "/../tos.php");
$url = "https://cnmt310.classconvo.com/bookmarks/";
$client = new WebServiceClient($url);
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    $_SESSION['results'][] = 'Please input a username and password';
    die(header("Location: " . LOGIN));

}
$_SESSION['popBookmarks'] = array();

$bookmark = new Page("Bookmarks");
$bookmark->addHeadElement('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
$bookmark->addHeadElement("<link href='./css/bookmark-styles.css' rel='stylesheet' />");
$bookmark->addHeadElement('<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>');
$bookmark->addHeadElement("<script src='./js/addvisit.js'></script>");
$bookmark->addHeadElement("<title>Bookmarks</title>");
print $bookmark->getTopSection();
print '        <div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="logout.php" class="navLogout">Logout |</a>';
$name = $_SESSION['inputs']->name; //this gets the users name so that we can display it below
print '            <span class="hiUsr">Hi ' . $name . ' Here Are Your Bookmarks.</span>';
print '            <span class="popBookmarks">Most Popular Bookmarks</span>';
print '            <a href="index.php" class="navBookmarks">Bookmarks |</a>';
#region "SESSION errors printing"
//this is for any errors that may have occured while trying to add or delete a bookmark
if (isset($_SESSION['results']) && is_array($_SESSION['results']) && count($_SESSION['results']) > 0) {
    foreach ($_SESSION['results'] as $result) {
        foreach($result as $message) {
            print '<span class="errors">' . $message . '</span>';
        }
    }
    $_SESSION['results'] = array();
}
#endregion
#region "ADD CLICK"
if (isset($_POST['btnAdd'])) { //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    print '            <form action=add-bookmark.php method="POST">'; //this runs the add-bookmarks.php script
    print '            <span class="addTxt">Please add a bookmark</span>';
    print '            <span class=addURL>URL: </span>';
    print '            <input type="text" name="URL" class="addFrmURL" value="https://"/>';
    print '            <span class="addName">Display Name: </span>';
    print '            <input type="text" name="displayname" class="addFrmName"/>';
    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Add +" />';
    print '            </form>';
    print '            <form method = "POST">';
    print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel"/>';
    print '            </form>';
}
#endregion
#region "CANCEL ADD/DELETE"
if (isset($_POST['addCancel'])) { //adding message when you cancel adding or deleting bookmark
    print '<span class="errors">Canceled</span>';
    unset($_POST['addCancel']);
}
#endregion
#region "DELETE CLICK"
if (isset($_POST['btnDelete'])) { //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    print '            <form action=delete-bookmarks.php method="POST">'; //this runs the delete-bookmarks.php script
    print '            <span class="addTxt">Please delete a bookmark by ID Number</span>';
    print '            <span class=addURL>ID: </span>';
    print '            <input type="text" name="BookmarkID" class="addFrmURL"/>';
    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Delete -" />';
    print '            </form>';
    print '            <form method = "POST">';
    print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel"/>';
    print '            </form>';
}
#endregion
print '           <form method = "POST">';
print '                <input type="submit" class="btnAdd" name="btnAdd" value="Add +"/>';
print '                <input type="submit" class="btnDelete" name="btnDelete" value= "Delete -"/>';
print '           </form>';
print '           <form action=search-bookmarks.php method="POST">';
print '                <span class="search">Search</span>';
print '                <input type="search" id="search" name="search" class="inputSearch">';
//WILL NEED TO IMPLIMENT THE AUTO COMPLETE HERE
print '                 <input type="submit" class="searchSubmit" id="search"/>';
print '           </form>';
print '           <span class="displayName">Display Name    | &emsp;&emsp; Bookmark ID   | &emsp;&emsp; Visits  |</span>';
print '           <span class="popDisplayName">Display Name    | &emsp;&emsp; Bookmark ID   | &emsp;&emsp; Visits  |</span>';
print '           <ol class="scrollable-ol" id="ol">';
#region "Listing Bookmarks"
//if search array is not set or isn't returned run the normal getbookmarks else return array of search bookmarks
if (!isset($_SESSION['search']) || !isset($_SESSION['search'][0]) || !is_array($_SESSION['search'][0]) || count($_SESSION['search'][0]) == 0) {
    $gettingBookmark = Bookmark::create()->setID($_SESSION['inputs']->id);
    $returnValue = $gettingBookmark->getBookmarks($client, $_SESSION);
    if (isset($returnValue) || !empty($returnValue)) {
        foreach ($returnValue as $bookmarks) {
            if (!is_array($bookmarks)) {
                print $bookmarks;
            } else {
                foreach ($bookmarks as $element) {
                    //var_dump($element);
                    $url = $element->url;
                    $displayname = $element->displayname;
                    $bookmarkID = $element->bookmark_id;
                    $numberVisits = $element->visits;
                    if ($numberVisits >= 10) {
                        $_SESSION['popBookmarks'][] = $element;
                    }
                    print '<li><a class="bookmarkList" href="' . $url . '"id="' . $bookmarkID . '" target="_blank"">' . $displayname . '</a><span class="bookmarkID">ID:' . $bookmarkID . '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $numberVisits . '</span></li>';
                    print '<li>____________________________________________________</li><br><br>';
                }
            }
        }
    } else {
        $_SESSION['results'][] = "Failed to get Bookmarks";
        //die(header("Location: " . BOOKMARKS));
    }
} else { //displaying the returned search list. 
    $urlList = $_SESSION['search'];
    foreach ($urlList as $bookmarks) {
        foreach ($bookmarks as $arrBook) {
            $href = $arrBook->url;
            $displayname = $arrBook->displayname;
            $bookmarkID = $arrBook->bookmark_id;
            $numberVisits = $arrBook->visits;
            //idea: instead of linking the url we link the add-visit.php that will redirect them to their bookmark page after adding a visit. 
            print '<li><a class="bookmarkList" href="' . $url . '"id="' . $bookmarkID . '" target="_blank"">' . $displayname . '</a><span class="bookmarkID">ID:' . $bookmarkID . '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $numberVisits . '</span></li>';
            print '<li>___________________________________________________</li><br><br>';
        }
    }
    $_SESSION['search'] = array();
}
#endregion
print '           </ol>';
print '<ol class="popularol">';
#region "Listing Popular Bookmarks"
if (isset($_SESSION['popBookmarks']) || !empty($_SESSION['popBookmarks'])) {
    foreach ($_SESSION['popBookmarks'] as $bookmarks) {
        $url = $bookmarks->url;
        $displayname = $bookmarks->displayname;
        $bookmarkID = $bookmarks->bookmark_id;
        $numberVisits = $bookmarks->visits;
        print '<li><a class="popbookmarkList" href="' . $url . '"onclick="runVisit(' . $bookmarkID . ');" target="_blank"">' . $displayname . '</a><span class="bookmarkID">ID:' . $bookmarkID . '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . $numberVisits . '</span></li>';
        print '<li>____________________________________________________</li><br><br>';
    }
}
#endregion
print '</ol>';
print '         </div>';
$bookmark->addBottomElement("<div class='footerBack'></div>");
$bookmark->addBottomElement("<footer class='footerTxt'>&copy Copyright Isaac Moberg UWSP 2023</footer>;");
print $bookmark->getBottomSection();
?>