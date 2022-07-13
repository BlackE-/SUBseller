<?php
    require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
    if($set->Logout()){
        $set->RedirectToURL("login");
    }
?>