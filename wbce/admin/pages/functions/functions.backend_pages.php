<?php
/*
 * @category        Pages Backend-Tool
 * @package         backend_pages 
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */


/**
 * Function to get the path of a TPL File easily
 * =============================================
 * 
 * @param  string $sTPL
 * @return string
 */
 function getTemplateByName($sTPL = '') {
    $sRetVal = 'Template File not found!';
    if ($sTPL != '') {
        $sFileName = $sTPL . '.tpl.php';
        $sFileTheme = ADMIN_PATH . '/pages/backend_pages/templates/' . $sFileName;
        # $sFileModule = TOOL_PATH.'/templates/'.$sFileName;
        if (is_file($sFileTheme))
            return $sFileTheme;
        #if(is_file($sFileModule))	return $sFileModule; 
    }

    return $sRetVal;
}

/**
 * generate func links for the pageTree 
 * ====================================
 * 
 * @param  string $sFunc
 * @param  int    $iPageID
 * @return type
 */
function pagetreeFuncLink($sFunc = '', $iPageID = NULL) {
    if ($sFunc != '' && $iPageID != NULL) {
        return ADMIN_URL . '/pages/index.php?func=' . $sFunc . '&amp;page_id=' . $iPageID;
    }
}

/**
 * generate area links (modify|sections|settings)
 * ==============================================
 * 
 * @param  string $sArea
 * @param  int    $iPageID
 * @return string
 */
function pagetreeAreaLink($sArea = '', $iPageID = NULL) {
    $RetVal = '';
    if ($sArea != '' && $iPageID != NULL) {
        $RetVal = ADMIN_URL . '/pages/' . $sArea . '.php?page_id=' . $iPageID;
    }
    return $RetVal;
}

/**
 * generate edit links within the ManageSections area 
 * These are the links from the PageTree
 * that point to locations like 
 * modify.php, sections.php and settings.php
 * ========================================= 
 * 
 * @param  string $sFunc
 * @param  int    $iSectionID
 * @return string
 */
function sectionsFuncLink($sFunc = '', $iSectionID = NULL) {
    if ($sFunc != '' && $iSectionID != NULL) {
        #return MANAGE_SECTIONS_URL.'0&area=sections&amp;func='.$sFunc.'&amp;section_id='.$iSectionID;
        return ADMIN_URL . '/pages/sections.php?func=' . $sFunc . '&amp;section_id=' . $iSectionID;
    }
}

/**
 * simple page_trash toggle 
 * =============================
 * 
 * @param  int $iSatus
 * @return void
 */
function toggleTrashBin($iSatus = 0) {
    $oMsgBox = new MessageBox();
    $sCondition = ($iSatus == 0) ? 'separate' : 'inline';
    Settings::Set("wb_page_trash", $sCondition);
    Settings::Set("page_trash", $sCondition);

    $sStatus = ($iSatus == 0 ? 'DIS' : 'EN') . 'ABLED';
    $oMsgBox->success('{PAGES_TEXT:TRASH_' . $sStatus . '}');
    return;
}

/**
 * redirect
 * will execute header('Location... if headers not already sent
 * if heders already sent will fall back to a JS solution
 * should JS be disabled will fall back to meta http refresh
 * 
 * 
 * @param string $sUrl
 */
function redirect($sUrl) {
    if (headers_sent() == false) {
        header('Location: ' . $sUrl);
    } else {
        echo '<script type="text/javascript">window.location.href="' . $sUrl . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . $sUrl . '" /></noscript>';
    }
    exit;
}

/**
 * return the whole, templated PageTree  
 * 
 * @global array $TEXT
 * @global array $HEADING
 * @global array $MESSAGE
 * @param  array $aPages
 * @param  int   $iLevel
 */
function drawPageTree($aPages, $iLevel = 0) {
    global $admin;
    foreach ($aPages as $p) {
        #$p = (object) $p; 
        $admin->getThemeFile('pages_pageTree.twig', $p);
    }    
}

/**
 * This function generates an array of section-type modules for use with
 * the combobox-selector. We use it below the pageTree and in the sections
 * area to generate new sections of a specific module-type
 * NOTE: here we introduce WB_DEFAULT_SECTION_TYPE as a new feature
 * 
 * @global object $database
 * @param  string $sPreselectedModule
 * @return array
 */
