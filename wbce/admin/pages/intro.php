<?php

/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

// Include config file
require realpath('../../config.php');
require __DIR__ . '/functions/functions.backend_pages.php';

$admin = new Admin('Pages', 'pages_intro', false);
$oMsgBox = new MessageBox();

$sContent = '';
$sFile = WB_PATH . PAGES_DIRECTORY . '/intro' . PAGE_EXTENSION;
// should we save the contents?
if (isset($_POST['code'])) {
    $sContent = $admin->get_post('code');
    $sPos = isset($_POST['save']) ? "intro" : "index";
    $goTo = ADMIN_URL . "/pages/" . $sPos . ".php";

    if (file_put_contents($sFile, $sContent) === false) {        
        #$oMsgBox->error($MESSAGE['PAGES_NOT_SAVED']);
        $admin->print_header();
        $admin->messageBox($MESSAGE['PAGES_NOT_SAVED'], 'error', $goTo, 1);
    } else {
        change_mode($sFile);
        $oMsgBox->success($MESSAGE['PAGES_INTRO_SAVED']);
        #$admin->print_header();
        #$admin->messageBox($MESSAGE['PAGES_INTRO_SAVED'], 'success', $goTo, 1);            
    }
    if (!is_writable($sFile)) {
        $admin->print_header();
        $admin->messageBox($MESSAGE['PAGES_INTRO_NOT_WRITABLE'], 'error', $goTo, 1);
        $admin->print_footer();
    }
}

// get contents from file
if ($sContent == '') {
    if (is_file($sFile) && filesize($sFile) > 0){
        $sContent = file_get_contents($sFile);
    } else {
        $sContent = file_get_contents(ADMIN_PATH . '/pages/html.php');
    }
}

// initiate CodeMirror
registerCodeMirror('code', 'x-php');

$aToTwig = [ 
    'code'        => $sContent,
    'MESSAGE_BOX' => $oMsgBox->fetchDisplay()
];

$admin->print_header();
$admin->getThemeFile('pages_intro.twig', $aToTwig);
$admin->print_footer();
