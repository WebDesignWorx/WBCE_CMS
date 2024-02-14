<?php
/**
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

class PageSettings {
	
	protected $_oApp     = null;
	protected $_oDb      = null;
	protected $_oMsgBox  = null;
	public    $settings  = null;
	public    $iPageID   = 0;	
	public    $oPage     = null;
	public    $aPageDetails = null;
	public    $sTemplate = '';

	/**
	 * constructor used to import some application constants and objects
	 */	
	public function __construct($iPageID = 0) 
	{
		// import global vars and objects
		$this->iPageID       = $iPageID;
		$this->_oDb          = $GLOBALS['database'];		
		$this->_oApp         = isset($GLOBALS['admin']) ? $GLOBALS['admin'] : $GLOBALS['wb'];
		$this->_oMsgBox      = new MessageBox(); 
		$this->aPageDetails  = $this->_oApp->get_page_details($this->iPageID); 
		$this->sTemplate     = $this->getTemplateInUse();
                $this->settings      = $this->getPageSettings();
	}
	
	/**
	 * brief: get the directory name of the Template in use on this page
	 * @return string 
	 */
	public function getTemplateInUse(){      
                $sTemplate = '';
                if(isset($this->aPageDetails['template']))
                    $sTemplate = $this->aPageDetails['template'];
		if($sTemplate == '')
			$sTemplate = $this->_oDb->get_one("SELECT `value` FROM `{TP}settings` WHERE `name` = 'default_template'");
		return $sTemplate;
	}
	
	
	/**
	 * @return object
	 */
	public function getPageSettings(){
            $aSettings = array();
            if(isset($this->aPageDetails)){
		$aSettings = (array) $this->aPageDetails;
		$aSettings['languages'] = $this->_languagesArray();
		$aSettings['templates'] = $this->_templatesArray();
		$aSettings['menus']     = $this->_menusArray();
		$aSettings['file_name'] = $this->_fileName();
            }
            return (object) $aSettings;
	}
		
	/**
	 * @return array
	 */
	protected function _languagesArray(){
		$aLangs = array();
		$sSql = "SELECT `directory` as `lc`, `name` FROM `{TP}addons` WHERE `type` = 'language' ORDER BY `name`";
		if($oRes = $this->_oDb->query($sSql)){   
			while($row = $oRes->fetchRow(MYSQLI_ASSOC)) {
				$aLangs[$row['lc']]['lc']      = $row['lc'];
				$aLangs[$row['lc']]['name']    = $row['name'];
                                $aLangs[$row['lc']]['checked'] = ($this->aPageDetails['language'] == $row['lc'] ? 1 : 0);
			}
		}
		return $aLangs;
	}
	
	/**
	 * @return array
	 */
	protected function _templatesArray(){
                if(defined('WB_FRONTEND')) return;
		$aTmp = array();  
		$sSql = "SELECT `name`, `directory` FROM `{TP}addons` 
				  WHERE `type` = 'template' AND `function` = 'template'
				  ORDER BY `name`";
		if(($rTemplates = $this->_oDb->query($sSql))) {
			while($aRec = $rTemplates->fetchRow(MYSQLI_ASSOC)){
				$sTplFile = WB_PATH.'/templates/'.$aRec['directory'].'/info.php';
				if (is_readable($sTplFile)) 
					$aTmp[] = $aRec;         
			}
		}	  	
		$aTemplates = array();
		if((sizeof($aTmp) > 0)) {
			$i = 1;
			foreach($aTmp as $aTpl) {
				// Check if the user has perms to use this template
				if($aTpl['directory'] == $this->aPageDetails['template'] OR
				   $this->_oApp->get_permission($aTpl['directory'], 'template'))
				{
					$aTemplates[$i]['dir']     = $aTpl['directory'];
					$aTemplates[$i]['name']    = $aTpl['name'];
					$aTemplates[$i]['checked'] = false;
					if($aTpl['directory'] == $this->aPageDetails['template']) {
						$aTemplates[$i]['checked'] = true;
					} 
				}
				$i++;
			}
		}
		return $aTemplates;
	}
	
	/**
	 * @return array
	 */	
	protected function _menusArray(){
		global $TEXT;
		$aMenu = array();
		$sTplFile = WB_PATH.'/templates/'.$this->sTemplate.'/info.php';
		if (is_file($sTplFile)) {
			include $sTplFile;	
			if(isset($menu)){
				foreach($menu as $key => $sMenuName) {
					$aMenu[$key]['name']     = '['.$key.'] '.(($sMenuName == '') ? $TEXT['DEFAULT'] : $sMenuName );
					$aMenu[$key]['value']    = $key;
                                        if(isset($this->aPageDetails['menu'])){
                                            $aMenu[$key]['selected'] = ($this->aPageDetails['menu'] == $key) ? true : false;
                                        }
				}
			}
		}		
		return $aMenu;
	}	
	
	/**
	 * @return string
	 */	
	protected function _fileName(){
                if(!isset($this->aPageDetails['link'])){
                    return;
                }
		$sRetVal = $sLink = $this->aPageDetails['link'];
		if(!preg_match ("/^\[wblink\d+\]$/", $sLink) and !preg_match ("/\:\/\//", $sLink)) {
			// get the last part of the link, everything behind last / (slash)
			$pos = strrpos($sLink, "/"); 
			$len = strlen($sLink);
			$cut = $pos - $len + 1;
			$sRetVal = substr($sLink, $cut);
		} 
		return $sRetVal;
	}
	
	public function hasPrivileges(){ 
		$bRetVal = true;
		$groups = $this->aPageDetails['admin_groups'];
		$users  = $this->aPageDetails['admin_users'];
		if ( 
			!$this->_oApp->ami_group_member($groups) 
			&& !$this->_oApp->is_group_match($this->_oApp->get_user_id(), $users)
			) {		
			$bRetVal = false;
		}
		return $bRetVal;
	}
}