function moduleSelector($sPreselectedModule = 'wysiwyg') {
    global $database;

    // constant WB_DEFAULT_SECTION_TYPE can be set in 
    // config.php in order to overwrite this setting
    defined('WB_DEFAULT_SECTION_TYPE') or define('WB_DEFAULT_SECTION_TYPE', $sPreselectedModule);
    $aModules = array();
    $oQuery = $database->query(
            "SELECT `directory`, `name`, `addon_id` as `id` FROM `{TP}addons` 
		WHERE `type` = 'module' AND `function` LIKE '%page%' ORDER BY `name`"
    );
    while ($row = $oQuery->fetchRow()) {
        // Check if user is allowed to use this module
        if (!is_numeric(array_search($row['directory'], $_SESSION['MODULE_PERMISSIONS']))) {
            $aModules[$row['id']]['directory'] = $row['directory'];
            $aModules[$row['id']]['name'] = $row['name'];
            $sSelected = isset($_POST['type']) ? $_POST['type'] : WB_DEFAULT_SECTION_TYPE;
            $aModules[$row['id']]['selectControl'] = ($row['directory'] == $sSelected) ? ' selected="selected"' : '';
        }
    }
    return $aModules;
}

/**
 * reorder page after it has been moved
 * 
 * @param  string $sDirection
 * @param  int    $iPageID
 */
function movePage($sDirection, $iPageID, $sBackURL = '') {
    $oMsgBox = new MessageBox();
    $admin = new Admin('Pages', 'pages_settings', false);
    if (isset($sDirection) && in_array($sDirection, array('move_up', 'move_down')) && isset($iPageID) AND is_numeric($iPageID)
    ) {
        // Create new order object
        $oOrder = new order('{TP}pages', 'position', 'page_id', 'parent');
        if ($oOrder->$sDirection($iPageID))
            $oMsgBox->success('{MESSAGE:PAGES_REORDERED}');
        else
            $oMsgBox->error('{MESSAGE:PAGES_CANNOT_REORDER}');
    } else {
        $oMsgBox->error('{MESSAGE:PAGES_CANNOT_REORDER}');
    }
    $sBackURL = $sBackURL != '' ? $sBackURL : ADMIN_URL . '/pages/?latest_page='.$iPageID.'#pageID_'.$iPageID;
    $oMsgBox->redirect($sBackURL);
    return;
}

/** 
 * function deletePage() is admin/pages/delete.php converted into function
 * 
 * @global object $database
 * @global object $admin
 * @param  int    $iPageID
 * @return void
 */
function deletePage($iPageID, $sBackURL = ''){	
	global $database, $admin;
	$oMsgBox = new MessageBox();
	$bTrashed = false;
	// Get perms
	if (!$admin->get_page_permission($iPageID, 'admin')) {
            $oMsgBox->error('{MESSAGE:PAGES_INSUFFICIENT_PERMISSIONS}');
	}
	// get Visibility of Page
	$sQuery = "SELECT `visibility` FROM `{TP}pages` WHERE page_id = '".$iPageID."'";
	$sVisibility = $database->get_one($sQuery);
	if($sVisibility == false) {
		$oMsgBox->error('{MESSAGE:PAGES_NOT_FOUND}');
	}
	// Check if we should delete it or just set the visibility to 'deleted'
	if(PAGE_TRASH != 'disabled' AND $sVisibility != 'deleted') {		
        // Page trash is enabled and page has not yet been deleted
        // Function to change all child pages visibility to deleted
        function trashSubpages($iParent = 0) {
            global $database;
            // Query pages
            $rChilds = $database->query(
                    "SELECT `page_id`, `visibility` FROM `{TP}pages` WHERE `parent` = '".$iParent."' ORDER BY `position` ASC"
            );
            // Check if there are any pages to show
            if($rChilds->numRows() > 0) {
                // Loop through pages
                while($rec = $rChilds->fetchRow()) {
                    // Update the page visibility to 'deleted'					
                    $database->updateRow('{TP}pages', 'page_id', array(
                        'page_id'           => $rec['page_id'],
                        'visibility'        => 'deleted',
                        'visibility_backup' => $rec['visibility']
                    ));					
                    trashSubpages($rec['page_id']); // Run this function again for all sub-pages
                }
            }
        }		
        // Update the page visibility to 'deleted'
        $database->updateRow('{TP}pages', 'page_id', array(
            'page_id'           => $iPageID,
            'visibility'        => 'deleted',
            'visibility_backup' => $sVisibility
        ));
        // Run trash subs for this page
        trashSubpages($iPageID);
        $bTrashed = true;
    } else {
        // Delete subs
        $aSubs = get_subs($iPageID, array());
        if (!empty($aSubs)) {
            foreach ($aSubs as $iSubPageID) {
                delete_page($iSubPageID);
            }
        }
        delete_page($iPageID); // Delete page after the subs were deleted
    }
    // Check if there is a db error, otherwise say successful
    if ($database->is_error()) {
        $aMsg['error'] = $database->get_error();
        $oMsgBox->error($database->get_error());  #
    } else {
        if ($bTrashed == true)
            $oMsgBox->success('{PAGES_TEXT:PAGE_MOVED_TO_TRASH}');
        else
            $oMsgBox->success('{MESSAGE:PAGES_DELETED}');
    }
    $sBackURL = $sBackURL != '' ? $sBackURL : ADMIN_URL . '/pages?trashed_page='.$iPageID;
    $oMsgBox->redirect($sBackURL);
    return;
}

