<?php

/**
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */
// this CONSTANT should be reworked and the setting placed elsewhere
defined("BLOCKS_USE_ZERO") or define("BLOCKS_USE_ZERO", true);
WbAuto::AddFile("DateTimePicker","/include/DateTimePicker/DateTimePicker.php");

class PageSections {

    protected $_oApp = null;
    protected $_oDb = null;
    protected $_oMsgBox = null;
    public $iPageID = 0;
    public $iSectionsTotal = 0;
    public $bCanDeleteSections = false;

    /**
     * constructor used to import some application constants and objects
     */
    public function __construct() {
        // import global vars and objects
        $this->_oDb = $GLOBALS['database'];
        $this->_oApp = isset($GLOBALS['admin']) ? $GLOBALS['admin'] : $GLOBALS['wb'];
        $this->_oMsgBox = new MessageBox();
        $this->iPageID = $this->getPageID();
    }

    private function getPageID() {
        $iPageID = 0;
        if (defined('PAGE_ID')) {
            $iPageID = PAGE_ID;
        } else {
            $requestMethod = '_' . strtoupper($_SERVER['REQUEST_METHOD']);
            if (isset(${$requestMethod}['page_id'])) {
                $iPageID = intval(${$requestMethod}['page_id']);
            }
        }
        return $iPageID;
    }

    public function activateDragDrop($iDD, $iPageID) {
        Settings::Set('sections_drag_drop', $iDD);    
        $sStatus = ($iDD == 0 ? 'DIS' : 'EN').'ABLED';
        $this->_oMsgBox->success('{PAGES_TEXT:DRAGDROP_'.$sStatus.'}');
        $this->_oMsgBox->redirect(ADMIN_URL.'/pages/sections.php?page_id='.$iPageID);
    }


    /**
     * generate details of a section and return as assoc array
     * =======================================================
     * @param  integer $iSectionID
     * @param  bool    $bSingleDisplay (in case you call this method directly for single display)
     * @return array  (will return an assoc array with section details)
     */
    public function getSectionDetails($iSectionID = 0, $bSingleDisplay = false) {
        $aSec = array();
        if ($aSec = $this->getSingleSectionArray($iSectionID)) {
            // rewrite values with corrected data and add new key=>value pairs to the array
            $aSec['SECTION_IDKEY'] = $aSec['section_id'];
            $aSec['SECTION_IDKEY'] = $this->_oApp->getIDKEY($aSec['section_id']);
            if ($aSec['module_name'] == false) {
                $aSec['module_name'] = '';
            }
            $aSec['anchor'] = SEC_ANCHOR . $aSec['section_id'];
            $aSec['anchor_url'] = ADMIN_URL . '/pages/modify.php?page_id=' . $aSec['page_id'] . '&hilite='.$aSec['section_id'].'#' . $aSec['anchor'];
            if (defined('EDIT_ONE_SECTION') && EDIT_ONE_SECTION != '') {
                $aSec['anchor_url'] .= '&amp;wysiwyg=' . $aSec['section_id'];
            }
            // set calendar values 
            $oDTPicker = new DateTimePicker(array('selector' => 'DateTimePicker'));
            $aSec['publ_start'] = $oDTPicker->reformatTimeStamp($aSec['publ_start']);
            $aSec['publ_end'] = $oDTPicker->reformatTimeStamp($aSec['publ_end']);

            // Get Template Block Name 
            // only compute for single display
            if (SECTION_BLOCKS == true && $bSingleDisplay == true) {
                if ($aTemplateBlocks = $this->getLayoutBlocks($aSec['page_id'])) {
                    $aSec['block_name'] = $aTemplateBlocks[$aSec['block']];
                }
            }
        }
        return $aSec;
    }

