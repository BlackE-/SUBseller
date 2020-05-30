<?php
	if(!isset($_SESSION)){ session_start(); }
	if(!isset($_SESSION['cart'])){$cart = NULL;}
    else{$cart = $_SESSION['cart'];}

    print_r($cart);
?>