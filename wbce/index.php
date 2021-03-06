<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * Way Better Content Editing.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

$starttime = array_sum(explode(" ", microtime()));
 
defined('WB_FRONTEND') or define('WB_FRONTEND', true);

// Include config file
$sConfigFile = __DIR__ . '/config.php';
if (file_exists($sConfigFile)) require_once $sConfigFile;

// Check if the config file has been set-up
if (!defined('TABLE_PREFIX')) {
    
    // Remark:  HTTP/1.1 requires a qualified URI incl. the scheme, name
    // of the host and absolute path as the argument of location. Some, but
    // not all clients will accept relative URIs also.     
    $sUri        = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $sScheme     = (isset($_SERVER['HTTPS']) ? 'https' : 'http');
    $sTargetUrl = $sScheme . '://' . $_SERVER['HTTP_HOST'] . $sUri . '/install/index.php';
    $sResponse  = $_SERVER['SERVER_PROTOCOL'] . ' 307 Temporary Redirect';
    header($sResponse);
    header('Location: ' . $sTargetUrl); exit; 
}

// Create new Frontend object.
$wb = new Frontend();

// Figure out which page to display. Stop processing if intro page was shown.
$wb->page_select() or die();

// Collect info about the currently viewed page and check permissions.
$wb->get_page_details();

// Collect general website settings.
$wb->get_website_settings();

// OPF hook, Load OutputFilter functions, needed at least for older versions of OpF.
$sOpfFunctions = WB_PATH .'/modules/outputfilter_dashboard/functions.php';
if(file_exists($sOpfFunctions)) {
    include $sOpfFunctions;
    // Use 'cache' instead of 'nocache' to enable page-cache.
    // Do not use 'cache' in case you use dynamic contents (e.g. snippets)!
    opf_controller('init', 'nocache');
}

// Load frontend functions
require WB_PATH . '/framework/frontend.functions.php';

// Get template include file if exits
$sTemplateFunctions = WB_PATH . '/templates/' . TEMPLATE . '/include.php';
if (file_exists($sTemplateFunctions)) require $sTemplateFunctions;

// Fetch output generated by Snippets and core for example 
$sPreOutput = ob_get_clean();   

//Get pagecontent in buffer for Droplets and/or Filter operations
ob_start();
require WB_PATH . '/templates/' . TEMPLATE . '/index.php';

// Fetch the content for applying filters to it
$sContent = ob_get_clean();

// Append the PRe output  so filter can handle it    
$sContent = $sContent.$sPreOutput;   

// Load OPF Dashboard OutputFilter functions
$sOpfFile = WB_PATH.'/modules/outputfilter_dashboard/functions.php';
if (is_readable($sOpfFile)) {
    require_once($sOpfFile);
    // Now apply the OutputFilters to the whole content
    if (function_exists('opf_apply_filters')) {
        $sContent = opf_controller('page', $sContent);
    }
}

// Process $wb->DirectOutput (the variable) if set. 
// This ends the script here and regular content is not put out.
// But still all modules and template scripts are finished at this point.  
$wb->DirectOutput();


// Now, send complete page content to the browser
echo $sContent;
exit;