/**
 * function restoreDeletedPage() 
 * is admin/pages/restore.php converted into function
 * 
 * @global object $database
 * @param  int    $iPageID
 * @return type 
 */
function restoreDeletedPage($iPageID, $sBackURL = '') {
    global $database;
    $oMsgBox = new MessageBox();
    $admin = new Admin('Pages', 'pages_delete', false);

    $rPage = $database->query("SELECT * FROM `{TP}pages` WHERE `page_id` = '" . $iPageID . "'");
    if ($database->is_error()) {
        $oMsgBox->error($database->get_error());
    }
    if ($rPage->numRows() == 0) {
        $oMsgBox->error('{MESSAGE:PAGES_NOT_FOUND}');
    }
    $aPage = $rPage->fetchRow();
    $aOldAdminGroups = explode(',', str_replace('_', '', $aPage['admin_groups']));
    $aOldAdminUsers = explode(',', str_replace('_', '', $aPage['admin_users']));
    $bInOldGroup = FALSE;
    foreach ($admin->get_groups_id() as $cur_gid) {
        if (in_array($cur_gid, $aOldAdminGroups)) {
            $bInOldGroup = TRUE;
        }
    }
    if ((!$bInOldGroup) AND ! is_numeric(array_search($admin->get_user_id(), $aOldAdminUsers))) {
        $oMsgBox->error('{MESSAGE:PAGES_INSUFFICIENT_PERMISSIONS}');
    }
    if (PAGE_TRASH) {
        if ($aPage['visibility'] == 'deleted') {

            // Function to change all child pages visibility to deleted
            function restoreSubpages($iParent = 0) {
                global $database;
                // Query pages
                $rSubpageData = $database->query(
                        "SELECT `page_id`, `visibility_backup` FROM `{TP}pages` 
						WHERE `parent` = '" . $iParent . "' ORDER BY `position` ASC"
                );
                // Check if there are any pages to show and loop through them, if any
                if ($rSubpageData->numRows() > 0) {
                    while ($rec = $rSubpageData->fetchRow()) {
                        $sNewVisibility = $rec['visibility_backup'] != '' ? $rec['visibility_backup'] : 'public';
                        // Update the page visibility to 'deleted'
                        $database->updateRow('{TP}pages', 'page_id', array(
                            'visibility' => $sNewVisibility,
                            'page_id' => $rec['page_id']
                                )
                        );
                        // Run this function again for all sub-pages
                        restoreSubpages($rec['page_id']);
                    }
                }
            }

            // Update the page visibility
            $sNewVisibility = $aPage['visibility_backup'] != '' ? $aPage['visibility_backup'] : 'public';
            $database->updateRow('{TP}pages', 'page_id', array(
                'visibility' => $sNewVisibility,
                'page_id' => $iPageID
                    )
            );
            // Run trash subs for this page
            restoreSubpages($iPageID);
        }
    }
    // Check if there is a db error, otherwise say successful	
    if ($database->is_error())
        $oMsgBox->error($database->get_error());
    else
        $oMsgBox->success('{MESSAGE:PAGES_RESTORED}');

    $sBackURL = $sBackURL != '' ? $sBackURL : ADMIN_URL . '/pages?restored_page='.$iPageID;
    $oMsgBox->redirect($sBackURL);
    return;
}

