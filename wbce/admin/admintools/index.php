<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

require '../../config.php';

$admin = new Admin('admintools', 'admintools'); 
$aAdminTools = array();


$aIconCfg = getAddonMonitorIniCfg()['general'];
$sIcon = "fa-wrench"; 
foreach($admin->getAdminToolsArray() as $iID=>$tool){
    $aAdminTools[$iID]['dir']         = $tool['dir'];
    $aAdminTools[$iID]['name']        = $tool['name'];
    $aAdminTools[$iID]['description'] = $admin->get_module_description($tool['dir']);
    $aAdminTools[$iID]['url']         = ADMIN_URL . '/admintools/tool.php?tool='.$tool['dir'];
    // get tool icon
    if($data = @file_get_contents(WB_PATH .'/modules/' .$tool['dir'] .'/info.php')){
        if(!false == ($tmp = get_variable_content('module_icon', $data, true, false))){
            $sIcon = $tmp;
        }
    }
    
    $aAdminTools[$iID]['fa_icon'] = '';
    $sPNG = '/modules/'.$tool['dir'].'/tool_icon';
    if($aIconCfg['use_PNG_icons'] == 1 && is_readable(WB_PATH.$sPNG.'.png')){
        $aAdminTools[$iID]['img'] = WB_URL.$sPNG.'.png';
    } elseif($aIconCfg['use_SVG_icons'] && is_readable(WB_PATH.$sPNG.'.svg')){
        $aAdminTools[$iID]['img'] = WB_URL.$sPNG.'.svg';
    }   
    
    if ( $checkSVG = decodeBase64SVG($sIcon) ) {
        $aAdminTools[$iID]['svg_icon'] = $checkSVG;
    } else {        
        $aAdminTools[$iID]['fa_icon'] = 'fa '.$sIcon;
    }
}

$aToTwig = array();
$aToTwig['ADMIN_TOOLS'] = $aAdminTools;
$admin->getThemeFile('admintools.twig', $aToTwig);
$admin->print_footer();

function getAddonMonitorIniCfg() {
    $aRetVal = array();
    $sIniFile = ADMIN_PATH . '/addons/AddonMonitorCfg.ini.php';
    if (is_readable($sIniFile)) {
        $aRetVal = parse_ini_file($sIniFile, true);
        if (is_writable($sIniFile)) {
            $aRetVal['cfg_writeable'] = true;
        }
    } else {
        $aRetVal['general']['use_PNG_icons'] = false;
        $aRetVal['general']['use_SVG_icons'] = false;
    }
    return $aRetVal;
}

/**
 * Decode a base64-encoded SVG code.
 * Will decode the encoded string and return a pattern like:
 * <svg xmlns="http://www.w3.org/2000/svg" .... </svg>
 *
 * @param  string $encodedString The base64-encoded SVG string.
 * @return string|false The decoded SVG string on success, or false on failure.
 */
function decodeBase64SVG($encodedString) {
    // Remove data URI scheme and base64 encoding
    $data = substr($encodedString, strpos($encodedString, ',') + 1);
    $sDecodedSVG = base64_decode($data);

    // Check if decoding was successful
    if ($sDecodedSVG != false && strpos($sDecodedSVG, '<svg') === 0) {
        return $sDecodedSVG;
    } else {
        return false;
    }
}
