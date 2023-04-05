<?php
print '<!DOCTYPE html>';
print '<html>';
print '    <head>';
print '        <link href="./css/login-styles.css" rel="stylesheet">';
print '        <title>Login Page</title>';
print '    </head>';
print '    <body>';
print '        <div class="box">';
print '            <div class="navBar"></div>';
print '            <div class="logo"></div>';
print '            <a href="index.php" class="bookmarks">Bookmarks |</a>';
print '            <a href="index.php" class="navHome" >Home  |</a>';
print '            <a href="form-login.php" class="navLogin">Login  |</a>';
print '            <span class="welcomeTxt">Welcome Back, Please Login To Your Account.</span>';
print '            <form action="action-login.php" method="POST">';
print '                <span class="username">Username</span>';
print '                <input type="text" id="username" name="username" class="inputUsername">';
print '                <span class="password">Password</span>';
print '                <input type="text" id="password" name="password" class="inputPassword">';
print '                <input type="submit" value="Login" class="submit">';
print '            </form>';
print '            <div class="workBack"></div>';
print '            <span class="workHead">How It Works?</span>';
print '            <ul class="workTxt">';
print '                <li>Houses All Your Bookmarks</li><br>';
print '                <li>Sorts Them By Popularity</li><br>';
print '                <li>Can Add Bookmarks</li><br>';
print '                <li>Can Delete Bookmarks</li><br>';
print '                <li>Can Share Bookmarks</li><br>';
print '            </ul>';
print '            <div class="footerBack"></div>';
print '            <footer class="footerTxt">&copy Copyright Isaac Moberg UWSP 2023</footer>;';
print '        </div>';
print '    </body>';
print '</html>';

?>