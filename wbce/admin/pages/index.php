<?php

/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

// Include config file
require realpath('../../config.php');

define('PT_USE_DRAGDROP_SWITCH', true);
// Create new Admin object
$admin = new Admin('Pages', 'pages', false);
$iPageID = isset($_GET['page_id']) ? $_GET['page_id'] : NULL;
if ($iPageID != NULL && is_numeric($iPageID) == false) {
    if (!($iPageID = (int) $admin->checkIDKEY('page_id', 0, $_SERVER['REQUEST_METHOD']) )) {
        $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']);
    }
}

require __DIR__ . '/functions/functions.backend_pages.php';
require __DIR__ . '/functions/functions.pageTree.php';

$oMsgBox = new MessageBox();
 
defined('PREDEFINED_MODULE') or define('PREDEFINED_MODULE', 'wysiwyg');

// switch trough get links
switch (true) {
    case (isset($_GET['func']) && in_array($_GET['func'], array('move_up', 'move_down'))):
        movePage($_GET['func'], $iPageID);
        break;
    case (isset($_GET['func']) && $_GET['func'] == 'delete'):
        deletePage($iPageID);
        break;
    case (isset($_GET['func']) && $_GET['func'] == 'restore'):
        restoreDeletedPage($iPageID);
        break;
    case (isset($_GET['dd']) && is_numeric($_GET['dd'])):
        activateDragDrop($_GET['dd']);
        break;	
    case (isset($_GET['toggle_trash']) && is_numeric($_GET['toggle_trash'])):
        if(isset($_GET['toggle_trash'])){
            toggleTrashBin($_GET['toggle_trash']);
            redirect(ADMIN_URL.'/pages/index.php');
        }
	break;
    case (isset($_POST['add_new_page'])):
        $sError = '';
        if (!$admin->checkFTAN()){
            $admin->print_header();
            $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']);
            $admin->print_footer();
        }
        $sMenuTitle = $admin->get_post_escaped('menu_title');
        if($sMenuTitle == '' || substr($sMenuTitle, 0, 1) == '.')	{		
            $sError = $MESSAGE['PAGES_BLANK_PAGE_TITLE'];
        } else {
            $sMenuTitle = htmlspecialchars($admin->get_post_escaped('menu_title'));
        }
        $iParent = intval($admin->get_post('parent')); 
        if ($iParent != 0) {
            // Write access to parent, if not you may not create subpages 
            if (!$admin->get_page_permission($iParent, 'admin')){
                $sError = $MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'];	
            }
        } elseif (!$admin->get_permission('pages_add_l0','system')){
            // generic test for permissions for page creation	
            $sError = $MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'];
        }  
        $sVisibility = $admin->get_post('visibility');
        if (!in_array($sVisibility, array('private', 'registered', 'hidden', 'none'))) {
            $sVisibility = 'public';
        }
        // check module permissions:
        // whithout module permissions you may not create a page whith this module
        $sModuleType = preg_replace('/[^a-z0-9_-]/i', "", $admin->get_post('type'));
        if (!$admin->get_permission($sModuleType, 'module'))	{
            $sError = $MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'];
        }
        $bGoToPage = isset($_POST['go_to_new_page']) && $_POST['go_to_new_page'] == 1;
        if ($sError == '') {
            $iPageID = createPage(
                $sMenuTitle, 
                $sModuleType, 
                $iParent, 
                $sVisibility,
                $admin->get_post('admin_groups'),
                $admin->get_post('viewing_groups'),
                $bGoToPage
            );
        } else {
            $oMsgBox->error($sError);
        }
        break; 
}

$sSwitchDragDropURL = '';
if(defined('PT_USE_DRAGDROP_SWITCH') && PT_USE_DRAGDROP_SWITCH == true){
    $set_dd = (Settings::Get('pages_drag_drop') == 0) ? 1 : 0;
    $PAGES_TEXT['DRAG_DROP_STATUS'] = "Drag&amp;Drop ".strtolower($set_dd == 1 ? $TEXT['DISABLED'] : $TEXT['ACTIVE']);	
    $sSwitchDragDropURL = ADMIN_URL.'/pages/index.php?dd='.$set_dd;	
}

$_SESSION['pages_go_to_created'] = isset($_SESSION['pages_go_to_created']) ? $_SESSION['pages_go_to_created'] : 1;

$bShowTrash = false;
$sToggleTrashURL = '';
$iDeletedPages = 0;
if(PAGE_TRASH == 'inline' || PAGE_TRASH == 'separate'){
    $bShowTrash = true;
    $iDeletedPages = $database->query("SELECT `page_id` FROM `{TP}pages` WHERE `visibility` = 'deleted'")->numRows();
    $iStatus = 1;
    if($iDeletedPages > 0){			
        $iStatus = (PAGE_TRASH == 'inline') ? 0 : 1;
    }
    $sToggleTrashURL = ADMIN_URL.'/pages/index.php?toggle_trash='.$iStatus;
    $PAGES_TEXT['ENABLE_DISABLE_TRASH'] = ($iStatus == 1) ? $TEXT['SHOW'] : $TEXT['HIDE'];
    if($iDeletedPages == 0) $PAGES_TEXT['ENABLE_DISABLE_TRASH'];	
}

$aToTwig = array(
    'USE_DRAG_DROP'        => Settings::Get('pages_drag_drop'),
    'DRAG_DROP_SWITCH_URL' => $sSwitchDragDropURL,
    'INTRO_PAGE_ACTIVE'    => ($admin->get_permission('pages_intro') == true && INTRO_PAGE == 'enabled'),
    'PAGES_TOTAL'          => $database->query("SELECT `page_id` FROM `{TP}pages`")->numRows(),
    'DELETED_PAGES_TOTAL'  => $iDeletedPages,
    'SHOW_TRASH'           => $bShowTrash,
    'TRASH_TOGGLE_URL'     => $sToggleTrashURL,
    'GO_TO_CREATED_PAGE'   => $_SESSION['pages_go_to_created'],
    'operators_list'       => listOperators('admins'),
    'viewers_list'         => listOperators('viewers'),
    'module_list'          => moduleSelector(PREDEFINED_MODULE),
    'parent_list'          => pageTreeCombobox(nestedPagesArray(), 0),
    'pageTree'             => nestedPagesArray(),
    'languages'            => languagesArray(),
    'MESSAGE_BOX'          => $oMsgBox->fetchDisplay(),
);
$admin->print_header();
$admin->getThemeFile('pages_index.twig', $aToTwig);
$admin->print_footer();