/**
 * function to enable/disable Drag&Drop PageTree
 * 
 * @global object $database
 * @param  int $dd
 * @return void
 */
function activateDragDrop($dd, $sBackURL = ''){
    Settings::Set('pages_drag_drop', $dd);    
    $oMsgBox = new MessageBox();
    $sStatus = ($dd == 0 ? 'DIS' : 'EN').'ABLED';
    $oMsgBox->success('{PAGES_TEXT:DRAGDROP_'.$sStatus.'}');
    return;
}

/**
 * createPage
 * 
 * @global object $database
 * @global array  $MESSAGE
 * @param  string $sMenuTitle
 * @param  string $sModuleType
 * @param  int    $iParent
 * @param  string $sVisibility
 * @param  array  $aAdminGroups
 * @param  array  $aViewingGroups
 * @param  bool   $goToPage
 * @return type
 */
function createPage(
    $sMenuTitle     = '', 
    $sModuleType    = '', 
    $iParent        = NULL, 
    $sVisibility    = 'public',
    $aAdminGroups   = array(),
    $aViewingGroups = array(),
    $goToPage       = 0
){
    global $database, $MESSAGE;
    $oMsgBox = new MessageBox();
    $admin = new Admin('Pages', 'pages_add', false);

    // add Admin to admin and viewing-groups
    $aAdminGroups[] = 1;
    $aViewingGroups[] = 1;
    // Check permissions an break up if insufficient
    if (!in_array(1, $admin->get_groups_id())) {
        $bAdminPermission = false;
        foreach ($aAdminGroups as $group) {
            if (in_array($group, $admin->get_groups_id()))
                $bAdminPermission = true;
        }
        if ($bAdminPermission == false)
            $admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS']);

        $bViewPermission = false;
        foreach ($aViewingGroups as $group) {
            if (in_array($group, $admin->get_groups_id()))
                $bViewPermission = true;
        }
        if ($bViewPermission == false)
            $admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS']);
    }

    // Work-out what the page sLink and page sFileName should be
    $sPrefix = $sSuffix = '';
    if ($iParent == '0') {
        $sPrefix = '/';
        $sTmp = $sPrefix . page_filename($sMenuTitle);
        if (in_array($sTmp, array('/index', '/intro')))
            $sSuffix = '_0';
    } else {
        $sParentLink = $database->get_one('SELECT `link` FROM `{TP}pages` WHERE `page_id` = ' . $iParent);
        $sPrefix = $sParentLink . '/';
    }
    $sLink = $sPrefix . page_filename($sMenuTitle) . $sSuffix;
    $sFileName = WB_PATH . PAGES_DIRECTORY . $sPrefix . page_filename($sMenuTitle) . $sSuffix . PAGE_EXTENSION;

    // Check if a page with same page sFileName exists
    $sSql = "SELECT `page_id` FROM `{TP}pages` WHERE `link`= '" . $sLink . "'";
    $bSameLinkExists = $database->get_one($sSql);
    if ($bSameLinkExists OR file_exists($sFileName)) {
        $oMsgBox->error($MESSAGE['PAGES_PAGE_EXISTS']);
    }

    // get new position
    $oOrder = new order('{TP}pages', 'position', 'page_id', 'parent');
    $oOrder->clean($iParent);
    $iPosition = $oOrder->get_new($iParent);

    $sTemplate = '';
    $sLanguage = DEFAULT_LANGUAGE;
    // check parent (if selected) for different template or language than the default
    $sSql = "SELECT template, language, menu FROM {TP}pages WHERE page_id = " . $iParent;
    $rQuery = $database->query($sSql);
    if ($rQuery->numRows() > 0) {
        $aParent = $rQuery->fetchRow(MYSQLI_ASSOC);
        $sTemplate = $aParent['template'];
        $sLanguage = $aParent['language'];
        $iMenu = $aParent['menu'];
    }

    $iMenu = isset($iMenu) ? intval($iMenu) : 1;
    $database->insertRow('{TP}pages', array('parent' => $iParent));
    // Get the new page_id, level
    $iPageID = $page_id = $database->getLastInsertId();
    $iLevel = level_count($iPageID);
    $aInsert = array(
        'page_id'        => $iPageID,
        'link'           => $sLink,
        'target'         => '_top',
        'root_parent'    => root_parent($iPageID),
        'level'          => $iLevel,
        'page_trail'     => get_page_trail($iPageID),
        'page_title'     => $sMenuTitle,
        'menu_title'     => $sMenuTitle,
        'template'       => $sTemplate,
        'visibility'     => $sVisibility,
        'position'       => $iPosition,
        'menu'           => $iMenu,
        'language'       => $sLanguage,
        'searching'      => 1,
        'modified_when'  => time(),
        'modified_by'    => $admin->get_user_id(),
        'admin_groups'   => implode(',', $aAdminGroups),
        'viewing_groups' => implode(',', $aViewingGroups)
    );	
	

    if(isPageCodeUsed()){		
        if(defined('PAGE_LANGUAGES') && PAGE_LANGUAGES && ($sLanguage == DEFAULT_LANGUAGE)){
            $aInsert['page_code'] = intval($iPageID);
        }
    }

    $database->updateRow('{TP}pages', 'page_id', $aInsert); 
    if ($database->is_error()) {
        $oMsgBox->error($database->get_error());
        return;
    }else{		
        if(isset($sParentLink)){
            make_dir(WB_PATH.PAGES_DIRECTORY.$sParentLink);
        }
        create_access_file($sFileName, $iPageID, $iLevel);
    }
	
    // add a new section with module into the DB
    $aInsertSection = array(
        'page_id'  => $iPageID,
        'module'   => $sModuleType,
        'position' => 1,
        'block'    => 1
     );
     $database->insertRow('{TP}sections', $aInsertSection);
    if (!($section_id = $database->getLastInsertId())) {
        $oMsgBox->error($database->get_error());
        return;
    } else {
        // use add.php file of the module
        $sAddFile = WB_PATH . '/modules/' . $sModuleType . '/add.php';
        if (is_file($sAddFile))
            require $sAddFile;
    }

    $sSuccess = '<b>' . $sMenuTitle . '</b><br>' . $MESSAGE['PAGES_ADDED'] . '';
    $oMsgBox->success($sSuccess);
    if ($goToPage == 1) {
        $_SESSION['pages_go_to_created'] = 1;
        $sBackURL = ADMIN_URL . '/pages/modify.php?page_id=' . $iPageID;
    } else {
        $_SESSION['pages_go_to_created'] = 0;
        $sBackURL = ADMIN_URL . '/pages/?latest_page='.$iPageID.'#pageID_'.$iPageID;
    }
    $oMsgBox->redirect($sBackURL);
}

