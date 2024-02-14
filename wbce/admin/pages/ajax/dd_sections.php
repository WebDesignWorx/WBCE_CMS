<?php
/**
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */
require('../../../config.php');
if(!defined('WB_PATH'))  exit("Cannot access this file directly"); 

// First we prevent direct access and check for variables
if(!isset($_POST['action'])) {
	header( 'Location: ../../../index.php' ); // redirect to index
} 

//initialize JSON response array
$json_respond = array();
$json_respond['success'] = false;
$json_respond['message'] = '';
$json_respond['icon'] = '';

if(!isset($_POST['pageID'])){	
	$json_respond['message'] = "Die Seiteninformationen sind fehlerhaft";
}

// CHECK PERMISSIONS - check if user has permissions to drag & drop pages
require_once WB_PATH.'/framework/class.admin.php';
$admin = new Admin('Pages', 'pages_modify', false, false);
if (!$admin->is_authenticated()){
	$json_respond['message'] = "unsufficient privileges!";
	$json_respond['success'] = false;
	$json_respond['icon'] = 'error.gif';
	exit(json_encode($json_respond));	
}

$action = $admin->add_slashes($_POST['action']);	// This line ensures that in &action is nothing but the string "updateArray"
if ($action == "updateArray") {
	$aTestArray = array();
	// EXECUTE DB QUERY
	// check if the array is not empty
	$aUpdateSections = isset($_POST['sectionID']) ? $_POST['sectionID'] : array();
	
	/* */
	if(!empty($aUpdateSections)) {
		$i = 1;
		foreach ($aUpdateSections as $id) {
			//$id = $admin->checkIDKEY($id); it doesn't work with IDKEYs for some reason
			$sUpdate = "UPDATE `{TP}sections` SET position = ".$i." WHERE `section_id` = '".$id."'";	
			
			if($database->query($sUpdate)){
				$aTestArray[$i]	= $id;
			}			
			$i++;
		}
			
		// catch database errors if any
		if($database->is_error() == true) {
			$json_respond['success'] = false;
			$json_respond['message'] = 'db query failed';
			$json_respond['icon'] = 'error.gif';
			exit(json_encode($json_respond));
		}	
	}
	/**/
	// put the whole array into the $hint VAR 
	// FOR DEBUG ONLY
	$hint = '';
	ob_start();		
	echo '<pre>'; print_r ($aUpdateSections); echo '</pre>';
	echo '<pre>'; print_r ($aTestArray); echo '</pre>';
	$hint = ob_get_clean();
	
	$json_respond['success'] = true;
	$json_respond['message'] = ''.$MESSAGE['RECORD_MODIFIED_SAVED'];
	$json_respond['message'] .= $hint; // (debug; see above)	
	$json_respond['icon'] = 'loader.gif';
	exit(json_encode($json_respond));
}