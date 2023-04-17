<?php
require_once("autoload.php");
require_once(__DIR__ . "/classes/Page/Page.class.php");

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
if(isset($_SESSION['errors']) && is_array($_SESSION['errors']) && count($_SESSION['errors']) > 0){
    foreach($_SESSION['errors'] as $field => $message) {
        print '<span class="errors">' . $message . '</span>';
    }
    $_SESSION['errors'] = array();
}
if(isset($_POST['btnAdd'])){ //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    print '            <form action=add-bookmark.php method="POST">';//this runs the add-bookmarks.php script
    print '            <span class="addTxt">Please add a bookmark</span>';
    print '            <span class=addURL>URL: </span>';
    print '            <input type="text" name="URL" class="addFrmURL"/>';
    print '            <span class="addName">Display Name: </span>';
    print '            <input type="text" name="displayname" class="addFrmName"/>';
    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Add +" />';
    print '            </form>';
}

if(isset($_POST['btnDelete'])){ //this if statement will run when the button "btnAdd" is click and the code below is then shown.
    //print '            <form action=delete-bookmark.php method="POST">';//this runs the delete-bookmarks.php script
    print '            <form action=add-bookmark.php method="POST">';//using this as a placeholder until we figure out how to delete
    print '            <span class="addTxt">Please delete a bookmark by ID Number</span>';
    print '            <span class=addURL>ID: </span>';
    print '            <input type="text" name="BookmarkID" class="addFrmURL"/>';
 /*   print '            <span class="addName">Display Name: </span>';
    print '            <input type="text" name="displayname" class="addFrmName"/>';*/
    print '            <input type="submit" class="addSubmit" name="addSubmit" value="Delete -" />';
    print '            </form>';
}
print '            <form method = "POST">';
print '           <input type="submit" class="btnAdd" name="btnAdd" value="Add +"/>';
print '           <input type="submit" class="btnDelete" name="btnDelete" value= "Delete -"/>';
print '             </form>';
print '           <span class="search">Search</span>';
print '           <input type="text" id="search" name="search" class="inputSearch">';
            //need all the bookmarks here.
print '           <ol>';
print '                <li>';            
            //</span><span class="v1_84">Most Popular Bookmarks</span><span class="v1_85">1.
print '         </div>';            
$bookmark->addBottomElement("<div class='footerBack'></div>");
$bookmark->addBottomElement("<footer class='footerTxt'>&copy Copyright Isaac Moberg UWSP 2023</footer>;");
print $bookmark->getBottomSection();


?>