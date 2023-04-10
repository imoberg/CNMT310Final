<?php
require_once(__DIR__ . "/classes/Page/Page.class.php" );
$index = new Page("index");

$index->addHeadElement("<link href='./css/styles.css' rel='stylesheet'/>");
$index->addHeadElement("<title>Bookmarks Page</title>");
print $index->getTopSection();
print '        <div class="divBox">';
print '            <div class="logo">';
print '            </div>';
print '            <a href="index.php" class="bookmarks">Bookmarks |</a>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="form-login.php" class="navLogin">Login  |</a>';
print '            <div class="navLine"></div>';
print '            <h2 class="welcomeTxt">Welcome!</h2>';
print '            <p class="access">To access your bookmarks click on Login.</p>';
$index->addBottomElement("<div class='footLine'></div>");
$index->addBottomElement("<footer class='footerTxt'>&copy Copyright Isaac Moberg UWSP 2023</footer>");
print $index->getBottomSection();
?>