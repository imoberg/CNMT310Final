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
$popBookmarks = array();

$bookmark = new Page("Bookmarks");
$bookmark->addHeadElement('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
$bookmark->addHeadElement("<link href='./css/bookmark-styles.css' rel='stylesheet' >");
$bookmark->addHeadElement('  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>');
$bookmark->addHeadElement('<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>');
$bookmark->addHeadElement("<script src='./js/functionality.js'></script>");
print $bookmark->getTopSection();
print '<div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="logout.php" class="navLogout">Logout |</a>';
$name = $_SESSION['inputs']->name; //this gets the users name so that we can display it below
print '            <span class="hiUsr">Hi ' . $name . ' Here Are Your Bookmarks.</span>';
print '            <a href="index.php" class="navBookmarks">Bookmarks |</a>';
#region "SESSION errors printing"
//this is for any errors that may have occured while trying to add or delete a bookmark
if (isset($_SESSION['results']) && is_array($_SESSION['results']) && count($_SESSION['results']) > 0) {
    foreach ($_SESSION['results'] as $result) {
        foreach ($result as $message) {
            print '<span class="errors">' . $message . '</span><br>';
        }
        $_SESSION['results'] = array();
    }
}
#endregion
#region "CANCEL ADD/DELETE"
if (isset($_POST['addCancel'])) { //adding message when you cancel adding or deleting bookmark
    print '<span class="errors">Canceled</span>';
    unset($_POST['addCancel']);
    print '<span class="errors"> </span>';
}
#endregion
#region "Adding and Deleting Bookmarks"
print '           <div class= "func">';
print '                <button class="btnAdd" name="btnAdd" data-tab="#add">Add +</button>';
print '                <button class="btnDelete" name="btnDelete" data-tab="#delete">Delete -</button>';
print '           </div>';
print '           <div id="add" class= "funccontent">';
print '            <form action=add-bookmark.php method="POST">'; //this runs the add-bookmarks.php script
print '            <span class="addTxt">Please add a bookmark</span>';
print '            <span class=addURL>URL: </span>';
print '            <input type="text" name="URL" class="addFrmURL" value="https://">';
print '            <span class="addName">Display Name: </span>';
print '            <input type="text" name="displayname" class="addFrmName">';
print '            <span class="addShared">Share: </span>';
print '            <label class="labelYes" for="true">Yes</label>';
print '            <input type="radio" id="true" class="radioTrue" name="shared" value="true" checked>';
print '            <label class="labelNo" for="false">No</label>';
print '            <input type="radio" id="false" class="radioFalse" name="shared" value="false">';
print '            <input type="submit" class="addSubmit" name="addSubmit" value="Add +" >';
print '            </form>';
print '            <form method = "POST">';
print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel">';
print '            </form>';
print '           </div>';
print '           <div id="delete" class= "funccontent">';
print '            <form action=delete-bookmarks.php method="POST">'; //this runs the delete-bookmarks.php script
print '            <span class="addTxt">Please delete a bookmark by ID Number</span>';
print '            <span class=addURL>ID: </span>';
print '            <input type="text" name="BookmarkID" class="addFrmURL">';
print '            <input type="submit" class="addSubmit" name="addSubmit" value="Delete -" >';
print '            </form>';
print '            <form method = "POST">';
print '            <input type="submit" class="addCancel" name="addCancel" value="Cancel">';
print '            </form>';
print '           </div>';
#endregion
#region "Listing Bookmarks"
$ac = array();
$gettingBookmark = Bookmark::create()->setID($_SESSION['inputs']->id);
$returnValue = $gettingBookmark->getBookmarks($client, $_SESSION);
if (isset($returnValue) || !empty($returnValue)) {
    foreach ($returnValue as $bookmarks) {
        foreach ($bookmarks as $key => $element) {
            //adding the bookmarks to the AutoComplete Array
            $ac[$key]['id'] = $element->bookmark_id;
            $ac[$key]['label'] = $element->displayname;
            $ac[$key]['value'] = $element->url;
            $ac[$key]['numberVisits'] = $element->visits;
            $ac[$key]['shared']= $element->shared;
        }
    }

}
//sorting the array by number of visits
usort($ac, function ($i, $j) {
    return $j['numberVisits'] - $i['numberVisits'];
});
$listItems = '';
if (isset($ac) && !empty($ac)) {
    foreach ($ac as $key => $bookmarks) {
        if ($bookmarks["numberVisits"] >= 10 && $bookmarks['shared'] != "false") {
            $popBookmarks[] = $bookmarks;
        }
        $listItems .= '<li><a class="bookmarkList" href="' . $bookmarks["value"] . '" id="m_' . $bookmarks["id"] . '" target="_blank">' . $bookmarks["label"] . '</a><span class="bookmarkID">ID:' . $bookmarks["id"] . '</span><span class="numbVisits">' . $bookmarks["numberVisits"] . '</span></li>';
        $listItems .= '<li>________________________________________________________________________________________________</li>';
    }
} else {
<<<<<<< HEAD
     $listItems .= '<li><span class="bookmarkList">You Don\'t have any bookmarks!</span></li>';
=======
    $listItems = '<li><span class="bookmarkList">You Don\'t have any bookmarks!</span></li>';
>>>>>>> 68298eb912d79b6cbf93c51a515e63493a55ad26
}
#endregion
#region Tab Functionality"
print '         <div class ="tab">';
print '             <span class="pickView">Pick Your View</span><br>';
print '             <button class="tablinks active" id="listBookmark" data-tab="#bookmarks" >Bookmarks </button>';
print '             <button class="tablinks" id="popBookmakrs" data-tab="#popularBookmarks">Popular Bookmarks</button>';
print '         </div>';
print '         <div id="bookmarks" class="tabcontent">';
print '             <span class="bookmarks">All Bookmarks</span><br><br>';
print '             <input type="text" id="search-input" name="search" class="inputSearch" placeholder="Search bookmarks...">';
print '             <span class="displayName">Display Name    |</span>';
print '             <span class="bookmarkIDS">Bookmark ID   |</span>';
print '             <span class="visits">Visits  |</span>';
print '             <ol id="ol">';
print $listItems;
print '             </ol>';
print '         </div>';
$popItems = '';
if (!isset($popBookmarks) || empty($popBookmarks)) {
<<<<<<< HEAD
    $popItems = '<li><span class="bookmarkList">No Popular Bookmarks Yet!</span><li>';
=======
    $popItems = '<li><span class="bookmarkList">No Popular Bookmarks Yet!</span></li>';
    ;
>>>>>>> 68298eb912d79b6cbf93c51a515e63493a55ad26
}
if (isset($popBookmarks) || !empty($popBookmarks)) {
    usort($popBookmarks, function ($i, $j) {
        return $j['numberVisits'] - $i['numberVisits'];
    });
    foreach ($popBookmarks as $bookmarks) {
        $popItems .= '<li><a class="bookmarkList" href="' . $bookmarks["value"] . '" id="p_' . $bookmarks["id"] . '" target="_blank">' . $bookmarks["label"] . '</a><span class="bookmarkID">ID:' . $bookmarks["id"] . '</span><span class="numbVisits">' . $bookmarks["numberVisits"] . '</span></li>';
        $popItems .= '<li>________________________________________________________________________________________________</li>';

    }
}
print '         <div id="popularBookmarks" class="tabcontent">';
print '             <span class="bookmarks">Popular Bookmarks</span><br><br>';
print '             <input type="text" id="search-pop" name="search" class="inputSearch" placeholder="Search bookmarks...">';
print '             <span class="displayName">Display Name    |</span>';
print '             <span class="bookmarkIDS">Bookmark ID   |</span>';
print '             <span class="visits">Visits  |</span>';
print '             <ol id="ol-pop">';
print $popItems;
print '             </ol>';
print '         </div>';
#endregion
print '</div>';
#region AutoComplete JS"
print "<script>
  $(function() {
    var originalList = $('#ol').html();
    $(\"#search-input\").on('keyup', function() {
        var inputVal = $(this).val();
        if(inputVal === '') {
            $('#ol').html(originalList);
            return;
        }
         $(this).autocomplete({
            source: " . json_encode($ac) . ",
            minLength: 1,
            response: function(event, ui) {
            var listItems = '';
            if (ui.content.length === 0) {

            } else {
                $.each(ui.content, function(index, item) {
                    listItems += '<li><a class=\"bookmarkList\" href=\"' + item.value + '\" id=\"' + item.id + '\" target=\"_blank\">' + item.label + '</a><span class=\"bookmarkID\">ID:' + item.id + '</span><span class=\"numbVisits\">' + item.numberVisits + '</span></li>';
                    listItems += '<li>________________________________________________________________________________________________</li>';
                });
                $('#ol').html(listItems);
            } 
        }
      });
    });
  });

  $(function() {
    var originalList = $('#ol-pop').html();
    $(\"#search-pop\").on('keyup', function() {
        var inputVal = $(this).val();
        if(inputVal === '') {
            $('#ol-pop').html(originalList);
            return;
        }
         $(this).autocomplete({
            source: " . json_encode($popBookmarks) . ",
            minLength: 1,
            response: function(event, ui) {
            var listItems = '';
            if (ui.content.length === 0) {

            } else {
                $.each(ui.content, function(index, item) {
                    listItems += '<li><a class=\"bookmarkList\" href=\"' + item.value + '\" id=\"' + item.id + '\" target=\"_blank\">' + item.label + '</a><span class=\"bookmarkID\">ID:' + item.id + '</span><span class=\"numbVisits\">' + item.numberVisits + '</span></li>';
                    listItems += '<li>________________________________________________________________________________________________</li>';
                });
                $('#ol-pop').html(listItems);
            } 
        }
      });
    });
  });
</script>";
#endregion
$bookmark->addBottomElement("<div class='footerBack'></div>");
$bookmark->addBottomElement("<footer class='footerTxt'>&copy; Copyright Isaac Moberg UWSP 2023</footer>");
print $bookmark->getBottomSection();


?>