/**
 * return array of all installed Languages
 * @return type
 */
function languagesArray(){
    $aLangs = array();
    $sSql = "SELECT `directory` as `lc`, `name` FROM `{TP}addons` WHERE `type` = 'language' ORDER BY `name`";
    return $GLOBALS['database']->get_array($sSql);
}
        
/**
 * Group list 1 AND Group list 2 (REGISTERED_VIEWERS and ADMINISTRATORS)
 * 
 * @global object $database
 * @global object $admin
 * @param  string $sOperators (viewers|admins)
 * @param  type $sCheckedOperators
 * @return boolean
 */
function listOperators($sOperators = 'viewers', $sCheckedOperators = '') {
    global $database, $admin;
    $aOperators = array();
    $rGroups = $database->query("SELECT * FROM `{TP}groups`");
    // Insert admin group and current group first
    $admin_group_name = $rGroups->fetchRow();
    $aOperators[1] = array(
        'group_id'   => 1,
        'group_name' => $admin_group_name['name'],
        'checked'    => true,
        'disabled'   => true,
    );
    while($group = $rGroups->fetchRow()) {
        // check if the user is a member of this group
        $bChecked = false;
        if($sCheckedOperators != ''){			
            if (in_array($group["group_id"], explode(',', $sCheckedOperators))) {
                $bChecked =  true;
            }
        }
        // Check if the viewing group allowed to edit pages
        $aSysPerms = explode(',', $group['system_permissions']);
        if(is_numeric(array_search('pages_modify', $aSysPerms)) || $sOperators='admins') {
            $aOperators[$group['group_id']] = array(
                'group_id'   => $group['group_id'],
                'group_name' => $group['name'],
                'checked'    => $bChecked,
                'disabled'   => false,
            );
        }
    }
    return $aOperators;
}


