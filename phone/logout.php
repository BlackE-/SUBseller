<?php
    require_once "../include/_setup.php";
	$set = new Setup();
    if($set->Logout()){
        $set->RedirectToURL("index");
    }
?>