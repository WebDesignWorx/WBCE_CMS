<?php

/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

/**
 * page_link_reserved
 *
 * @global object $database
 * @param  string $sLink
 * @param  int    $iPageID
 * @return array|bool
 */
function page_link_reserved($sLink, $iPageID) {
    global $database;
    $sSql = "SELECT `page_id`, `menu_title` FROM `{TP}pages` 
                WHERE `link` = '" . $sLink . "' AND `page_id` <> " . $iPageID . "";
    $oResult = $database->query($sSql);
    if ($oResult->numRows() > 0) {
        return $oResult->fetchRow(MYSQL_ASSOC);
    } else {
        return false;
    }
}

/**
 * page_dlink_reserved
 *
 * @global object $database
 * @param  string $sDlink
 * @param  int    $iPageID
 * @return array|bool
 */
function page_dlink_reserved($sDlink, $iPageID) {
    global $database;
    $sSql = "SELECT `page_id` FROM `{TP}pages` WHERE `dlink` = '" . $sDlink . "' AND `page_id` <> " . $iPageID . "";
    $oResult = $database->query($sSql);
    if ($oResult->numRows() > 0) {
        return $oResult->fetchRow(MYSQL_ASSOC);
    } else {
        return false;
    }
}

/**
 * recreateAccessFile
 * 
 * @global object $database
 * @param  int    $iPageID
 * @param  string $sOldLink
 * @param  string $sLink
 * @param  string $sFilename
 * @param  int    $iLevel
 */