    /**
     * get array of all section_id's of page_id 
     * $iPageID may be used for mass display
     * =======================================================
     * @param integer iPageID 
     * @param string  sOrderBy custom db query
     * @param string  sGroupBy custom db query
     * @return array 
     */
    public function getSectionsList($iPageID = 0, $sOrderBy = 'position', $sGroupBy = '') {
        $sSql = 'SELECT `section_id` FROM `{TP}sections` ';
        if ($iPageID != 0) {
            $sSql .= ' WHERE `page_id` = ' . $iPageID . '';
        }
        $sSql .= ' ORDER BY `' . $sOrderBy . '` ASC';
        if ($sGroupBy != '') {
            $sSql .= ' GROUP BY `' . $sGroupBy . '`';
        }

        $aSections = array();
        if ($rSections = $this->_oDb->query($sSql)) {
            // LOOP THROUGH SECTIONS AND COLLECT DATA FOR ARRAY
            while ($oResult = $rSections->fetchRow(MYSQLI_ASSOC)) {
                $aSection = $this->getSectionDetails($oResult['section_id']);
                if (isset($aSection['module_dir']) && is_numeric(array_search($aSection['module_dir'], $_SESSION['MODULE_PERMISSIONS']))) {
                    // skip all sections with modules where user has no permissions for
                    continue;
                } else {
                    if ($iPageID != 0) {
                        $aSection['canMoveUp'] = ($aSection['position'] != 1) ? true : false;
                        $aSection['canMoveDown'] = ($aSection['position'] != $rSections->numRows()) ? true : false;
                    }

                    // array for layout blocks	
                    $aSection['blockSelect'] = array();
                    if (SECTION_BLOCKS == true) {
                        $aBlocks = $this->getLayoutBlocks($iPageID); // get all the blocks defined in template
                        $aSection['block_name'] = $aBlocks[$aSection['block']];

                        // SELECT COMBOBOX ARRAY FOR Blocks
                        $aBlockVars = array();
                        foreach ($aBlocks as $k => $sName) {
                            $aBlockVars[$k]['name'] = htmlentities(strip_tags($sName));
                            $aBlockVars[$k]['value'] = $k;
                            $aBlockVars[$k]['selected'] = ($aSection['block'] == $k) ? 1 : 0;
                        }
                        $aSection['blockSelect'] = $aBlockVars;
                        if (count($aBlocks) == 1) {
                            $aSection['blockSelect']['disabled'] = true;
                        }
                    }
                   # $aSection['modify_container'] = $this->modifySectionContainer($aSection['section_id']);
                    if( isset($_REQUEST['page_id']) &&
                            strposm($_SERVER['PHP_SELF'], array('pages/sections.php', 'pages/settings.php')) == false
                    ){
                        ob_start();
                        global $MESSAGE;
                        $section_id = $aSection['section_id'];
                        $page_id = $iPageID;
                        $sModuleDir = $this->getSectionsModuleType($section_id);
                        $sModifyFile = WB_PATH . '/modules/' . $sModuleDir . '/modify.php';
                        if (is_file($sModifyFile)) {
                            // Deprecated wording of variables needed ($page_id, $section_id)
                            global $TEXT, $MENU, $database, $admin;
                            include $sModifyFile;
                        } else {
                            echo '<div class="alert alert-danger"><kbd>"' . $sModuleDir . '"</kbd>:<b>  '
                            . $MESSAGE['GENERIC_MODULE_VERSION_ERROR'] . '</b></div>';
                        }
                        $aSection['modify_container'] = ob_get_clean();                        
                    }
                    
                    if(isset($_GET['hilite']) && $_GET['hilite'] == $section_id){                        
                        $aSection['hilite'] = true;
                    }
                    $aSections[$aSection['section_id']] = $aSection;
                    unset($aSection);
                    ++$this->iSectionsTotal;
                }
            }
        }
        return $aSections;
    }

    // this function will include the modify.php of the module
    public function modifySectionContainer($iSectionID, $iPageID = 0) {
        ob_start();
        global $MESSAGE;
        $sModuleDir = $this->getSectionsModuleType($iSectionID);
        $page_id = $this->iPageID;
        $section_id = $iSectionID;
        $sModifyFile = WB_PATH . '/modules/' . $sModuleDir . '/modify.php';
        if (is_file($sModifyFile)) {
            // Deprecated wording of variables needed ($page_id, $section_id)
            global $TEXT, $MENU, $database, $admin;
            include $sModifyFile;
        } else {
            echo '<div class="alert alert-danger"><kbd>"' . $sModuleDir . '"</kbd>:<b>  '
            . $MESSAGE['GENERIC_MODULE_VERSION_ERROR'] . '</b></div>';
        }
        $sOutput = ob_get_contents();
        ob_end_clean();
        return $sOutput;
    }

    // get section array for one section
    // this is for RAW data which will be handled further
    public function getSingleSectionArray($iSectionID) {
        $aSections = array();
        $sSql = (
            'SELECT 
                s.*,
                a.`name` as `module_name`
                    FROM `{TP}sections` s
                        INNER JOIN `{TP}addons` a
                        ON s.`module` = a.`directory` 
            WHERE s.`section_id` = ' . intval($iSectionID)
        );
        if ($oResult = $this->_oDb->query($sSql)) {
            $aSections = $oResult->fetchRow(MYSQLI_ASSOC);
        }
        return $aSections;
    }

