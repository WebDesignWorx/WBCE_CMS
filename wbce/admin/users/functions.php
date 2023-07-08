<?php 


/**
 * Get all home folders with their details, including the 
 * assigned folder for a specific user if provided.
 *
 * @param  int     $iUserID The ID of the user to retrieve the assigned folder for.
 * @param  string  $sAssignedFolder The assigned folder to be marked as selected.
 * @return array   An array containing the home folders with their details.
 */
function getHomefolders($iUserID = 0, $sAssignedFolder = ''){
    // Check if $sAssignedFolder is empty and retrieve it 
    // from $admin object if $iUserID is provided
    if(empty($sAssignedFolder) && $iUserID > 0){
        $sAssignedFolder = getUserArray($iUserID)['home_folder'];
    }
    
    $aFolders = [];
    // Iterate over the directories in WB_PATH.MEDIA_DIRECTORY
    foreach(directory_list(WB_PATH.MEDIA_DIRECTORY) as $name) {
        // Extract the folder name and path, and initialize 'selected' flag
        $folder = [
            'name'     => str_replace(WB_PATH, '', $name), // Remove WB_PATH from the directory name
            'dir'      => str_replace(WB_PATH.MEDIA_DIRECTORY, '', $name), // Remove WB_PATH.MEDIA_DIRECTORY from the directory path
            'selected' => !empty($sAssignedFolder) && $sAssignedFolder == $dir // Set 'selected' flag if $sAssignedFolder matches the current directory path
        ];
        $aFolders[] = $folder; // Add the folder to the array
    }
    
    return $aFolders; // Return the array of home folders
}


/**
 * Get an array of groups with their details.
 *
 * Retrieves the groups based on the provided user ID and assigned groups.
 * If no assigned groups are provided, it fetches the assigned groups for the given user ID.
 * Excludes the group with ID 1 (admin) from the result.
 *
 * @param  int    $iUserID           The user ID (optional).
 * @param  array  $aAssignedGroups   Array of assigned groups (optional).
 * @return array                     Array of groups with their details.
 */
function getGroupsArray($iUserID = 0, $aAssignedGroups = [])
{
    global $database, $admin;

    // If no assigned groups are provided, fetch the assigned groups for the user ID
    if (empty($aAssignedGroups)) {
        if ($iUserID > 0) {
            $aUser = getUserArray($iUserID);
            $sTmpGroups = $aUser['group_id'].', '.$aUser['groups_id'];
            $aAssignedGroups = explode(',', trim($sTmpGroups));
        }
    }

    $aGroups = [];

    // Construct the SQL request to exclude group with ID 1 if necessary
    $sLimitSqlRequest = in_array(1, $admin->get_groups_id()) ? "" : " WHERE `group_id` != '1'";

    // Query the database to fetch all groups
    $rAllGroups = $database->query(
        "SELECT `group_id` as `id`, `name` FROM `{TP}groups`".$sLimitSqlRequest
    );

    // Process the retrieved groups
    if ($rAllGroups->numRows() > 0) {
        while ($rec = $rAllGroups->fetchRow(MYSQLI_ASSOC)) {
            $aGroups[$rec['id']] = $rec;

            // Set the 'active' flag if the group ID is in the assigned groups array
            if (in_array($rec['id'], $aAssignedGroups)) {
                $aGroups[$rec['id']]['active'] = true;
            }
        }
    }

    return $aGroups;
}

/**
 * Get the array of a specified user
 * 
 * @global object  $database
 * @global object  $admin
 * 
 * @param  $iUserID  the ID of the user 
 * @return array 
 */
function getUserArray($iUserID)
{
    global $database, $admin;

    // Return empty array if the admin doesn't have permission to see users
    if (!$admin->get_permission('users')) {
        return [];
    }

    // Exclude SuperAdmin user for non-Admins
    if (!$admin->isAdmin() && $iUserID == 1) {
        return [];
    }

    // Query the user data along with group names
    $query = "SELECT u.*, g.group_id, g.name AS group_name
              FROM `{TP}users` u
              LEFT JOIN `{TP}groups` g ON FIND_IN_SET(g.group_id, u.groups_id)
              WHERE u.user_id = " . intval($iUserID);

    $resUser = $database->query($query);

    if ($resUser->numRows() > 0) {
        $rec = [];
        while ($row = $resUser->fetchRow(MYSQLI_ASSOC)) {
            if (empty($rec)) {
                // Populate user data
                $rec = $row;
                $rec['login_ip'] = ($rec['login_ip'] == 0) ? "0.0.0.0" : $rec['login_ip'];
                $rec['status'] = ($rec['active'] == false ? 'inactive' : 'active');
                $rec['groups'] = [];
            }
            // Populate group data
            if ($row['group_id']) {
                $rec['groups'][$row['group_id']] = $row['group_name'];
            }
        }
        return $rec;
    }

    return [];
}


