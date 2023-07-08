<?php
/**
 *
 *
 *
 */

require '../../config.php';

$oMsgBox = new MessageBox();

$aSettings = array(
    'home_folders', 
    'frontend_login', 
    'frontend_signup'
);
$bShowSettings = false;
if(isset($_POST['save_settings'])){
    $admin     = new Admin('Settings', 'settings_advanced', false);
    $sRedirect = ADMIN_URL.'/access';    
    // Create a javascript back link
    if (!$admin->checkFTAN()) {
        $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS'], $sRedirect);
        exit();
    }
    foreach($aSettings as $key){
        Settings::Set($key, $admin->get_post($key));
    } 
    $bShowSettings = true; // check settings to be shown after save
    $oMsgBox->success($MESSAGE['RECORD_MODIFIED_SAVED']);
}

require __DIR__.'/functions.php';

$cfg = array();
foreach($aSettings as $key){
    $cfg[$key] = Settings::Get($key);
}
$sPos = 'access';
$admin = new Admin('Access', $sPos);

$aToTwig = [   
    'MESSAGE_BOX'   => $oMsgBox->fetchDisplay(),
    'POSITION'      => $sPos,
    'TABS'          => renderAddonsTabs($sPos), 
    'cfg'           => $cfg,
    'SIGNUP_GROUPS' => $database->get_array(
        "SELECT `name`, `group_id` as `id` FROM `{TP}groups` WHERE `group_id` <> 1"
    ),
    'show_settings' => $bShowSettings
];

    
$admin->getThemeFile('access.twig', $aToTwig);
$admin->print_footer();