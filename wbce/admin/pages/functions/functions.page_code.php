<?php
/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */
 
 /**
  * @brief return array of page_codes for use with mod_multilingual  
  * @return array 
  */
function page_code_list($iCrntPageID = NULL)
{
	$aRetList = array();
	$aOrigList = _page_code_list(0, $iCrntPageID);
	if(!empty($aOrigList)){
		$aTemp = array();
		foreach($aOrigList as $arr)	
			$aTemp = $arr;			
		$aIterated = new RecursiveIteratorIterator(new CustomIterator($aTemp));
		foreach ($aIterated as $leaf) 
			$aRetList[] = $leaf;
	}
	return $aRetList;
}

 /**
  * @brief return array of page_codes for use with the public page_code_list() function 
  *        This function is but a helper for the page_code_list() function
  * @param int parent page_id of this sub-tree 
  * @param int current page_id if PAGE_ID is set this will become the value later in the function 
  * @param bool 
  * @return mixed array or bool if empty
  */
function _page_code_list($iParent, $iCrntPageID = NULL, $bNext = false)
{
	global $admin, $database;
	$aList['children'] = array();
	$iCrntPageID = ($iCrntPageID == NULL && defined("PAGE_ID")) ? PAGE_ID : $iCrntPageID;
	$iCrntPageCode = $database->get_one("SELECT `page_code` FROM `{TP}pages` WHERE `page_id`=".$iCrntPageID);
	$aPageList = parentPageList(nestedPagesArray($iParent), $iCrntPageID, $bAllLevels = true);
	$list_next_level = true;
	foreach($aPageList as $p){
		$list_next_level = $p['page_id'];		
		if($p['language'] != DEFAULT_LANGUAGE) continue;
		
		if($iCrntPageCode === $p['page_id'])
			$sSelected = ' selected="selected" class="selected"';					
		#elseif($p['canDeleteAndModify'] != true)
		#	$sSelected = ' disabled="disabled" class="disabled"';					
		#elseif($iCrntPageCode !=0 && $iCrntPageCode == $p['page_code'])
		#	$sSelected = ' selected="selected" class="disabled"';
		else 
			$sSelected = '';
		
		$aList['children'][] = array(
			'value'      => $p['page_id'],
			'menu_title' => $p['space_trail'].$p['menu_title'],
			'icon'       => ($p['parent'] == 0) ? $p['language'] : 'none',
			'selected'   => $sSelected,					
		);
		unset($p);
	}
	if (is_numeric($list_next_level)){
		$aList['children'][] = _page_code_list($list_next_level, $iCrntPageID, true);
	}	
	
	return !empty($aList) ? $aList : false;
}

/**
 * extend PHPs RecursiveArrayIterator to fit our needs
 */

class CustomIterator extends RecursiveArrayIterator
{
    public function hasChildren() {
        return !empty($this->current()['children']);
    }
    
    public function getChildren() {
        $children = array_filter($this->current()['children'], function ($child) {
            return !isset($child['children']) || !empty($child['children']);
        });
        
        return new static($children);
    }
}