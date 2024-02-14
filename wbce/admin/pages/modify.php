<?php

/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

// Include config file
if (!defined('WB_URL')) {
    $config_file = realpath('../../config.php');
    if (file_exists($config_file)) {
        require $config_file;
    }
}

// Create new Admin object
$admin = new Admin('Pages', 'pages_modify', false);
$admin->print_header();

require_once WB_PATH . '/framework/PageSections.php';
require __DIR__ . '/functions/functions.backend_pages.php';
require __DIR__ . '/functions/functions.pageTree.php';

$oMsgBox = new MessageBox();

$iPageID = $page_id = intval((isset($_GET['page_id'])) ? $_GET['page_id'] : NULL);
$iSectionID = isset($_GET['section_id']) ? $_GET['section_id'] : NULL;
// in case $iSectionID is set by now but is not numeric, check the ID Key
if ((isset($iSectionID) && $iSectionID != NULL) && is_numeric($iSectionID) == false) {
    if (!($iSectionID = (int) $admin->checkIDKEY('section_id', 0, $_SERVER['REQUEST_METHOD']) )) {
        $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']);
    }
}
// Work out the Action 	
$sAction = '';
// CHANGE POSITION (move up/down)?
if ($iSectionID != NULL) {
    if (isset($_GET['func']) && in_array($_GET['func'], array(
        'move_down', 'move_up', 'delete_section', 'active1', 'active2', 'active0'
    ))) {
        // ~~~~~~~~~~~~~~~~~~~
        $sFunc = (string) $_GET['func'];
        if ($sFunc == 'move_up' || $sFunc == 'move_down') {
            $sAction = 'move_section';
            $sDirection = $sFunc;
        }
        if ($sFunc == 'delete_section') {
            $sAction = 'delete_section';
        }        
        if($sFunc == 'active1' || $sFunc == 'active2' || $sFunc == 'active0'){ 
            $sAction = 'activate';
            $iSetActive = substr($sFunc, -1);   
        }
    }
}
if (isset($_POST['add_section']) && isset($_POST['module']) && isset($_POST['page_id'])) {
    // ~~~~~~~~~~~~~~~~~~~~~~~~~
    $sModule = (string) $_POST['module'];
    $iPageID = (int) $_POST['page_id'];
    $sAction = 'add_section';
}
if (isset($_POST['change_sections_settings']) && isset($_POST['page_id'])) {
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $iPageID = (int) $_POST['page_id'];
    $sAction = 'change_sections_settings';
}
$admin_header = true;
$oSections = new PageSections();
switch ($sAction) {
    case 'move_section':
        $oSections->moveSection($sDirection, $iSectionID);
        break;
    case 'delete_section':
        $oSections->deletePageSection($iSectionID);
        break;
    case 'add_section':
        $iBlockId = (isset($_POST['layoutblock']) ? intval($_POST['layoutblock']) : 1);
        #	$oSections->addPageSection($sModule, $iPageID, $iBlockId);	

        if ($admin->checkFTAN()) {
            $oSections->addPageSection($sModule, $iPageID, $iBlockId);
        } else {
            // FTAN check failed
            $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']);
        }
        break;
    case 'change_sections_settings':
        if ($admin->checkFTAN()) {
            $oSections->changeSectionsSettings($iPageID);
        } else {
            // FTAN check failed
            $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']);
        }
        break;    
    case 'activate': 
        $database->updateRow('{TP}sections', 'section_id', array(
            'section_id' => $iSectionID,
            'active'     => $iSetActive,
        ));
        $oMsgBox->success($TEXT['SUCCESS']);            
        $params = array(
                'page_id' => $iPageID,
                'hilite' => $iSectionID
            );
        $oMsgBox->redirect(ADMIN_URL.'/pages/modify.php?'.http_build_query($params).'#'.SEC_ANCHOR.$iSectionID);
        break;
    default: // modify sections
        // start collecting data to export into the AreaFrame
        $aData = array();

        // get_page_details
        $aPage = $admin->get_page_details($iPageID);
        // check user permissions
        if (!$admin->ami_group_member($aPage['admin_groups']) && !$admin->is_group_match($admin->get_user_id(), $aPage['admin_users'])) {
            $admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS']);
        }
        $aData['page_id'] = (int) $iPageID;
        $aData['iPageID'] = (int) $iPageID;
        $aData['is_menu_link'] = true;
        $aData['sections'] = array();
        $aData['area'] = 'modify';
        $aData['data'] = pagesAreaFrame($iPageID);
        $aData['sections'] = (array) $oSections->getSectionsList($iPageID);
        if (isPageMenuLink($iPageID) == false) {
            $aData['is_menu_link'] = false;
            $aData['can_delete_sections'] = $oSections->bCanDeleteSections;
            $aData['add_section_select'] = moduleSelector();
            $aData['use_template_blocks'] = SECTION_BLOCKS;
            $aData['layout_blocks'] = $oSections->getLayoutBlocks($iPageID);
        }
        $aData['MESSAGE_BOX'] = $oMsgBox->fetchDisplay();
        $aData['TABS'] = renderPagesTabs('modify');
        $admin->getThemeFile('pages_modify.twig', $aData);
        break;
}
$admin->print_footer();
