<?php
require_once("autoload.php");
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    $_SESSION['results'][] = 'Please input a username and password';
    die(header("Location: " . LOGIN));

}
if(isset($_SESSION['loggedIn'])) {
	$_SESSION['loggedIn'] = false;
	unset($_SESSION['loggedIn']);
}
session_destroy();

foreach($_SESSION as $key => $elm) {
	unset($_SESSION[$key]);

}
session_write_close();
die(header("Location: " . HOME));

?>