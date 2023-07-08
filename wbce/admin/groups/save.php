<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * Way Better Content Editing.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

require '../../config.php';

$admin = new Admin('Access', 'groups_modify', false); 
$oMsgBox = new MessageBox();

$sRedirect = ADMIN_URL.'/groups';

if (!$admin->checkFTAN()) {
    $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS'], $sRedirect);
    exit();
}

if($admin->get_post('group_id') == '0'){
    $admin = new Admin('Access', 'groups_add', false); 
    $sAction = 'add_new_group';
}else{
    // Check if group group_id is a valid number and doesnt equal 1
    $iGroupID = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD']));
    $sAction = 'save_group';
    
    if( ($iGroupID < 2 ) ) {
        $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS'], $sRedirect);
        exit();
    }
}

$sGroupName = $database->escapeString(trim(strip_tags($admin->get_post('group_name'))));
if($sGroupName == "") {
    $oMsgBox->error($MESSAGE['GROUPS_GROUP_NAME_BLANK'], $sRedirect, true);
}
$sDescription = $database->escapeString(strip_tags($admin->get_post('description')));

// check if name already in use
$sSql = "SELECT COUNT(*) FROM `{TP}groups` WHERE `name`='".$sGroupName."'";
if($sAction != 'add_new_group'){
    $sSql .= " AND `group_id` <> '".$iGroupID."'";
}
if ($database->get_one($sSql)) {
    $oMsgBox->error($MESSAGE['GROUPS_GROUP_NAME_EXISTS'], $sRedirect);
}

// Get system permissions
require_once(ADMIN_PATH.'/groups/posted_permissions.php');

// Update the database
$aData = array(
    'name'                 => $sGroupName,
    'description'          => $sDescription,
    'system_permissions'   => $system_permissions,
    'module_permissions'   => $module_permissions,
    'template_permissions' => $template_permissions,
);

if($sAction == 'add_new_group'){
    $database->insertRow('{TP}groups', $aData);
    $iGroupID = $database->getLastInsertId();
}else{    
    $aData['group_id'] = $iGroupID;
    $database->updateRow('{TP}groups', 'group_id', $aData);
}

if($database->is_error()) {   
    $oMsgBox->error($database->get_error(), $sRedirect);
} else {
    $sMessage = ($sAction == 'add_new_group') ? 'ADDED' : 'SAVED';
    $tmpID = $iGroupID;
    if(isset($_POST['save'])){
        $tmpID = $admin->getIDKEY($iGroupID);
    }
    $oMsgBox->success($MESSAGE['GROUPS_'.$sMessage], $sRedirect.'/index.php?group_id='.$tmpID);
}