/**
 * Get a list of all users from the database
 * 
 * @global object  $database
 * @global object  $admin
 * @param  mixed   $isActive The status of users to retrieve (optional, default: false).
 *                           If false, all users active & inactive will be added to array
 * @return array An array of user records.
 */
function getAllUsersArray($isActive = false)
{
    global $database, $admin;

    // Return empty array if the admin doesn't have permission to see users
    if (!$admin->get_permission('users')) {
        return [];
    }

    // Construct the SQL query
    $queryUsers = "SELECT u.*, g.name AS group_name, g.group_id AS group_id 
        FROM `{TP}users` AS u 
        LEFT JOIN `{TP}groups` AS g ON FIND_IN_SET(g.group_id, u.groups_id) > 0 
        WHERE 1 ";

    // Exclude SuperAdmin user for non-Admins
    if (!$admin->isAdmin()) {
        $queryUsers .= "AND u.user_id != 1 ";
    }

    // Filter users by status if provided
    if (!is_bool($isActive)) {
        if ($isActive == 0) {
            $queryUsers .= 'AND u.active = 0 ';
        } else {
            $queryUsers .= 'AND u.active >= 1 ';
        }
    }

    $queryUsers .= 'ORDER BY u.display_name, u.username';

    // Query users
    $resUsers = $database->query($queryUsers);

    $allUsersArray = [];
    if ($resUsers->numRows() > 0) {
        while ($rec = $resUsers->fetchRow(MYSQLI_ASSOC)) {
            $iUserID = $rec['user_id'];

            // Modify some of the key=>value pairs
            $rec['login_ip'] = ($rec['login_ip'] == 0) ? "0.0.0.0" : $rec['login_ip'];
            $rec['status'] = ($rec['active'] == false ? 'inactive' : 'active');

            // Collect group names for the user
            if (!isset($allUsersArray[$iUserID])) {
                $allUsersArray[$iUserID] = $rec;
                $allUsersArray[$iUserID]['groups'] = [];
            }
            
            if ($rec['group_name'] !== null) {
                $allUsersArray[$iUserID]['groups'][$rec['group_id']] = $rec['group_name'];
            }
        }
    }

    return $allUsersArray;
}

/**
 * Generate a honeypot string for use in forms as a fake user fieldname
 * @return string
 */
function getHoneypotFieldname($sPrefix = "username_", $iLength = 7) {
    $sRandomBytes = random_bytes($iLength);
    $sHoneypot = $sPrefix . bin2hex($sRandomBytes);
    return $sHoneypot;
}

/**
 * Auto Deletes Empty Users
 *
 * This function automatically deletes user records from the database if they have
 * empty email or password fields. It queries the '{TP}users' table to retrieve an
 * array of user IDs whose email or password is empty and then deletes those records.
 *
 * @global $database 
 *
 * @return void
 */
function autodeleteEmptyUsers(){
    global $database;
    // delete all USERS who have no EMAIL or PASSWORD 
    $arrayToDelete = $database->get_array(
        "SELECT `user_id` FROM `{TP}users` WHERE `email` = '' OR `password` = ''"
    );
    if(is_array($arrayToDelete)){
        foreach($arrayToDelete as $rec){
            $database->delRow('{TP}users', 'user_id', $rec['user_id']);                    
        }
    }
}

/**
 * Activate or deactivate a user's status.
 *
 * This function allows activating or deactivating 
 * the status of a user specified by user_id.
 *
 * @param  int $iUserID The ID of the user to activate or deactivate.
 * @return void
 */
function userStatusActivation($iUserID) {
    global $admin, $database, $oMsgBox;

    $iUserID = intval($iUserID);

    if ($iUserID < 2) {
        $oMsgBox->error(L_("MESSAGE:GENERIC_SECURITY_ACCESS"), ADMIN_URL . '/users/');
        return;
    }

    $checkStatus = $database->get_one('SELECT `active` FROM `{TP}users` WHERE `user_id` = ' . $iUserID);
    $isActive = ($checkStatus == 1) ? 0 : 1;

    $aUpdate = [
        'user_id' => $iUserID,
        'active' => $isActive,
    ];

    $database->updateRow('{TP}users', 'user_id', $aUpdate);

    $sMsg = "{TEXT:USER} " . (($isActive == 1) ? "{TEXT:ENABLED}" : "{TEXT:DISABLED}");
    if (!$database->is_error()) {
        $oMsgBox->success(L_($sMsg));
    } else {
        $oMsgBox->error($database->get_error());
    }
    $oMsgBox->redirect(ADMIN_URL . '/users/?hilite=' . $iUserID . '#uid_' . $iUserID);
}

