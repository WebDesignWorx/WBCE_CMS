<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright       WBCE Project (2015-)
 * @category        opffilter
 * @package         OPF Remove System PH
 * @version         1.1.7
 * @authors         Martin Hecht (mrbaseman)
 * @link            https://forum.wbce.org/viewtopic.php?id=176
 * @license         GNU GPL2 (or any later version)
 * @platform        WBCE 1.3.x
 * @requirements    OutputFilter Dashboard 1.5.x and PHP 5.4 or higher
 *
 **/


/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(!defined('WB_PATH')) {
        // Stop this file being access directly
        if(!headers_sent()) header("Location: ../index.php",TRUE,301);
        die('<head><title>Access denied</title></head><body><h2 style="color:red;margin:3em auto;text-align:center;">Cannot access this file directly</h2></body></html>');
}
/* -------------------------------------------------------- */

function opff_mod_opf_remove_system_ph (&$content, $page_id, $section_id, $module, $wb) {
    if(!class_exists('Settings')
        || (Settings::Get('opf_remove_system_ph', true) && ($page_id != 'backend'))
        || (Settings::Get('opf_remove_system_ph'.'_be', true) && ($page_id == 'backend'))){

        // Replacements array
        $arr = [
            // Matche the <!--(PH) ... --> placeholders and replaces with ""
            "/<!--\(PH\).*?-->/s" => "",    
            // Matches excess new lines and replaces with a single newline character
            "/\n\s*\n+/s" => "\n"           
        ];
        $content = preg_replace(array_keys($arr), array_values($arr), $content);
    }
    return(TRUE);
}
