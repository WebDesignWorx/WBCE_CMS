<?php
defined('WB_PATH') or exit('sorry, no sufficient privileges.');

/**
 * get Backend Theme File
 * get it from the DEFAULT_THEME or theme fallback
 */
if(function_exists('theme_file') == false){
    function theme_file($sFileLoc = '') {
        $sFileLoc = ltrim($sFileLoc, '/');
        $mRetVal = WB_URL.'/templates/theme_fallbacks/'.$sFileLoc;
        $sThemeLoc = THEME_PATH.'/'.$sFileLoc;        
        $sFallbackLoc = WB_PATH.'/templates/theme_fallbacks/'.$sFileLoc;
        if(file_exists($sThemeLoc)){
            $mRetVal = get_url_from_path($sThemeLoc);
        } elseif (file_exists($sFallbackLoc)){
            $mRetVal = get_url_from_path($sFallbackLoc);
        } 
        $sExt = '.'.pathinfo($sThemeLoc)['extension'];
        $sOverride = str_replace($sExt, '.override'.$sExt, $sThemeLoc);
        if (file_exists($sOverride)){
            $mRetVal = array($mRetVal);
            $mRetVal[] = get_url_from_path($sOverride);
            debug_dump($mRetVal);
        } 
        return $mRetVal;
    }
}

$oTwig->addFunction(new \Twig\TwigFunction("theme_file", 
    function ($sFileLoc = 'none') {
        return theme_file($sFileLoc);
   }
));