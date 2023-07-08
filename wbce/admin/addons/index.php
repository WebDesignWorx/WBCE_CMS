<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// Include required files
require '../../config.php';

// Setup admin object, print header and check section permissions
$admin = new admin('Addons', 'addons', true, true);
$aToTwig = [
    'POSITION' => 'addons'
];
$admin->getThemeFile('addons.twig', $aToTwig);
$admin->print_footer();
