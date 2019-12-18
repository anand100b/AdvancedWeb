<?php
session_start();

//unset auth variable
unset( $_SESSION['auth'] );


//redirect user to home page
header('location: index.php');

?>