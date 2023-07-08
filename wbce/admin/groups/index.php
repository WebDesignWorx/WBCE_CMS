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

// Print admin header
require('../../config.php');

require __DIR__.'/functions.php';
require ADMIN_PATH.'/access/functions.php';

$oMsgBox = new MessageBox();

$sPos = "groups";

$action = 'cancel';
$action = (isset($_POST['action']) && ($_POST['action'] = 'modify') ? 'modify' : $action);
$action = (isset($_GET['group_id'])  ? 'modify'    : $action);
$action = (isset($_GET['delete'])    ? 'delete'    : $action);
$action = (isset($_GET['duplicate']) ? 'duplicate' : $action);


switch ($action){
    case 'modify':
        
            $admin = new Admin('Access', 'groups_modify');
            // Check if group group_id is a valid number and doesnt equal 1
            
            if($iGroupID = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD']))){
                if ($iGroupID == 0) {
                    break;
                    #$oMsgBox->error($MESSAGE['USERS_NO_GROUP']);
                }
                if (($iGroupID < 2)) {
                    // if($admin_header) { $admin->print_header(); }
                    $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS']);
                }
            }
            break;
      
    case 'delete':      
        
        $admin = new Admin('Access', 'groups_delete', false);
        $iGroupID = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD']));
        if ($iGroupID == 0) {
            $oMsgBox->error($MESSAGE['USERS_NO_GROUP'], ADMIN_URL.'/groups');
        }
        
        // Check if group_id is a valid number and is higher than 1 ('cause admin group shall not be deleted)
        if (($iGroupID < 2)) {
            $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS'], ADMIN_URL.'/groups');
        }

        // check if there are any users in selected group 
        $iCount = 0;
        $sSql = "SELECT COUNT(*) FROM `{TP}users` WHERE group_id = '".$iGroupID."'
                                                    OR FIND_IN_SET('".$iGroupID."', `groups_id`)";
        $iCount = $iCount + $database->get_one($sSql);
        if ($iCount > 0) {
            $oMsgBox->error($MESSAGE['GROUP_HAS_MEMBERS'], ADMIN_URL.'/groups');
        }
                      
        // Delete the group record from DB table
        $database->query("DELETE FROM `{TP}groups` WHERE `group_id` = '" . $iGroupID . "' LIMIT 1");
        if ($database->is_error()) {
            $oMsgBox->error($database->get_error(), ADMIN_URL.'/groups');
        } else {
            $oMsgBox->success($MESSAGE['GROUPS_DELETED'], ADMIN_URL.'/groups');
        }  
        break;
        
    case 'duplicate':       
        
        $admin = new Admin('Access', 'groups_add');
        $iGroupID = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD']));
        $aGroup = $database->get_array(
            "SELECT * FROM `{TP}groups` WHERE `group_id` = ".$iGroupID
        )[0];
        unset($aGroup['group_id']);
        $aGroup['name'] .= "_duplicate";
        $database->insertRow('{TP}groups', $aGroup);
        $newID = $database->getLastInsertId();
        $newIDKEY = $admin->getIDKEY($newID);
        $oMsgBox->success(
                $TEXT['SUCCESS'], 
                ADMIN_URL.'/groups/index.php?group_id='.$newIDKEY.'&modify=1'
        );
        exit();
        break;
        
    default: 
        $admin = new Admin('Access', 'groups');
}

$iGroupID   = isset($iGroupID) ? $iGroupID : 0;
$aToTwig = array(
    'MESSAGE_BOX'  => $oMsgBox->fetchDisplay(),
    'POSITION'     => $sPos,
    'TABS'         => renderAddonsTabs($sPos),
    'GROUP_ID'     => $iGroupID,
    'GROUP_NAME'   => get_groupname_by_id($iGroupID),
    'GROUP_DESC'   => get_groupdescription_by_id($iGroupID),
    'groups'       => get_groups_w_userscount(),
    'access_perms' => group_access_permissions($iGroupID),     
    'addon_list'   => array(
        'page'        => get_addon_list('page',     $iGroupID),
        'tool'        => get_addon_list('tool',     $iGroupID),
        'setting'     => get_addon_list('setting',  $iGroupID),
        'template'    => get_addon_list('template', $iGroupID),
        'theme'       => get_addon_list('theme',    $iGroupID),
    )
);
$admin->getThemeFile('access_groups.twig', $aToTwig);
$admin->print_footer();