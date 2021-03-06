<?php
defined('WB_PATH') or exit('sorry, no sufficient privileges.');

/**
 * insertJsFile  // Twig adaptation of the Insert class method
 */
$oTwig->addFunction(new Twig_SimpleFunction("insertJsFile", 
    function ($uFileLoc = '', $sDomPos = 'BODY BTM-', $sID = '') {
        if(!is_array($uFileLoc)){    
           if ($uFileLoc != '') {
               I::insertJsFile($uFileLoc, $sDomPos, $sID);
           } else {
               return;
           }
       } else {
           foreach ($uFileLoc as $sLoc) {
               I::insertJsFile($sLoc, $sDomPos, $sID);
           }
           return;
       }
   }
));

/**
 * insertCssFile  // Twig adaptation of the Insert class method
 */
$oTwig->addFunction(new Twig_SimpleFunction("insertCssFile", 
    function ($uFileLoc = '', $sDomPos = 'HEAD BTM-', $sID = '') {
        if(!is_array($uFileLoc)){        
            if ($uFileLoc != '') {
                I::insertCssFile($uFileLoc, $sDomPos, $sID);
            } else {
                return;
            }
        }else{
            foreach ($uFileLoc as $sLoc) {
                I::insertCssFile($sLoc, $sDomPos, $sID);
            }
        }
        return;
    }
));

// getIDKEY  // use IDKEYs in Twig Templates directly. No need to hand them over anymore.
$oTwig->addFunction(new Twig_SimpleFunction("getIDKEY", 
    function ($uID) {        
        $oEngine = isset($GLOBALS['wb']) ? $GLOBALS['wb'] : $GLOBALS['admin']; 
        return $oEngine->getIDKEY($uID);
    }
));
    
/**
 * 	processTranslation / L_
 * 	---------------------------------------------------------------------------
 *  This function allows you to use any language string that is active on the 
 *  page you're templating. No need to hand over long lists of lang strings
 *  to the templates anymore as it was with the previously used Template Engine
 *
 * Correct format would be:
 *     L_('ARRAY:KEY'); or
 *     L_('{ARRAY:KEY}'); 
 * example:
 *     L_('TEXT:ACTIVE');
 *     L_('{TEXT:ACTIVE}');
 *
 * 	@author Christian M. Stefan <stefek@designthings.de>	
 * 	@param  string	
 * 	@param  bool	
 * 	@return string Translated String
 * */
$oTwig->addFunction( new Twig_SimpleFunction("L_",
    function ($sStr){
        $sRetVal = '';
        if(strpos($sStr, ':') !== false){
            $sStr = str_replace(' ', '', $sStr);
            if(strpos($sStr, '{') !== false){
                preg_match_all('/{(.*?)}/', $sStr, $sOut);
                $tmp = explode(':',$sOut[1][0]);
            }else{
                $tmp = explode(':',$sStr);
            }
            $arr = $tmp[0];
            $key = $tmp[1];
            if(is_array($GLOBALS[$arr]) && array_key_exists($key, $GLOBALS[$arr])){
                $sRetVal = $GLOBALS[$arr][$key];
            }else{
                $bShowMissing = (defined('TWIG_SHOW_MISSING_LANG_STRINGS') && TWIG_SHOW_MISSING_LANG_STRINGS == true)
                        ? true 
                        : false;
                if($bShowMissing){
                    $sRetVal = "<span style='color:purple'>";
                    $sRetVal .= (is_array($GLOBALS[$arr]) == false) ? 'Array '.$arr.' does not exist.<br>' : '';
                    $sRetVal .= "<b>Missing Translation:</b> <input style=\"width:450px\" type=\"text\" value=\"$".$arr."['".$key."']\"></span>";
                }else{
                    $key = str_replace('_', ' ', $key).'.';
                    $sRetVal = $key;
                }
            }
        }else{
            $sRetVal = $sStr;
        }
        return $sRetVal;
    }
));