function recreateAccessFile($iPageID = NULL, $sOldLink, $sLink, $sFilename, $iLevel) {
    global $database;
    $sOldFilename = WB_PATH . PAGES_DIRECTORY . $sOldLink . PAGE_EXTENSION;
    // First check if we need to create a new file
    if (($sOldLink != $sLink) || (!file_exists($sOldFilename))) {
        // Delete old file
        $sOldFilename = WB_PATH . PAGES_DIRECTORY . $sOldLink . PAGE_EXTENSION;
        if (file_exists($sOldFilename)) {
            unlink($sOldFilename);
        }
        // Create access file
        create_access_file($sFilename, $iPageID, $iLevel);
        // Move a directory for this page
        $sOldDir = WB_PATH . PAGES_DIRECTORY . $sOldLink . '/';
        if (file_exists($sOldDir) && is_dir($sOldDir)) {
            rename($sOldDir, WB_PATH . PAGES_DIRECTORY . $sLink . '/');
        }
        // Update any pages that had the old link with the new one
        $rSubs = $database->query("SELECT `page_id`, `link`, `level` 
			FROM `{TP}pages` WHERE `link` LIKE '%" . $sOldLink . "/%' ORDER BY LEVEL ASC");

        if ($rSubs->numRows() > 0) {
            while ($rec = $rSubs->fetchRow()) {
                // Double-check to see if it contains old link
                if (substr($rec['link'], 0, strlen($sOldLink)) == $sOldLink) {
                    // Get new link
                    $sNewSubLink = $sLink . '/' . substr($rec['link'], strlen($sOldLink) + 1, strlen($rec['link']));
                    // Work out level
                    $iNewSubLevel = level_count($rec['page_id']);
                    // Update level and link
                    $database->updateRow('{TP}pages', 'page_id', array(
                        'page_id' => $rec['page_id'],
                        'link' => $sNewSubLink,
                        'level' => $iNewSubLevel
                            )
                    );

                    // Re-write the access file for this page
                    $sOldSubpageFile = WB_PATH . PAGES_DIRECTORY . $sNewSubLink . PAGE_EXTENSION;
                    if (file_exists($sOldSubpageFile)) {
                        unlink($sOldSubpageFile);
                    }
                    create_access_file($sOldSubpageFile, $rec['page_id'], $iNewSubLevel);
                }
            }
        }
    }
}

/**
 * savePageSettings
 * 
 * @global object $admin
 * @global object $database
 * @global string $MESSAGE
 * @param  array  $aPostData
 */
function savePageSettings($aPostData) {
    global $admin, $database, $MESSAGE;
    
    $iPageID  = (int) $_POST['page_id'];
    $sBackUrl = ADMIN_URL . '/pages/settings.php?page_id=' . $iPageID;
    // file_name gets special threatment
    $sPhisicalFilename = str_replace(array("[[", "]]"), '', htmlspecialchars($admin->get_post_escaped('file_name')));
    if ($sPhisicalFilename == '' || substr($sPhisicalFilename, 0, 1) == ' .') {
        $admin->print_error($MESSAGE['PAGES_BLANK_LINK_TITLE'], $sBackUrl);
    }
    // work out direct_link
    $sDirectLink = "";
    if (preg_match("/^\[wblink\d+\]$/", $sPhisicalFilename)) //is this link a WBlink? (direct link)
        $sDirectLink = $sPhisicalFilename;

    if (preg_match("/\:\/\//", $sPhisicalFilename)) //is this an external Link (direct link)
        $sDirectLink = $sPhisicalFilename;


    // Get existing page data
    $aPage           = $admin->get_page_details($iPageID);
    $sOldLink        = $aPage['link'];
    $sOldPosition    = $aPage['position'];
    $aOldAdminGroups = explode(',', str_replace('_', '', $aPage['admin_groups']));
    $aOldAdminUsers  = explode(',', str_replace('_', '', $aPage['admin_users']));

    $bInOldGroup = FALSE;
    foreach ($admin->get_groups_id() as $cur_gid) {
        if (in_array($cur_gid, $aOldAdminGroups)) {
            $bInOldGroup = TRUE;
        }
    }
    if ((!$bInOldGroup) && !is_numeric(array_search($admin->get_user_id(), $aOldAdminUsers))) {
        $admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'], $sBackUrl);
    }

    // Work out operating groups (Admins and Viewers)
    $aAdminGroups     = $admin->get_post_escaped('admin_groups');
    $aViewingGroups   = $admin->get_post_escaped('viewing_groups');
    // Setup admin groups
    $aAdminGroups[]   = 1;
    $aAdminGroups     = preg_replace("/[^\d,]/", "", implode(',', $aAdminGroups));
    // Setup viewing groups
    $aViewingGroups[] = 1;
    $aViewingGroups   = preg_replace("/[^\d,]/", "", implode(',', $aViewingGroups));

    // Work out the `parent`
    $iParentId = intval($admin->get_post('parent'));
    if ($iParentId != $aPage['parent']) {
        // Get new order
        $oOrder = new order('{TP}pages', 'position', 'page_id', 'parent');
        $sPosition = $oOrder->get_new($iParentId);
        $oOrder->clean($iParentId); // Clean new order
    } else {
        $sPosition = $sOldPosition;
    }

    // Work out level and root parent
    if ($iParentId != '0') {
        $iLevel = level_count($iParentId) + 1;
        $iRootParent = root_parent($iParentId);
    } else {
        $iLevel = '0';
        $iRootParent = '0';
    }

    // Work-out what the `link`
    if ($iParentId == '0') {
        $sLink = '/' . page_filename($sPhisicalFilename);
        // rename menu titles: index && intro to prevent clashes with intro page feature and WB core file /pages/index.php
        if ($sLink == '/index' || $sLink == '/intro') {
            $sLink .= '_' . $iPageID;
        }
        $sFilename = WB_PATH . PAGES_DIRECTORY . '/' . page_filename($sLink) . PAGE_EXTENSION;
    } else {
        $iParentLink = $database->get_one('SELECT `link` FROM `{TP}pages` WHERE `page_id` = ' . $iParentId);
        $sFilename   = WB_PATH . PAGES_DIRECTORY . $iParentLink . '/' . page_filename($sPhisicalFilename) . PAGE_EXTENSION;
        make_dir(WB_PATH . PAGES_DIRECTORY . $iParentLink);
        $sLink = $iParentLink . '/' . page_filename($sPhisicalFilename);
    }

    //handle direct links
    if ($sDirectLink != "") {
        $sLink = $sDirectLink;
    }

    // Check if a page with same page filename exists
    if ($sDirectLink == "") {
        if ($sMsg = page_link_reserved($sLink, $iPageID)) {
            $admin->print_error($MESSAGE['PAGES_PAGE_EXISTS'] . wb_dump($sMsg), $sBackUrl);
        }
    }

    // Update page with new order
    $aUpdateOrder = array(
        'page_id'  => $iPageID,
        'parent'   => $iParentId,
        'position' => $sPosition,
    );

    // update from array
    $database->updateRow('{TP}pages', 'page_id', $aUpdateOrder);


    // update page with new data
    $aUpdate = array(
        'page_id'        => $iPageID,
        'menu'           => intval($admin->get_post('menu')),
        'level'          => $iLevel,
        'parent'         => $iParentId,
        'page_trail'     => get_page_trail($iPageID),
        'root_parent'    => $iRootParent,
        'link'           => $sLink,
        'template'       => preg_replace('/[^a-z0-9_-]/i', "", $admin->get_post('template')),
        'target'         => preg_replace("/\W/", "", $admin->get_post('target')),
        'description'    => str_replace(array("[[", "]]"), '', htmlspecialchars($database->escapeString($admin->get_post('description')))),
        'keywords'       => str_replace(array("[[", "]]"), '', htmlspecialchars($database->escapeString($admin->get_post('keywords')))),
        'searching'      => $admin->get_post('searching'),
        'admin_groups'   => $aAdminGroups,
        'viewing_groups' => $aViewingGroups
    );
    if (defined('WB_SHORTURL_ONELEVEL') && WB_SHORTURL_ONELEVEL == true) {
        $sDlink = $admin->get_post('dlink');
        // Check if a page with same page filename exists
        if ($sDlink != "") {
            if ($sMsg = page_dlink_reserved($sDlink, $iPageID)) {
                $admin->print_error('Der gewählte Wunschlink ist bereits vergeben' . debug_dump($sMsg), $sBackUrl);
            }
        }
        $aUpdate['dlink'] = $sDlink;
    }

    // add menu_title
    $aUpdate['menu_title'] = str_replace(array("[[", "]]"), '', htmlspecialchars($admin->get_post_escaped('menu_title')));
    if ($aUpdate['menu_title'] == '' || substr($aUpdate['menu_title'], 0, 1) == '.') {
        $admin->print_error($MESSAGE['PAGES_BLANK_MENU_TITLE'], $sBackUrl);
    }

    // add page_title
    $aUpdate['page_title'] = str_replace(array("[[", "]]"), '', htmlspecialchars($admin->get_post_escaped('page_title')));
    if ($aUpdate['page_title'] == '' || substr($aUpdate['page_title'], 0, 1) == '.') {
        $admin->print_error($MESSAGE['PAGES_BLANK_PAGE_TITLE'], $sBackUrl);
    }

    // add language
    $sTmpLang = strtoupper($admin->get_post('language'));
    $aUpdate['language'] = (preg_match('/^[A-Z]{2}$/', $sTmpLang) ? $sTmpLang : DEFAULT_LANGUAGE);

    // add visibility
    $aUpdate['visibility'] = $admin->get_post('visibility');
    if (!in_array($aUpdate['visibility'], array('private', 'registered', 'hidden', 'none'))) {
        $aUpdate['visibility'] = 'public';
    }
    // add page_code
    if ($database->field_exists('{TP}pages', 'page_code')) {
        if (defined('PAGE_LANGUAGES') && PAGE_LANGUAGES && (file_exists(WB_PATH . '/modules/mod_multilingual/update_keys.php'))
        ) {
            $aUpdate['page_code'] = intval($admin->get_post('page_code'));
        }
    }
    $database->updateRow('{TP}pages', 'page_id', $aUpdate);
    if ($database->is_error()) {
        $admin->print_error($database->get_error(), $sBackUrl);
    }
    // Clean old order if needed
    if ($iParentId != $aPage['parent']) {
        $oOrder->clean($aPage['parent']);
    }

    // Create a new file in the /pages dir if title changed
    if (!is_writable(WB_PATH . PAGES_DIRECTORY . '/')) {
        $admin->print_error($MESSAGE['PAGES_CANNOT_CREATE_ACCESS_FILE']);
    } else {
        recreateAccessFile($iPageID, $sOldLink, $sLink, $sFilename, $iLevel);
    }

    fix_page_trail($iPageID, $iRootParent); // Fix sub-pages page trail
    // Check if there is a db error, otherwise say successful
    if ($database->is_error()) {
        $admin->print_error($database->get_error(), $sBackUrl);
    } else {
        return true;
    }
}

/**
 * fix_page_trail
 * 
 * @global object $admin
 * @global type?  $template
 * @global object $database
 * @param  int    $iParent
 * @param  int    $iRootParent
 */
function fix_page_trail($iParent, $iRootParent) {
    // Get objects and vars from outside this function
    global $admin, $template, $database;
    $sQuery = "SELECT `page_id` FROM `{TP}pages` WHERE `parent` = '" . $iParent . "'";
    $rPages = $database->query($sQuery);
    // Insert values into main page list
    if ($rPages->numRows() > 0) {
        while ($rec = $rPages->fetchRow()) {
            // Fix page trail
            $aData = array(
                'page_id' => $rec['page_id'],
                'root_parent' => ($iRootParent != 0) ? $iRootParent : '',
                'page_trail' => get_page_trail($rec['page_id']),
            );
            $database->updateRow('{TP}pages', 'page_id', $aData);
            // Run this function recursivly on all subs
            fix_page_trail($rec['page_id'], $iRootParent);
        }
    }
}
