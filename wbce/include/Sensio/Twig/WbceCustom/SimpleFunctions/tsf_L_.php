<?php

$oTwig->addFunction( new \Twig\TwigFunction("L_",
    function ($sStr, ...$args){ 
        // use WBCE L_ function
        return L_($sStr, ...$args);         
    }
));