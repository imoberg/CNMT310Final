<?php
require_once(__DIR__ . "/classes/Page/Page.class.php");
$bookmark = new Page("Bookmarks");

$bookmark->addHeadElement("<link href='./css/bookmark-styles.css' rel='stylesheet' />");
$bookmark->addHeadElement("<title>Document</title>");
print $bookmark->getTopSection();
print '        <div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="logout.php" class="navLogout">Logout |</a>';
print '            <span class="hiUsr">Hi *USER* Here Are Your Bookmarks.</span>';
print '            <a href="index.php" class="navBookmarks">Bookmarks |</a>';
print '           <button class="btnAdd">Add +</button>';
print '           <button class="btnDelete">Delete -</button>';
print '           </span><span class="search">Search</span>';
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