/**
 * this function generates the surrounding template 
 * for pages areas: modify, sections, settings 
 * it will include a template file and fill with data
 * 
 * @global object $admin
 * @global object $database
 * @global array  $HEADING
 * @global array  $TEXT
 * @global array  $MESSAGE
 * @global array  $PAGES_TEXT
 * @param  string $sArea (settings|sections|modify)
 * @param  int    $iPageID
 */
function pagesAreaFrame($iPageID) {
    // set globals and get instances of objects
    global $admin, $database, $HEADING, $TEXT, $MESSAGE, $PAGES_TEXT;

    // Get all the page details
    $aPage = $admin->get_page_details($iPageID);
    // prepare readable Date & Time
    if ($aPage['modified_when'] != 0) {
        $aPage['modified_date'] = date(DATE_FORMAT, $aPage['modified_when'] + TIMEZONE);
        $aPage['modified_time'] = date(TIME_FORMAT, $aPage['modified_when'] + TIMEZONE);
    }

    // get user details of last editor (last modified by)
    $aUserTmp = $admin->get_user_details($aPage['modified_by']);
	
    // collect variable array for output in Template
    $aTemplateData = array(
        'page_id'       => $iPageID,
        'modified_date' => $aPage['modified_date'],
        'modified_time' => $aPage['modified_time'],
        'page_title'    => $aPage['page_title'],
        'menu_title'    => $aPage['menu_title'],
        'author'        => array(
            'id'         => $aPage['modified_by'],
            'login_name' => $aUserTmp['username'],
            'name'       => $aUserTmp['display_name'],
            'email'      => $aUserTmp['email'],
        )		
    );		

    return $aTemplateData;
}

if(!function_exists('renderPagesTabs')){
    /**
     * @funcname renderAddonsTabs
     * @brief    Build the Tab Navigation used in AdminTools
     *           and other parts of the Admin Backend
     *         
     *           The provided array should consist of 
     *           pos_parameter => array(LinkName, IconCode)
     *           for each tab element
     * 
     *           example:
     *           ====================================================================
     *           array(
     *               'tool_overview' => array($TOOL_TXT['OVERVIEW'], 'user-circle'),
     *               'config'        => array($TOOL_TXT['CONFIG'], 'calendar'),
     *           );
     *  
     * @param    array $aTabs
     * @return   array
     */
    function renderPagesTabs($sCurrPos = 'modify') {

        // check permissions of the addons areas
        $aAllowed = array();
        $aPerms = array(
            'settings' => 'pages_settings', 
            'sections' => 'pages_modify', 
            'modify'   => 'pages_modify'
        );
        // only add to the links if user has permissions
        foreach ($aPerms as $key => $perm) {
            if ($GLOBALS['admin']->get_permission($perm)) {
                $aAllowed[] = $key;
            }
        }
        
        // the actual link positions available in the addons area 
        $aTabs = array(
            'modify'   => array(L_('TEXT:MODIFY_PAGE_CONTENTS'), 'pencil'),
            'sections' => array(L_('HEADING:MANAGE_SECTIONS'), 'server'),
            'settings' => array(L_('TEXT:CHANGE_SETTINGS'), 'cog'),
        );
        
        $aRetVal = array();
        foreach ($aTabs as $key => $aValues) {
            if($key == 'sections' && isPageMenuLink($_GET['page_id'])){
                continue;
            }
            $sUri = $key;
            if (!in_array($key, $aAllowed)) {
                continue; // don't generate links the user has no access to
            }
            $bCurr = false;
            $bCurr = ($key == $sCurrPos);
            $aRetVal[$key]['pos']       = 'pages/'.$sUri.'.php?page_id='.$_GET['page_id'];
            $aRetVal[$key]['a_class']   = ($bCurr) ? ' sel' : '';
            $aRetVal[$key]['li_class']  = ($bCurr) ? ' class="actionSel"' : '';
            $aRetVal[$key]['link_name'] = $aValues[0];
            $aRetVal[$key]['icon']      = $aValues[1];
        }
        return $aRetVal;
    }    
}

/**
 * Check if Page is of Type menu_link
 *
 * @param int $iPageID
 * @return int|bool (false if not menu_link)
 */
function isPageMenuLink($iPageID){
    $sSql = "SELECT COUNT(*) FROM `{TP}sections` 
            WHERE `page_id` = ".$iPageID." AND `module` = 'menu_link'";
    return $GLOBALS['database']->get_one($sSql);
}