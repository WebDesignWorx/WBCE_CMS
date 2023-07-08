<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * Way Better Content Editing.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// Print admin header
require('../../config.php');

// suppress to print the header, so no new FTAN will be set
$admin = new Admin('Access', 'users_add', false);

// Create a javascript back link
$js_back = ADMIN_URL.'/users';

if( !$admin->checkFTAN() ) {
    $admin->print_header();
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], $js_back);
    $admin->print_footer();
}

$aErrors = array();

// Get details entered
$groups_id          = (isset($_POST['groups'])) ? implode(",", $admin->add_slashes($_POST['groups'])) : ''; //should check permissions
$groups_id          = trim($groups_id, ','); // there will be an additional ',' when "Please Choose" was selected, too
$username_fieldname = $admin->get_post_escaped('username_fieldname');
$username           = strtolower($admin->get_post_escaped($username_fieldname));
$password           = $admin->get_post('password');
$password2          = $admin->get_post('password2');
$display_name       = $admin->get_post_escaped('display_name');
$email              = $admin->get_post_escaped('email');

// Check values
if($groups_id == '') {
    $aErrors[] = '[1] '.$MESSAGE['USERS_NO_GROUP'];
}
if(!preg_match('/^[a-z]{1}[a-z0-9_-]{2,}$/i', $username)) {
    $aErrors[] = '[2] '.$MESSAGE['USERS_NAME_INVALID_CHARS'].' / '.
                      $MESSAGE['USERS_USERNAME_TOO_SHORT'];
}

if(strlen($password) < 2) {
    $aErrors[] = '[3] '.$MESSAGE['USERS_PASSWORD_TOO_SHORT'];
}

if($password != $password2) {
    $aErrors[] = '[4] '.$MESSAGE['USERS_PASSWORD_MISMATCH'];
}

// Check email
if($email != '') {
    if($admin->validate_email($email) == false){
        $aErrors[] = '[5] '.$MESSAGE['USERS_INVALID_EMAIL'];
    }
} else { // e-mail must be present
    $aErrors[] = '[6] '.$MESSAGE['SIGNUP_NO_EMAIL'];
}
if($database->get_one("SELECT `user_id` FROM `{TP}users` WHERE `email` = '".$admin->add_slashes($_POST['email'])."'")){
    $aErrors[] = '[8] '.$MESSAGE['USERS_EMAIL_TAKEN'];
}

// choose group_id from groups_id; workaround for still remaining calls to group_id (to be cleaned-up)
$aTmp = explode(',', $groups_id);
$group_id = (in_array('1', $aTmp)) ? '1' :$aTmp[0]; // if user is in admin group use it here
					            // otherwise get the first in array

// Check if username already exists
if($database->get_one("SELECT `user_id` FROM `{TP}users` WHERE `username` = '$username'")){
   $aErrors[] = '[7] '.$MESSAGE['USERS_USERNAME_TAKEN'];
}

// Insert the user into the database
$aInsertUser = array (
    'group_id'     => $group_id,
    'groups_id'    => $groups_id,
    'active'       => $admin->add_slashes($_POST['active'][0]),
    'username'     => $username,
    'password'     => WbAuth::Hash($password), // MD5 supplied password
    'display_name' => $display_name = ($display_name != '') ? $display_name : $username,
    'home_folder'  => $admin->get_post_escaped('home_folder'),
    'email'        => $email,
    'timezone'     => '-72000', 
    'language'     => DEFAULT_LANGUAGE
);

if(empty($aErrors)){
    $database->insertRow('{TP}users', $aInsertUser);
    if($database->is_error()) {
        $aErrors[] = '[9] '.$database->get_error();
    } 
}

// print respond messages
$admin->print_header();

if(!empty($aErrors)){
    $admin->print_error($aErrors, $js_back);
} else {
    $admin->print_success($MESSAGE['USERS_ADDED'], $js_back);
}

$admin->print_footer();