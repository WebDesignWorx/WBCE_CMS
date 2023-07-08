<?php

$oTwig->addFunction(new \Twig\TwigFunction("parse_simple_md_tags", 
    function ($str) {
        return parse_simple_md_tags($str);
    }
));

