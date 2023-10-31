<?php

/**
 * function called for in admin/groups/index.php
 */
$oTwig->addFunction( new \Twig\TwigFunction("get_group_permissions", 
	function ($iGroupID = 0) {
		return group_access_permissions($iGroupID);
	}
));