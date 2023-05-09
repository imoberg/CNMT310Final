<?php
require_once("autoload.php");
require_once(__DIR__ . "/classes/Page/Page.class.php");
$login  = new Page("Login Page");
$login->addHeadElement('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
$login->addHeadElement("<link href='./css/login-styles.css' rel='stylesheet'>");
print $login->getTopSection();
print '        <div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    print '            <a href="bookmarks.php" class="bookmarks">Bookmarks |</a>';
    print '            <a href="index.php" class="navHome" >Home  |</a>';
    print '            <a href="logout.php" class="navLogin">Logout  |</a>';
    print '            <span class="welcomeTxt">Welcome Back, You Are Already Logged In</span>';
}else{ 
print '            <a href="index.php" class="bookmarks">Bookmarks |</a>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="form-login.php" class="navLogin">Login  |</a>';
print '            <span class="welcomeTxt">Welcome Back, Please Login To Your Account.</span>';
print '            <form action="action-login.php" method="POST">';// this is what we are actually using
//print '            <form action="bookmarks.php" method="POST">'; //this is testing
if(isset($_SESSION['results']) && is_array($_SESSION['results']) && count($_SESSION['results']) > 0){
    foreach($_SESSION['results'] as $field => $message) {
        print '<span class="errors">' . $message . '</span>';
        print '<br>';
    }
    $_SESSION['results'] = array();
}
print '                <span class="username">Username</span>';
print '                <input type="text" id="username" name="username" class="inputUsername">';
print '                <span class="password">Password</span>';
print '                <input type="password" id="password" name="password" class="inputPassword">';
print '                <input type="submit" value="Login" class="submit">';
print '            </form>';
}

print '            <div class="workBack"></div>';
print '            <span class="workHead">How It Works?</span>';
print '            <ul class="workTxt">';
print '                <li>Houses All Your Bookmarks</li>';
print '                <li>Sorts Them By Popularity</li>';
print '                <li>Can Add Bookmarks</li>';
print '                <li>Can Delete Bookmarks</li>';
print '                <li>Can Share Bookmarks</li>';
print '            </ul>';
print '</div>';
$login->addBottomElement("<div class='footerBack'></div>");
$login->addBottomElement("<footer class='footerTxt'>&copy; Copyright Isaac Moberg UWSP 2023</footer>;");
print $login->getBottomSection();


?>