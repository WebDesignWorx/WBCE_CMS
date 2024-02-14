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
$admin   = new Admin('Pages', 'pages_modify', false);
$oMsgBox = new MessageBox();

require __DIR__ . '/functions/functions.backend_pages.php';
require __DIR__ . '/functions/functions.pageTree.php';


require_once WB_PATH . '/framework/PageSettings.php';
require_once WB_PATH . '/framework/PageSections.php';
if (isPageCodeUsed()) {
    // include page_code functions if needed
    include 'backend_pages/functions/functions.page_code.php';
}

$iPageID = $page_id = (isset($_GET['page_id']) ? $_GET['page_id'] : NULL);
if ($iPageID != NULL && is_numeric($iPageID) == false) {
    if (!($iPageID = (int) $admin->checkIDKEY('page_id', 0, $_SERVER['REQUEST_METHOD']) )) {
        $oMsgBox->error('{MESSAGE:GENERIC_SECURITY_ACCESS}');
    }
}

$oPage = new PageSettings($iPageID);
if ($oPage->hasPrivileges() == false) {
    $oMsgBox->error('{MESSAGE:PAGES_INSUFFICIENT_PERMISSIONS}');
}

$oSections = new PageSections();
switch (true) {
    // save form
    case ((isset($_POST['save_settings']) || isset($_POST['save_and_back'])) && isset($_POST['page_id'])):
        if ($admin->checkFTAN() == false) {
            $oMsgBox->error('{MESSAGE:GENERIC_SECURITY_ACCESS}');
        } else {
            $iPageID = (int) $_POST['page_id'];
            include ADMIN_PATH.'/pages/functions/functions.save_page_settings.php';    
            #debug_dump($_POST);
            if (savePageSettings($_POST) == true) {
                if (isset($_POST['save_and_back'])) {
                    // save_and_bak (back to pageTree)
                    $oMsgBox->success('{MESSAGE:PAGES_SAVED_SETTINGS}', ADMIN_URL . '/pages');
                } else {
                    // save
                    $oMsgBox->success('{MESSAGE:PAGES_SAVED_SETTINGS}');
                    redirect(ADMIN_URL.'/pages/settings.php?page_id='.$iPageID);
                }
            }
        }
        break;

    // view form
    default:
        // start collecting data to export into the AreaFrame
        $aData = array();
        $aData['page_id'] = (int) $iPageID;
        $aData['sections'] = array();
        $aData['area'] = 'settings';
        $aData['data'] = pagesAreaFrame($iPageID);
        $aData['page'] = (array) $oPage->settings;
        $aData['WB_SHORTURL_ONELEVEL'] = (defined('WB_SHORTURL_ONELEVEL') && WB_SHORTURL_ONELEVEL == true);
        $aData['WB_SHORTURL_EXT'] = (defined('WB_SHORTURL_EXT') && WB_SHORTURL_EXT == true);
        $aData['parent_list']     = pageTreeCombobox(nestedPagesArray(), $iPageID);
        $aData['operators_list']  = listOperators('admins', $oPage->settings->admin_groups);
        $aData['viewers_list']    = listOperators('viewers', $oPage->settings->viewing_groups);
        $aData['is_menu_link']    = true;
        if (isPageMenuLink($iPageID) == false) {
            $aData['is_menu_link'] = false;
        }
        $aData['MESSAGE_BOX'] = $oMsgBox->fetchDisplay();
        $aData['TABS'] = renderPagesTabs('settings');
        
        $admin->print_header();
        $admin->getThemeFile('pages_settings.twig', $aData);
        $admin->print_footer();
        break;
}

