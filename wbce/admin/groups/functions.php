<?php


// Get existing groups (except for admins) and get amount of users in that group
function get_groups_w_userscount($bAllData = false){
    global $database, $admin;
    $aGroups = array();
    // make groups data available for admins with groups permission only
    if($admin->get_permission('groups')){
        $sScope = ($bAllData == false) ? 'g.group_id, g.name, g.description,' : 'g.*, ';
        if($admin->get_permission('users')){
            // count only visible if admin has users permission
            $sScope .= ' CONCAT(COUNT(u.group_id)) AS usercount';
        }        
        $sWhere =" WHERE g.group_id != '1'";
        $sSql = "SELECT  
                {$sScope}
                FROM `{TP}groups` AS g LEFT JOIN `{TP}users` AS u
                ON (g.group_id = u.group_id
                    OR FIND_IN_SET(g.group_id, u.groups_id) > '0')
                {$sWhere}
                GROUP BY g.group_id
                ORDER BY g.name";
        $rRecord = $database->query($sSql);
        while($rec = $rRecord->fetchRow(MYSQLI_ASSOC)) {
            $aGroups[$rec['group_id']] = $rec;
            $aGroups[$rec['group_id']]['IDKEY'] = $admin->getIDKEY($rec['group_id']);
        }
    }
    return $aGroups;
}


/**
 * 
 * Brief: get the name of group by the use of group_id column
 * 
 * @param  int      $iGroupID
 * @return string
 */
function get_groupname_by_id($iGroupID = 0){
    $sGroupName = '';
    if(is_numeric($iGroupID ) && $iGroupID > 0){
        $sSql = 'SELECT `name` FROM `{TP}groups` WHERE `group_id` = '.$iGroupID;
        $sGroupName = $GLOBALS['database']->get_one($sSql);
    }
    return $sGroupName;
}
/**
 * 
 * Brief: get the description of group by the use of group_id column
 * 
 * @param  int      $iGroupID
 * @return string
 */
function get_groupdescription_by_id($iGroupID = 0){
    $sGroupName = '';
    if(is_numeric($iGroupID ) && $iGroupID > 0){
        $sSql = 'SELECT `description` FROM `{TP}groups` WHERE `group_id` = '.$iGroupID;
        $sGroupName = $GLOBALS['database']->get_one($sSql);
    }
    return $sGroupName;
}


// page, tool, setting, template, theme
function get_addon_list($sFuction = 'page', $iGroupID = 0){
    global $database;
    $aAddons = array();     
    $aGroupAssignedAddons = array();
    $aTemplates = array('template', 'theme'); 
    $aModules = array('page', 'tool', 'setting');
    $sType = (in_array($sFuction, $aTemplates)) ? 'template' : 'module';
    $sType = (in_array($sFuction, $aModules)) ? 'module' : 'template';
    $sColumn = $sType.'_permissions';
    if($iGroupID != 0){
        $sTmpList = $database->get_one("SELECT `".$sColumn."` FROM `{TP}groups` WHERE `group_id` = ".$iGroupID);
        $aGroupAssignedAddons = explode(',', trim($sTmpList));
        
        
    } 
    $sSql = "SELECT `addon_id`, `name`, `directory` FROM `{TP}addons` WHERE `type` = '%s' AND `function` LIKE '%%%s%%' ORDER BY name";
    $rAddons = $database->query(sprintf($sSql, $sType, $sFuction));
    if($rAddons->numRows() > 0) {
        
        while($rec = $rAddons->fetchRow(MYSQLI_ASSOC)) {
            $aAddons[$rec['addon_id']] = $rec;
            
            $sIdentifier = $rec['directory'];
            // special treatment for tool permissions
            // we append the string '_tool' to $sIdentifier
            if($sFuction == 'tool'){
               $sIdentifier .= '_tool';
            }        
            if(in_array($sIdentifier, $aGroupAssignedAddons) == true){
                $aAddons[$rec['addon_id']]['checked'] = ' checked';
            }
        }
    }
    return $aAddons;
}

/**
 * 
 * Brief: this is a super simple function to retrieve an array 
 * of all backend areas and group permissions assigned to those
 * 
 * @global object $admin
 * @param  int    $iGroupID
 * @return array
 */


