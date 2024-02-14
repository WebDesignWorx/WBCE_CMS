<?php
/**
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

      
require('../../../config.php');
if(!defined('WB_PATH'))  exit();

// First we prevent direct access and check for variables
if(!isset($_POST['action'])) {
	header( 'Location: ../../../index.php' ); // redirect to index
} 

//initialize JSON response array
$aRespond = array();
$aRespond['success'] = false;
$aRespond['message'] = '';
$aRespond['icon']    = '';

if(!isset($_POST['pageID'])){	
	$aRespond['message'] = "insufficient information";
}

// CHECK PERMISSIONS - check if user has permissions to drag & drop pages
require_once WB_PATH.'/framework/class.admin.php';
$admin = new Admin('Pages', 'pages', false, false);
if (!$admin->is_authenticated() || (!$admin->get_permission('admintools') || !$admin->get_permission('pages'))){
	$aRespond['message'] = "unsufficient privileges!";
	$aRespond['success'] = false;
	$aRespond['icon'] = 'error.gif';
	exit(json_encode($aRespond));	
}

$sAction = $admin->add_slashes($_POST['action']); // ensure that in &action is nothing but the string "updateArray"
if ($sAction == "updateArray") {
	$aTestArray = array();
	// EXECUTE DB QUERY
	// check if the array is not empty
	$aUpdatePages = isset($_POST['pageID']) ? $_POST['pageID'] : array();
	if(!empty($aUpdatePages)) {
		$i = 1;
		foreach ($aUpdatePages as $iPageID) {
			//$id = $admin->checkIDKEY($id); it doesn't work with IDKEYs for some reason
			$sUpdate = "UPDATE `{TP}pages` SET position = ".$i." WHERE `page_id` = '".$iPageID."'";	
			
			if($database->query($sUpdate)){
				$aTestArray[$i]	= $iPageID;
			}			
			$i++;
		}
			
		// catch database errors if any
		if($database->is_error() == true) {
			$aRespond['success'] = false;
			$aRespond['message'] = 'db query failed';
			$aRespond['icon'] = 'error.gif';
			exit(json_encode($aRespond));
		}	
	}
	
	// put the whole array into the $hint VAR 
	// FOR DEBUG ONLY
	$sHint = '';
	// ob_start();	
	// echo '<pre>'; print_r ($aUpdatePages); echo '</pre>';
	// echo '<pre>'; print_r ($aTestArray); echo '</pre>';
	// $hint = ob_get_clean();
	
	$aRespond['success'] = true;
	$aRespond['message'] = ''.$MESSAGE['RECORD_MODIFIED_SAVED'];
	$aRespond['message'] .= $sHint; // (debug; see above)	
	$aRespond['icon'] = 'loader.gif';
	exit(json_encode($aRespond));
}