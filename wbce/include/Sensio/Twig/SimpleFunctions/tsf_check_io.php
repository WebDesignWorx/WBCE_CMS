<?php

/**
 * Simple Function to assign selected="selected" to radio buttons
 * in templates
 * This function is only meant to be used with io states 1/0 active/inactive
 *
 * param string $sSetting  the Setting from e.g. the database
 * param string $iState    (1|0) you ask for the "on" or the "off" state?
 *
 */

$oTwig->addFunction( new \Twig\TwigFunction("check_io", 
    function ($sSetting, $iState) {
        $sRetVal = '';
        if (in_array($sSetting, array('1', 'true', 'btrueb'))){
            if ($iState == 1){
                $sRetVal = ' checked="checked"';
            }
        } elseif (in_array($sSetting, array('0', 'false', 'bfalseb'))){
            if ($iState == 0){
                $sRetVal = ' checked="checked"';
            }
        } else {
            $sRetVal = ' data-check-io="unknown parameters"';
        }
        return $sRetVal;
    }
));

$oTwig->addFunction( new \Twig\TwigFunction("is_int", 
    function ($var) {        
        return is_int($var);
    }
));