    public function getLayoutBlocks($iPageID) {
        global $TEXT;
        $block = array();
        if (SECTION_BLOCKS == true) {
            $aPage = $this->_oApp->get_page_details($iPageID);
            // check whether DEFAULT_TEMPLATE in use on this page or not
            $sTemplateDir = ($aPage['template'] != '') ? $aPage['template'] : DEFAULT_TEMPLATE;
            // include info.php file to get the block array
            $sInfoFile = WB_PATH . '/templates/' . $sTemplateDir . '/info.php';
            if (file_exists($sInfoFile)) {
                require $sInfoFile;
            }
            // check block settings from template/info.php
            if (sizeof($block) > 0) {
                if (isset($block[0]) && defined("BLOCKS_USE_ZERO") && BLOCKS_USE_ZERO == false) {
                    throw new AppException(
                    'Invalid index 0 for $block[] in ' . str_replace(WB_PATH, '', $template_location) . '. '
                    . 'The list must start with $block[1]. Please correct it!'
                    );
                }
                foreach ($block as $row => $title) {
                    if (trim($title) == '') {
                        $block[$row] = $TEXT['TEXT_BLOCK'] . '_' . $row;
                    }
                }
            }
            if (empty($block)) {
                $block = array(1 => $TEXT['MAIN']);
            }
        }
        return (array) $block;
    }

    /**
     * total number of found pages which are visible for actual user
     * @return integer
     */
    protected function _getTotalSections() {
        return $this->iSectionsTotal;
    }

    public function getSectionsPageID($iSectionID) {
        return $this->_oDb->get_one(
                        "SELECT `page_id` FROM `{TP}sections` 
			WHERE `section_id` = '" . intval($iSectionID) . "'"
        );
    }

    public function getSectionsModuleType($iSectionID) {
        return $this->_oDb->get_one(
                        "SELECT `module` 
				FROM `{TP}sections` 
				WHERE `section_id` = " . $iSectionID
        );
    }

    public function deletePageSection($iSectionID, $sBacklink = "") {
        global $TEXT, $PAGES_TEXT;

        $sModule = $this->getSectionsModuleType($iSectionID);
        $admin = $this->_oApp;
        $iPageID = $this->getSectionsPageID($iSectionID);
        if ($sBacklink == "") {
            $sBacklink = ADMIN_URL . '/pages/sections.php?page_id=' . $iPageID;
        }
        if ($admin->get_permission('pages_delete') == false) {
            $this->_oMsgBox->error('MESSAGE:GENERIC_SECURITY_ACCESS');
        };
        if (is_string($sModule) && $iSectionID > 0) {
            // Include the modules delete file if it exists
            $sDeleteFile = WB_PATH . '/modules/' . $sModule . '/delete.php';
            if (file_exists($sDeleteFile)) {
                $database = $this->_oDb;
                $section_id = $iSectionID;
                require $sDeleteFile;
            }
            $sDeleteQuery = "DELETE FROM `{TP}sections` WHERE `section_id` ='" . $iSectionID . "' LIMIT 1";
            if (!$this->_oDb->query($sDeleteQuery)) {
                $this->_oMsgBox->success($this->_oDb->get_error());
            } else {
                require_once WB_PATH . '/framework/class.order.php';
                $oOrder = new order('{TP}sections', 'position', 'section_id', 'page_id');
                $oOrder->clean($iPageID);
                $this->_oMsgBox->success('{PAGES_TEXT:SECTION_DELETED} <b>' . mb_strtoupper($sModule, 'UTF-8') . '</b> (' . $iSectionID . ')');
            }
        } else {
            $this->_oMsgBox->error($sModule . ' ' . mb_strtolower($TEXT['NOT_FOUND'], 'UTF-8'));
        }
        $this->_redirect($sBacklink);
    }