/**
 * Delete a user's record from DB specified by user_id.
 *
 * This function will delete the record of a user.
 * If the user's status is active, it will set his status to 'inactive' first.
 * (In this way we avoid deleating user accounts accidentally.)
 *
 * @param  int $iUserID 
 * @return void
 */
function userDelete($iUserID) {
    global $admin, $database, $oMsgBox;

    $iUserID = intval($iUserID);

    if ($iUserID < 2) {
        $oMsgBox->error(L_("MESSAGE:GENERIC_SECURITY_ACCESS"), ADMIN_URL . '/users/');
        return;
    }

    $isActive = $database->get_one('SELECT `active` FROM `{TP}users` WHERE `user_id` = ' . $iUserID);
    if ($isActive == 1) {
        $aUpdate = [
            'user_id' => $iUserID,
            'active' => 0,
        ];
        $database->updateRow('{TP}users', 'user_id', $aUpdate);
        $sMsg = "{MESSAGE:USERS_DELETED} ({TEXT:DISABLED})";
    } else {
        $database->delRow('{TP}users', 'user_id', $iUserID);
        $sMsg = "{MESSAGE:USERS_DELETED}";
    }

    if ($database->is_error()) {
        $oMsgBox->error($database->get_error());
    } else {
        $oMsgBox->success(L_($sMsg));
    }
    $oMsgBox->redirect(ADMIN_URL . '/users/?hilite=' . $iUserID . '#uid_' . $iUserID);
}


/**
 * Validate the password and return either the encoded password or an array of errors.
 *
 * @param string $sNewPassword The new password to validate.
 * @param string $sRePassword  The password confirmation to validate.
 * @return string|array The encoded password if validation succeeds, 
 *                      or an array of errors if validation fails.
 */
function validatePassword($sNewPassword, $sRePassword) {
    global $admin;
    $sEncodedPassword = '';
    $aErrors = [];

    if ($sNewPassword != '') {
        $checkPassword = $admin->checkPasswordPattern($sNewPassword, $sRePassword);

        if (is_array($checkPassword)) {
            foreach ($checkPassword as $str) {
                $aErrors[] = $str;
            }
        } else {
            $sEncodedPassword = $checkPassword;
        }
    } else {
        $aErrors[] = L('MESSAGE:USERS_PASSWORD_TOO_SHORT');
    }

    return ($aErrors) ? $aErrors : $sEncodedPassword;
}


/**
 * Checks if the email format is a valid one.
 * It also checks if an email is already taken by other users
 *   if an user_id is specified.
 *
 * @param string $email    The email address to check.
 * @param int    $iUserID  The ID of the current user.
 *
 * @return array An array of errors encountered during the email check.
 */
function isValidEmail($emailAddress, $iUserID = 0) {
    global $admin;
    $aErrors = [];

    if ($emailAddress != "") {
        // is it a valid email address format
        if (!$admin->validate_email($emailAddress)) {
            $aErrors[] = L_("MESSAGE:USERS_INVALID_EMAIL");
        }
    } else {
        // empty
        $aErrors[] = L_("MESSAGE:SIGNUP_NO_EMAIL"); // Email must be present
    }

    // check if email address already in use
    if($iUserID != 0){
        $queryEmail = sprintf(
            "SELECT `user_id` FROM `{TP}users` WHERE `email` = '%s' AND `user_id` <> %d",
            $admin->add_slashes($emailAddress),
            $iUserID
        );
        if ($GLOBALS['database']->get_one($queryEmail)) {
            $aErrors[] =  L_("MESSAGE:USERS_EMAIL_TAKEN");
        }
    }

    return $aErrors;
}


function isValidUsername($username, $iUserID) {
    $aErrors = [];

    if (!preg_match('/^[a-z]{1}[a-z0-9_-]{2,}$/i', $username)) {
        $aErrors[] = L_("MESSAGE:USERS_NAME_INVALID_CHARS");
    }

    if (strlen($username) < 3) {
        $aErrors[] = L_("MESSAGE:USERS_USERNAME_TOO_SHORT");
    }

    // Check if username already exists
    $queryUsername = sprintf(
        "SELECT `user_id` FROM `{TP}users` WHERE `username` = '%s' AND `user_id` <> %d",
        $username,
        $iUserID
    );
    if ($GLOBALS['database']->get_one($queryUsername)) {
        $aErrors[] = L_("MESSAGE:USERS_USERNAME_TAKEN");
    }

    return $aErrors;
}
