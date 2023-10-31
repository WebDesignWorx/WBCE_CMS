<?php

$oTwig->addFunction(new \Twig\TwigFunction("debug_dump", 
   function ($mVar = '', $sCaption = '', $bVarDump = false) use ($oTwig) {
       return debug_dump($mVar, $sCaption, $bVarDump);
   }
));