    public function addPageSection($sModule, $page_id = 0, $iBlockId = 0) {
        global $MESSAGE, $TEXT, $PAGES_TEXT;
        // ADD SECTION		
        $section_id = 0;
        $admin = $this->_oApp;
        $sModule = preg_replace('/\W/', '', $sModule);  // fix secunia 2010-91-4
        $sErrorMsg = '';
        $sSuccessMsg = '';
        $sBacklink = ADMIN_URL . '/pages/sections.php?page_id=' . $page_id;
        if ($admin->get_permission('pages_add') == false) {
            $sErrorMsg = $sModule . ' ' . mb_strtolower($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'], 'UTF-8');
        }

        // check if modules add.php file exits
        $sAddFile = WB_PATH . '/modules/' . $sModule . '/add.php';
        if (is_readable($sAddFile)) {
            require_once WB_PATH . '/framework/class.order.php';
            // Get new order
            $order = new order('{TP}sections', 'position', 'section_id', 'page_id');
            $iPos = $order->get_new($page_id);
            // Insert module into DB
            $aData = array(
                'page_id' => (int) $page_id,
                'module' => $sModule,
                'block' => $iBlockId,
                'position' => (int) $iPos,
                'publ_start' => '0',
                'publ_end' => '0'
            );
            if ($this->_oDb->insertRow('{TP}sections', $aData)) {
                // we need exact wording for $section_id and $database here
                $iSectionID = $section_id = $this->_oDb->getLastInsertId();
                $database = $this->_oDb;
                require $sAddFile;
            } elseif ($this->_oDb->is_error()) {
                $sErrorMsg = $this->_oDb->get_error();
            }
        } else {
            $sErrorMsg = 'add.php for selected module not found!!!';
        }

        if ($sErrorMsg != '')
            $this->_oMsgBox->error($sErrorMsg);
        else
            $this->_oMsgBox->success('{PAGES_TEXT:SECTION_ADDED} <b>' . mb_strtoupper($sModule, 'UTF-8') . '</b> (' . $iSectionID . ')');

        $this->_redirect($sBacklink . "&last_id=" . $section_id);
    }

    public function moveSection($sDirection = '', $iSectionID = NULL) {
        // Include the ordering class
        require WB_PATH . '/framework/class.order.php';
        $admin = new admin('Pages', 'pages_modify', false);
        $oOrder = new order('{TP}sections', 'position', 'section_id', 'page_id');
        $sBacklink = ADMIN_URL . '/pages/sections.php?page_id=' . $this->getSectionsPageID($iSectionID);
        if ($oOrder->$sDirection($iSectionID))
            $this->_oMsgBox->success('PAGES_TEXT:SECTION_REORDERED');
        else
            $this->_oMsgBox->error('TEXT:ERROR');

        $this->_redirect($sBacklink);
    }

    public function changeSectionsSettings($iPageID) {
        
        $oDatePicker = new DateTimePicker();
        $sStartDate = $oDatePicker->strToTimestamp($sStartDate);
        $sEndDate = $oDatePicker->strToTimestamp($sEndDate);

        $aUpdates = array();
        foreach ($this->getSectionsList($iPageID) as $section) {
            if (!is_numeric(array_search($section['module_dir'], $_SESSION['MODULE_PERMISSIONS']))) {
                //Update the section record with properties
                $iSectionID = $section['section_id'];
                $publ_start = 0;
                $publ_end = 0;
                $dst = date("I") ? " DST" : ""; // daylight saving time?
                $aUpdate = array();

                // block
                if (isset($_POST['block' . $iSectionID]) && $_POST['block' . $iSectionID] != '') {
                    $aUpdate['block'] = $this->_oApp->add_slashes($_POST['block' . $iSectionID]);
                }

                // namesection
                if (isset($_POST['namesection' . $iSectionID])) {
                    $aUpdate['namesection'] = $this->_oApp->add_slashes($_POST['namesection' . $iSectionID]);
                }

                // update publ_start and publ_end, trying to make use of 
                // the strtotime()-features like "next week", "+1 month", ...
                if (isset($_POST['publ_start' . $iSectionID]) && isset($_POST['publ_end' . $iSectionID])) {
                    $sStart = 0;
                    if (trim($_POST['publ_start' . $iSectionID]) != '0' || trim($_POST['publ_start' . $iSectionID]) != '') {
                        $sStart = $oDatePicker->strToTimestamp($_POST['publ_start' . $iSectionID]);
                    }
                    $sEnd = 0;
                    if (trim($_POST['publ_end' . $iSectionID]) != '0' || trim($_POST['publ_end' . $iSectionID]) != '') {
                        $sEnd = $oDatePicker->strToTimestamp($_POST['publ_end' . $iSectionID]);
                    }
                    $aUpdate['publ_start'] = $this->_oApp->add_slashes($sStart);
                    $aUpdate['publ_end'] = $this->_oApp->add_slashes($sEnd);
                }
                if (!empty($aUpdate)) {
                    $aUpdate['section_id'] = $iSectionID;
                    $aUpdates[] = $aUpdate;
                }
            }
        }

        if (!empty($aUpdates)) {
            foreach ($aUpdates as $data) {
                $this->_oDb->updateRow('{TP}sections', 'section_id', $data);
            }
            if ($this->_oDb->is_error())
                $this->_oMsgBox->error($this->_oDb->get_error());
            else
                $this->_oMsgBox->success('MESSAGE:RECORD_MODIFIED_SAVED');
        }
        return;
    }

    /**
     * redirect
     * will execute header('Location... if headers not yet sent
     * if heders already sent, will fall back to a JS solution
     * should JS be disabled, will fall back to meta http refresh
     */
    private function _redirect($sUrl) {
        if (headers_sent() == false) {
            header('Location: ' . $sUrl);
        } else {
            /*
              echo '<script type="text/javascript">'
              . 'window.location.href="'.$sUrl.'";'
              . '</script>'
              . '<noscript>'
              . '<meta http-equiv="refresh" content="0;url='.$sUrl.'" />'
              . '</noscript>';
             */
        }
        exit;
    }

}