function group_access_permissions($iGroupID = 0){
    
    // PAGES
    $aPerms['pages']['title'] = 'MENU:PAGES';    
    $aPerms['pages']['child']['pages_view']['title']     = 'TEXT:VIEW';
    $aPerms['pages']['child']['pages_add']['title']      = 'TEXT:ADD';
    $aPerms['pages']['child']['pages_add_l0']['title']   = 'TEXT:ADD'; // 'TEXT:ADD_LEVEL_NULL' should go into language file
    $aPerms['pages']['child']['pages_settings']['title'] = 'TEXT:MODIFY_SETTINGS';
    $aPerms['pages']['child']['pages_modify']['title']   = 'TEXT:MODIFY_CONTENT';
    $aPerms['pages']['child']['pages_intro']['title']    = 'HEADING:MODIFY_INTRO_PAGE';
    $aPerms['pages']['child']['pages_delete']['title']   = 'TEXT:DELETE';
    
    // MEDIA    
    $aPerms['media']['title'] = 'MENU:MEDIA';
    $aPerms['media']['child']['media_view']['title']     = 'TEXT:VIEW';
    $aPerms['media']['child']['media_upload']['title']   = 'TEXT:UPLOAD_FILES';
    $aPerms['media']['child']['media_rename']['title']   = 'TEXT:RENAME';
    $aPerms['media']['child']['media_delete']['title']   = 'TEXT:DELETE';
    $aPerms['media']['child']['media_create']['title']   = 'TEXT:CREATE_FOLDER';
    
    // MODULES
    $aPerms['modules']['title'] = 'MENU:MODULES';
    $aPerms['modules']['child']['modules_view']['title']      = 'TEXT:VIEW';
    $aPerms['modules']['child']['modules_install']['title']   = 'TEXT:INSTALL';
    $aPerms['modules']['child']['modules_uninstall']['title'] = 'TEXT:UNINSTALL';
    
    // TEMPLATES    
    $aPerms['templates']['title'] = 'MENU:TEMPLATES';
    $aPerms['templates']['child']['templates_view']['title']      = 'TEXT:VIEW';
    $aPerms['templates']['child']['templates_install']['title']   = 'TEXT:INSTALL';
    $aPerms['templates']['child']['templates_uninstall']['title'] = 'TEXT:UNINSTALL';
    
    // LANGUAGES
    $aPerms['languages']['title'] = 'MENU:LANGUAGES';
    $aPerms['languages']['child']['languages_view']['title']      = 'TEXT:VIEW';
    $aPerms['languages']['child']['languages_install']['title']   = 'TEXT:INSTALL';
    $aPerms['languages']['child']['languages_uninstall']['title'] = 'TEXT:UNINSTALL';
    
    // SETTINGS
    $aPerms['settings']['title'] = 'MENU:SETTINGS';
    $aPerms['settings']['child']['settings_basic']['title']       = 'TEXT:BASIC';
    $aPerms['settings']['child']['settings_advanced']['title']    = 'TEXT:ADVANCED';
    
    // ADMINTOOLS
    $aPerms['admintools']['title'] = 'MENU:ADMINTOOLS';
    $aPerms['admintools']['child']['admintools_settings']['title'] = 'TEXT:MODIFY_SETTINGS';
    
    // USERS
    $aPerms['users']['title'] = 'MENU:USERS';    
    $aPerms['users']['child']['users_view']['title']   = 'TEXT:VIEW';
    $aPerms['users']['child']['users_add']['title']    = 'TEXT:ADD';
    $aPerms['users']['child']['users_modify']['title'] = 'TEXT:MODIFY';
    $aPerms['users']['child']['users_delete']['title'] = 'TEXT:DELETE';
    
    // GROUPS
    $aPerms['groups']['title'] ='MENU:GROUPS';
    $aPerms['groups']['child']['groups_view']['title']   = 'TEXT:VIEW';
    $aPerms['groups']['child']['groups_add']['title']    = 'TEXT:ADD';
    $aPerms['groups']['child']['groups_modify']['title'] = 'TEXT:MODIFY';
    $aPerms['groups']['child']['groups_delete']['title'] = 'TEXT:DELETE';
    
    /////////////////////////////////
    // attach permissions to array
    foreach($aPerms as $area=>$data){
        $aPerms[$area]['checked'] = group_has_permission($iGroupID, $area);
        foreach($data['child'] as $perm=>$s){
            if(group_has_permission($iGroupID, $perm) != ''){
                $aPerms[$area]['child'][$perm]['checked'] = ' checked';
            }
        }  
    }   
    
    return $aPerms;
}
/**
 * 
 * @global object   $database
 * @param  int      $iGroupID
 * @param  string   $sPermName  specific permission we are looking for e.g. 'pages_add'
 * @param  string   $sType      type of permission: system_permissions, template_permissions, module_permissions
 * @return string
 */
// Return a system permission
function group_has_permission($iGroupID, $sPermName, $sType = 'system_permissions') {
       
    $sRetVal = '';
    if($iGroupID == 0){ 
        $aAccPerms = get_group_defaults();  
    }else{			
        global $database;
        $sAccPerms = $database->get_one("SELECT `".$sType."` FROM {TP}groups WHERE `group_id` = '".$iGroupID."'");
                $aAccPerms = explode(',', $sAccPerms);  
        }
        if(is_array($aAccPerms)){
            if (is_numeric(array_search($sPermName, $aAccPerms))) {
                $sRetVal = ' checked';
            } else {
                $sRetVal = '';
            }
            unset($aAccPerms);
        }
    return $sRetVal;
} 

/**
 * 
 * Brief: get default values for groups from a INI File
 * 
 * @param  string $sType
 * @return array
 */
function get_group_defaults($sType = 'system_permissions'){
    $aData = array();
    $sIniFile = __DIR__.'/add_new_group_defaults.ini.php';
    if(is_readable($sIniFile)){
        $aData =  parse_ini_file($sIniFile);
        $aData = explode(',', str_replace(' ', '', ($aData[$sType])));		
    }	
    return $aData;
}  