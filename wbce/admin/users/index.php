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

require '../../config.php';
$sPos = 'users';
$isHeaderSet = false;
$admin   = new Admin('Access', $sPos, $isHeaderSet); // suppress header output
$oMsgBox = new MessageBox();

require ADMIN_PATH . '/access/functions.php';
require __DIR__ . '/functions.php';
require_once ADMIN_PATH . '/interface/timezones.php';
require_once ADMIN_PATH . '/interface/languages.php';

// based on GET & POST, let's determin which $action we will perform
$action = 'overview';
$actions = [
    'save_user_add'               => isset($_POST['save_user_add']),
    'save_user_changes'           => isset($_POST['save_user_changes']),
    'save_user_changes_and_close' => isset($_POST['save_user_changes_and_close']),
    'modify_user_data'            => isset($_POST['modify']) || isset($_GET['user_id']),
    'delete'                      => isset($_GET['delete']),
    'activation'                  => isset($_GET['activation']),
    'duplicate'                   => isset($_GET['duplicate'])
];

foreach ($actions as $actionKey => $request) {
    if ($request) $action = $actionKey;
}

switch ($action) { 
    
    case 'delete':
        
        $admin = new Admin('Access', 'users_delete', false);
        if($iUserID = intval($admin->checkIDKEY('user_id', 0, $_SERVER['REQUEST_METHOD']))){
        // Check if user id is a valid number and doesnt equal 1
            userDelete($iUserID);
        }        
        break;
        
    case 'activation':
        
        $admin = new Admin('Access', 'users_modify', false);
        if($iUserID = intval($admin->checkIDKEY('user_id', 0, $_SERVER['REQUEST_METHOD']))){
            // Check if user id is a valid number and doesnt equal 1
            userStatusActivation($iUserID);
        }                    
        break;
        
    case 'save_user_add':
    case 'save_user_changes':
    case 'save_user_changes_and_close':
        $sAdminArea = ($action == 'save_user_add') ? 'users_add' : 'users_modify';
        $admin    = new Admin('Access', $sAdminArea, false);
        $aErrors  = [];
        $aSuccess = [];

        if (!$admin->checkFTAN()) {
            header("Location: index.php"); exit(0);
        } 

        $iUserID = '0'; // temporarily
        if ($action != 'save_user_add') {
            // Check if user id is a valid number and doesnt equal 1
            if (!isset($_POST['user_id']) OR !is_numeric($_POST['user_id']) OR $_POST['user_id'] == 1) {
                header("Location: index.php"); exit(0);
            } else {
                $iUserID = (int) $admin->get_post('user_id');
            }
        }                 
        
        // Check username 
        $username = strtolower($admin->get_post_escaped('username'));
        $checkUsername = isValidUsername($username, $iUserID);
        if (is_array($checkUsername)) {
            $aErrors += $checkUsername;
        }
        
        // Check display_name
        $display_name = $admin->get_post_escaped('display_name');
        if ($display_name == "") {
            $aErrors[] = true;
        }        
        
        // Check groups
        if (empty($_POST['groups'])) {
            $aErrors[] = $MESSAGE['USERS_NO_GROUP'];
        } else {            
            $groups_id = (isset($_POST['groups'])) ? implode(",", $admin->add_slashes($_POST['groups'])) : '';
        }        
        
        // Check email. Is it valid? Already in use?
        $email = $admin->get_post_escaped('email');
        $checkEmail = isValidEmail($email, $iUserID);
        if (is_array($checkEmail)) {
            // add errors if already in use or wrong format
            $aErrors += $checkEmail; 
        }

        $aSaveData = array(
            'user_id'      => $iUserID,
            'groups_id'    => $groups_id,
            'active'       => $admin->add_slashes($_POST['active'][0]),
            'username'     => ($username != 'admin') ? $username : '', // "admin" is an unappropriate usename
            'display_name' => $display_name,
            'email'        => $admin->add_slashes($email),
            'home_folder'  => $admin->get_post_escaped('home_folder'),
            'timezone'     => $admin->get_post_escaped('timezone') * 60 * 60,
            'language'     => $admin->get_post_escaped('language'),
            'signup_timestamp'   => time(),
            'signup_confirmcode' => 'by admin uid: '.$admin->get_user_id(),
        );

        // check password if necessary
        if(isset($_POST['change_pswd']) && $_POST['change_pswd'] == 1 || $action == 'save_user_add'){ 
             $sEncodedPassword = '';
             
            // validate and encode Password            
             $mCheckPassword = validatePassword($admin->get_post('password'), $admin->get_post('password2'));
            if(is_array($mCheckPassword)){
                $aErrors[] = $mCheckPassword;
            } else {
                $sEncodedPassword = $mCheckPassword;                
            }
            
            if ($sEncodedPassword != "") {
                $aSaveData['password'] = $sEncodedPassword;
            }
        }

        // if no errors write or update the data 
        if (empty($aErrors)) {
            if ($action == 'save_user_add') {
                // adding a new user
                unset($aSaveData['user_id']);
                $database->insertRow('{TP}users', $aSaveData);
                $aSaveData['user_id'] = $database->getLastInsertId();
            } else {
                // update existing user record
                $database->updateRow('{TP}users', 'user_id', $aSaveData);
            }
        }
        
        $aSaveData['groups'] = explode(',', $groups_id); // we need it to re-fill the form 
        
        // After Database updates, let's check for errors and
        // determin the course of action
        if ($database->is_error()) {
            $aErrors[] = $database->get_error(); // Database error occurred
        } elseif (empty($aErrors)) {
            // No errors
            if ($action == 'save_user_changes_and_close') {
                // Display success message and go back to overview
                $oMsgBox->success($MESSAGE['USERS_SAVED'], ADMIN_URL . '/users/'); 
            } elseif ($action == 'save_user_changes' || $action == 'save_user_add') {
                // Set success message and stay in modify user mode
                $aSuccess[] = ($action == 'save_user_changes') ? $MESSAGE['USERS_SAVED'] : $MESSAGE['USERS_ADDED'];
                $isModifyView = true; 
                $action = 'modify_user_data'; 
            }
        } else {
            // Errors present
            if ($action == 'save_user_add') {
                // Error in adding user, set error message on top of the queue
                $aErrors[0] = '<b>' . $MESSAGE['GENERIC_FILL_IN_ALL'] . '</b>'; 
                $aSaveData['add_new_user'] = 1;
                
                $isModifyView = false; 
                $action = 'save_user_add'; 
            } else {
                // Errors in other actions
                $isModifyView = true; 
                $action = 'modify_user_data'; 
            }
        }

        
    case 'overview':
        if (!isset($iUserID)) {
            // set some placeholder data for add user
            $iUserID = 0;
            $isModifyView = $isModifyView ?? false;
            $aUserData = [
                'user_id'      => '',
                'username'     => '',
                'display_name' => '',
                'email'        => '',
                'active'       => 0,
            ];
        }
        
    case 'modify_user_data':
        if ($action == 'modify_user_data') {
            $isModifyView = true;
            $admin = new Admin('Access', 'users_modify');
            if (!isset($iUserID)) {
                $tmp = $admin->get_get('user_id');
                if($iUserID = $admin->checkIDKEY($tmp)){
                    // Check if user id is a valid number and doesn't equal 1
                    if ($iUserID == 0) {
                        $oMsgBox->error($MESSAGE['GENERIC_FORGOT_OPTIONS']);
                    }
                    if (($iUserID < 2)) {
                        // we do not allow to change SuperAdmin (user_id 1)
                        $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS']); 
                    }
                } else {
                    // checkIDKEY failed (maybe user clicked the refresh button)
                    $oMsgBox->error($MESSAGE['GENERIC_SECURITY_ACCESS']); 
                    $oMsgBox->redirect(ADMIN_URL.'/users/'); 
                }
                    
            }
            $aUserData = getUserArray($iUserID);
        } else {
            // we're in the OVERVIER USERS 
            
            autodeleteEmptyUsers();          
            
            if (isset($isHeaderSet) && $isHeaderSet != true) {
                $admin->print_header();
                $isHeaderSet = true;
            }
            
        }
        // do we have some Error Messages to display?
        if (!empty($aErrors)) {
            $sErrors = (implode('<br>', $aErrors));
            $oMsgBox->error($sErrors);
        }
        // do we have some Success Messages to display?
        if (!empty($aSuccess)) {
            $sSuccess = (implode('<br>', $aSuccess));
            $oMsgBox->success($sSuccess);
        }
     

        // prepare Twig 	
        $aToTwig = array(
            'MESSAGE_BOX'        => $oMsgBox->fetchDisplay(),
            'TABS'               => renderAddonsTabs($sPos),
            'do_modify_user'     => $isModifyView,
            'ACTION_URL'         => ADMIN_URL . '/users/index.php',
            'use_home_folders'   => HOME_FOLDERS,
            'user'               => (isset($aSaveData)) ? $aSaveData : $aUserData,    
            'TIME_ZONES'         => getTimeZonesArray($TIMEZONES, true),
            'LANGUAGES'          => getLanguagesArray(),
            'USERLIST'           => getAllUsersArray(),
            'groups'             => getGroupsArray($iUserID, (isset($aSaveData['groups']) ? $aSaveData['groups'] : array())),
            'home_folders'       => getHomefolders($iUserID, (isset($aSaveData['home_folder']) ? $aSaveData['home_folder'] : '')),
            'change_pswd'        => (isset($_POST['change_pswd']) && $_POST['change_pswd'] == 1),
            'INPUT_NEW_PASSWORD' => $admin->passwordField('password'), 
        );

        if(isset($_GET['duplicated'])){
            $aToTwig['change_pswd'] = true;
        }        
        if(isset($_GET['hilite'])){
            $aToTwig['hilite'] = (int) $_GET['hilite'];
        }
        $admin->getThemeFile('access_users.twig', $aToTwig);
        $admin->print_footer();
        break;
        
    default:
        break;
}