<?php

if(!defined('WB_PATH')) { exit('Direct access to this file is not allowed'); }



// it's only advanced settings since now and no distinction anymore for basic and advanced
// have full control over group settings without unneeded confusion 
// true, it's a lot of settings but a admin should  take the time to get familiar with this area
    
// Pages
$aSys['pages'] = '';
$aSys['pages_view']     = $admin->get_post('pages_view');
$aSys['pages_add']      = $admin->get_post('pages_add');

if($admin->get_post('pages_add') != 1 AND $admin->get_post('pages_add_l0') == 1) {
    $aSys['pages_add'] = $admin->get_post('pages_add_l0');
}

$aSys['pages_add_l0']   = $admin->get_post('pages_add_l0');
$aSys['pages_settings'] = $admin->get_post('pages_settings');
$aSys['pages_modify']   = $admin->get_post('pages_modify');
$aSys['pages_intro']    = $admin->get_post('pages_intro');
$aSys['pages_delete']   = $admin->get_post('pages_delete');

if($aSys['pages_view'] == 1 || $aSys['pages_add'] == 1 
    || $aSys['pages_settings'] == 1 || $aSys['pages_modify'] == 1 
    || $aSys['pages_intro'] == 1 || $aSys['pages_delete'] == 1) {
    $aSys['pages'] = 1;
}

// Media
$aSys['media_view']   = $admin->get_post('media_view');
$aSys['media_upload'] = $admin->get_post('media_upload');
$aSys['media_rename'] = $admin->get_post('media_rename');
$aSys['media_delete'] = $admin->get_post('media_delete');
$aSys['media_create'] = $admin->get_post('media_create');

$aSys['media'] = '';
if($aSys['media_view'] == 1 || $aSys['media_upload'] == 1 
    || $aSys['media_rename'] == 1 || $aSys['media_delete'] == 1 
    || $aSys['media_create'] == 1) {
    $aSys['media'] = 1;
} 

// Add-ons
// ==========
// Modules
$aSys['modules'] = '';
$aSys['modules_view']      = $admin->get_post('modules_view');
$aSys['modules_install']   = $admin->get_post('modules_install');
$aSys['modules_uninstall'] = $admin->get_post('modules_uninstall');

if($aSys['modules_view'] == 1 || $aSys['modules_install'] == 1 
    || $aSys['modules_uninstall'] == 1) {
    $aSys['modules'] = 1;
} 


// Templates
$aSys['templates'] = '';
$aSys['templates_view']      = $admin->get_post('templates_view');
$aSys['templates_install']   = $admin->get_post('templates_install');
$aSys['templates_uninstall'] = $admin->get_post('templates_uninstall');

if($aSys['templates_view'] == 1 || $aSys['templates_install'] == 1 
    || $aSys['templates_uninstall'] == 1) {
    $aSys['templates'] = 1;
} 


// Languages
$aSys['languages'] = '';
$aSys['languages_view']      = $admin->get_post('languages_view');
$aSys['languages_install']   = $admin->get_post('languages_install');
$aSys['languages_uninstall'] = $admin->get_post('languages_uninstall');

if($aSys['languages_install'] == 1 || $aSys['languages_uninstall'] == 1) {
    $aSys['languages'] = 1;
} 

// Admintools
$aSys['admintools'] = $admin->get_post('admintools');
$aSys['admintools_settings'] = $admin->get_post('admintools_settings');

if($aSys['admintools']  == '' && $aSys['admintools_settings'] == 1) {
    $aSys['admintools'] = 1;
}

// preferences
$aSys['preferences'] = '';
$aSys['preferences_settings'] = $admin->get_post('preferences_settings');

if($aSys['preferences_settings'] == 1) {
    $aSys['preferences'] = 1;
}


$aSys['addons'] = '';	
if($aSys['modules'] == 1 || $aSys['templates'] == 1 || $aSys['languages'] == 1) {
    $aSys['addons'] = 1;
} 

// Settings
$aSys['settings'] = '';
$aSys['settings_basic']    = $admin->get_post('settings_basic');
$aSys['settings_advanced'] = $admin->get_post('settings_advanced');

if($aSys['settings_basic'] == 1 || $aSys['settings_advanced'] == 1) {
    $aSys['settings'] = 1;
} 

// Access
// ==========       
// Users
$aSys['users'] = '';
$aSys['users_view']   = $admin->get_post('users_view');
$aSys['users_add']    = $admin->get_post('users_add');
$aSys['users_modify'] = $admin->get_post('users_modify');
$aSys['users_delete'] = $admin->get_post('users_delete');

if($aSys['users_view'] == 1 || $aSys['users_add'] == 1 
    || $aSys['users_modify'] == 1 || $aSys['users_delete'] == 1) {
    $aSys['users'] = 1;
} 

// Groups
$aSys['groups'] = '';
$aSys['groups_view']   = $admin->get_post('groups_view');
$aSys['groups_add']    = $admin->get_post('groups_add');
$aSys['groups_modify'] = $admin->get_post('groups_modify');
$aSys['groups_delete'] = $admin->get_post('groups_delete');

if($aSys['groups_view'] == 1 || $aSys['groups_add'] == 1 
    || $aSys['groups_modify'] == 1 || $aSys['groups_delete'] == 1) {
    $aSys['groups'] = 1;
} 

$aSys['access'] = '';
if($aSys['users'] == 1 || $aSys['groups'] == 1) {
    $aSys['access'] = 1;
} 

// Implode system permissions
$aTemp = array();
foreach($aSys as $key => $val) { 
    if($val == true) { 
        $aTemp[] = $key;
    }
}    
$system_permissions = implode(',', $aTemp);


// Get module permissions && template permissions
$aRunAddons = array('module', 'template');
foreach ($aRunAddons as $sType) {
    $sColumn = $sType . '_permissions'; // $module_permissions or $template_permissions
    $aPerms = (array) $admin->get_post($sColumn); // Ensure $aPerms is an array
    
    $sDirPrefix = WB_PATH . '/' . $sType . 's/';

    $aAddons = [];
    foreach ($aPerms as $sAddonDir) {
        $sToolDir = str_replace('_tool', '', $sAddonDir); // Rename for AdminTools

        if (is_readable($sDirPrefix . $sAddonDir . '/info.php') ||
            is_readable($sDirPrefix . $sToolDir . '/info.php')
        ) {
            $aAddons[] = $sAddonDir;
        }
    }

    $$sColumn = implode(',', $aAddons); // Get $module_permissions or $template_permissions string
}