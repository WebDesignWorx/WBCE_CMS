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
 *
 * Made whith help of Automated Language File tool Copyright heimsath.org
 */

//no direct file access
if (count(get_included_files()) ==1) {
    $z="HTTP/1.0 404 Not Found";
    header($z);
    die($z);
}

// Set the language information
$language_code = 'GR';
$language_name = 'Greek';
$language_version = '3.2';
$language_platform = '1.3.0';
$language_author = 'Yannis Spyrou';
$language_license = 'GNU General Public License';

/* New strings added in WBCE 1.7.x */
$TEXT['REGISTRATION_DATE'] = "Ημερομηνία εγγραφής";
$TEXT['LATEST_LOGIN']      = "Τελευταία σύνδεση";

$TEXT['ACTIVATE_RECORD']   = "Ενεργοποίηση %s|εγγραφής";
$TEXT['DEACTIVATE_RECORD'] = "Απενεργοποίηση %s|εγγραφής";
$TEXT['ADD_RECORD']        = "Προσθήκη %s|εγγραφής";
$TEXT['EDIT_RECORD']       = "Επεξεργασία %s|εγγραφής";
$TEXT['DELETE_RECORD']     = "Διαγραφή %s|εγγραφής";
$TEXT['EDIT_RECORD']       = "Επεξεργασία %s|εγγραφής";
$TEXT['TRASH_RECORD']      = "Μετακίνηση %s|εγγραφής Μετακίνηση εγγραφής στον κάδο ανακύκλωσης";
$TEXT['RESTORE_RECORD']    = "Επαναφορά %s|εγγραφής";
$TEXT['RECORDS_TOTAL']     = 'Συνολικός αριθμός %s|εγγραφών';

$TEXT['RECORD_DISABLED']   = "%s|εγγραφή απενεργοποιημένη";
$TEXT['RECORD_ENABLED']    = "%s|εγγραφή ενεργοποιημένη";

$TEXT['SELECT_ALL']        = "επιλογή όλων";
$TEXT['DESELECT_ALL']      = "αποεπιλογή όλων";

$TEXT['THEMES_PERMISSIONS']   = 'Πρόσβαση στα Θέματα';
$TEXT['TOOLS_PERMISSIONS']    = 'Πρόσβαση στα Εργαλεία Διαχείρισης';
$TEXT['MODULE_PERMISSIONS']   = 'Πρόσβαση στις Μονάδες';
$TEXT['TEMPLATE_PERMISSIONS'] = 'Πρόσβαση στα Πρότυπα';

$TEXT['GO_TO_CREATED_PAGE'] = 'Μετάβαση στη δημιουργημένη σελίδα';
$TEXT['MODIFY_PAGE_CONTENTS'] = "Τροποποίηση περιεχομένου σελίδας";
$TEXT['PAGE_ID'] = "ID σελίδας";
/* END OF: New strings added in WBCE 1.7.x */


$MENU['ACCESS'] = 'Πρόσβαση';
$MENU['ADDON'] = 'Επιπρόσθετο';
$MENU['ADDONS'] = 'Επιπρόσθετα';
$MENU['ADMINTOOLS'] = 'Εργαλεία-Διαχείρισης';
$MENU['BREADCRUMB'] = 'Είστε εδώ: ';
$MENU['FORGOT'] = 'Επαναφορά Στοιχείων Εισόδου';
$MENU['GROUP'] = 'Ομάδα';
$MENU['GROUPS'] = 'Ομάδες';
$MENU['HELP'] = 'Βοήθεια';
$MENU['LANGUAGES'] = 'Γλώσσες';
$MENU['LOGIN'] = 'Σύνδεση';
$MENU['LOGOUT'] = 'Αποσύνδεση';
$MENU['MEDIA'] = 'Μίντια';
$MENU['MODULES'] = 'Ενότητες';
$MENU['PAGES'] = 'Σελίδες';
$MENU['PREFERENCES'] = 'Προτιμήσεις';
$MENU['SETTINGS'] = 'Ρυθμίσεις';
$MENU['START'] = 'Έναρξη';
$MENU['TEMPLATES'] = 'Πρότυπα';
$MENU['USERS'] = 'Χρήστες';
$MENU['VIEW'] = 'Εμφάνιση';


$TEXT['ACCOUNT_SIGNUP'] = 'Εγγραφή Λογαριασμού';
$TEXT['ACTIONS'] = 'Ενέργειες';
$TEXT['ACTIVE'] = 'Ενεργός';
$TEXT['ADD'] = 'Προσθήκη';
$TEXT['ADDON'] = 'Πρόσθετο';
$TEXT['ADD_SECTION'] = 'Προσθήκη Ενότητας';
$TEXT['ADMIN'] = 'Διαχειριστής';
$TEXT['ADMINISTRATION'] = 'Διαχείριση';
$TEXT['ADMINISTRATION_TOOL'] = 'Εργαλείο Διαχείρισης';
$TEXT['ADMINISTRATOR'] = 'Διαχειριστής';
$TEXT['ADMINISTRATORS'] = 'Διαχειριστές';
$TEXT['ADVANCED'] = 'Προχωρημένο';
$TEXT['ADVANCED_SEARCH'] = 'Προχωρημένη Αναζήτηση';
$TEXT['ALLOWED_FILETYPES_ON_UPLOAD'] = 'Επιτρεπόμενοι τύποι αρχείων κατά τη μεταφόρτωση';
$TEXT['ALLOWED_VIEWERS'] = 'Επιτρεπόμενοι Θεατές';
$TEXT['ALLOW_MULTIPLE_SELECTIONS'] = 'Επιτρέπονται Πολλές Επιλογές';
$TEXT['ALL_WORDS'] = 'Όλες οι Λέξεις';
$TEXT['ANCHOR'] = 'Στίγμα';
$TEXT['ANONYMOUS'] = 'Ανώνυμος';
$TEXT['ANY_WORDS'] = 'Οποιεσδήποτε Λέξεις';
$TEXT['APP_NAME'] = 'Όνομα Εφαρμογής';
$TEXT['ARE_YOU_SURE'] = 'Είστε Σίγουρος?';
$TEXT['AUTHOR'] = 'Συντάκτης';
$TEXT['BACK'] = 'Πίσω';
$TEXT['BACKEND'] = 'Διαχείριση';
$TEXT['BACKUP'] = 'Αντίγραφα Ασφαλείας';
$TEXT['BACKUP_ALL_TABLES'] = 'Δημιουργία αντιγράφων ασφαλείας όλων των πινάκων στη βάση δεδομένων';
$TEXT['BACKUP_DATABASE'] = 'Εφεδρική Βάση Δεδομένων';
$TEXT['BACKUP_MEDIA'] = 'Εφεδρικά Μέσα';
$TEXT['BACKUP_WB_SPECIFIC'] = 'Δημιουργήστε αντίγραφα ασφαλείας μόνο για πίνακες WB';
$TEXT['BASIC'] = 'Βασικός';
$TEXT['BLOCK'] = 'Μπλοκαρισμένος';
$TEXT['BUTTON_SEND_TESTMAIL'] = 'Ελέγξτε τη διαμόρφωση email';
$TEXT['CALENDAR'] = 'Ημερολόγιο';
$TEXT['CANCEL'] = 'Ακύρωση';
$TEXT['CAN_DELETE_HIMSELF'] = 'Μπορεί να διαγράψει τον εαυτό του';
$TEXT['CAPTCHA_VERIFICATION'] = 'Επαλήθευση Captcha';
$TEXT['CAP_EDIT_CSS'] = 'Επεξεργασία CSS';
$TEXT['CHANGE'] = 'Αλλαγή';
$TEXT['CHANGES'] = 'Αλλαγές';
$TEXT['CHANGE_SETTINGS'] = 'Αλλαγή Ρυθμίσεων';
$TEXT['CHARACTERS'] = 'Χαρακτήρες';
$TEXT['CHARSET'] = 'Χαρακτήρας';
$TEXT['CHECKBOX_GROUP'] = 'Ομάδα Πλαισίων Ελέγχου';
$TEXT['CLOSE'] = 'Κλειστό';
$TEXT['CODE'] = 'Κωδικός';
$TEXT['CODE_SNIPPET'] = 'Κωδικός-Απόσπασμα';
$TEXT['COLLAPSE'] = 'Κατάρρευση';
$TEXT['COMMENT'] = 'Σχόλιο';
$TEXT['COMMENTING'] = 'Σχολιασμός';
$TEXT['COMMENTS'] = 'Σχόλια';
$TEXT['CREATE_FOLDER'] = 'Δημιουργία Φακέλου';
$TEXT['CURRENT'] = 'Τρέχων';
$TEXT['CURRENT_FOLDER'] = 'Τρέχων Φάκελος';
$TEXT['CURRENT_PAGE'] = 'Τρέχουσα Σελίδα';
$TEXT['CURRENT_PASSWORD'] = 'Τρέχων Κωδικός Πρόσβασης';
$TEXT['CUSTOM'] = 'Κατά Παραγγελία';
$TEXT['DATABASE'] = 'Βάση Δεδομένων';
$TEXT['DATE'] = 'Ημερομηνία';
$TEXT['DATE_FORMAT'] = 'Μορφή Ημερομηνίας';
$TEXT['DEFAULT'] = 'Προκαθορισμένο';
$TEXT['DEFAULT_CHARSET'] = 'Προεπιλεγμένο Σύνολο Χαρακτήρων';
$TEXT['DEFAULT_TEXT'] = 'Προεπιλεγμένο Κείμενο';
$TEXT['DELETE'] = 'Διαγράφω';
$TEXT['DELETED'] = 'Διαγράφηκε';
$TEXT['DELETE_DATE'] = 'Διαγραφή Ημερομηνίας';
$TEXT['DELETE_ZIP'] = 'Διαγράψτε το αρχείο zip μετά την αποσυσκευασία';
$TEXT['DESCRIPTION'] = 'Περιγραφή';
$TEXT['DESIGNED_FOR'] = 'Σχεδιασμένο για';
$TEXT['DIRECTORIES'] = 'Κατάλογοι';
$TEXT['DIRECTORY_MODE'] = 'Λειτουργία Καταλόγου';
$TEXT['DISABLED'] = 'Ατομα με ειδικές ανάγκες';
$TEXT['DISPLAY_NAME'] = 'Εμφανιζόμενο Όνομα';
$TEXT['EMAIL'] = 'Ηλεκτρονική Ταχυδρομείο';
$TEXT['EMAIL_ADDRESS'] = 'Ηλεκτρονική Διεύθυνση';
$TEXT['EMPTY_TRASH'] = 'Αδειος Κάδος';
$TEXT['ENABLED'] = 'Ενεργοποιήθηκε';
$TEXT['END'] = 'Τέλος';
$TEXT['ERROR'] = 'Σφάλμα';
$TEXT['ERR_USE_SYSTEM_DEFAULT'] = 'Χρησιμοποιήστε το προεπιλεγμένο σύστημα(php.ini)';
$TEXT['ERR_HIDE_ERRORS_NOTICES'] = 'Απόκρυψη όλων των σφαλμάτων και ειδοποιήσεων(WWW)';
$TEXT['ERR_SHOW_ERRORS_NOTICES'] = 'Εμφάνιση όλων των σφαλμάτων και ειδοποιήσεων (development)';
$TEXT['ERR_SHOW_ERRORS_HIDE_NOTICES'] = 'Εμφάνιση σφαλμάτων, απόκρυψη ειδοποιήσεων';
$TEXT['EXACT_MATCH'] = 'Ακριβής Αντιστοίχιση';
$TEXT['EXECUTE'] = 'Εκτέλεση';
$TEXT['EXPAND'] = 'Επεκτείνουν';
$TEXT['EXTENSION'] = 'Επέκταση';
$TEXT['FIELD'] = 'Πεδίο';
$TEXT['FILE'] = 'Αρχείο';
$TEXT['FILENAME'] = 'Όνομα αρχείου';
$TEXT['FILES'] = 'Αρχεία';
$TEXT['FILESYSTEM_PERMISSIONS'] = 'Δικαιώματα Συστήματος Αρχείων';
$TEXT['FILE_MODE'] = 'Λειτουργία Αρχείου';
$TEXT['FINISH_PUBLISHING'] = 'Ολοκληρώστε τη Δημοσίευση';
$TEXT['FOLDER'] = 'Φάκελος';
$TEXT['FOLDERS'] = 'Φακέλοι';
$TEXT['FOOTER'] = 'Υποσέλιδο';
$TEXT['FORGOTTEN_DETAILS'] = 'Ξεχάσατε τα Στοιχεία σας;';
$TEXT['FORGOT_DETAILS'] = 'Ξεχάσατε τις Λεπτομέρειες?';
$TEXT['FROM'] = 'Από';
$TEXT['FRONTEND'] = 'Μπροστά';
$TEXT['FULL_NAME'] = 'Πλήρες Όνομα';
$TEXT['FUNCTION'] = 'Λειτουργία';
$TEXT['GROUP'] = 'Ομάδα';
$TEXT['HEADER'] = 'Επικεφαλής';
$TEXT['HEADING'] = 'Επικεφαλίδα';
$TEXT['HEADING_ADD_USER'] = 'Πρόσθεσε Χρήστη';
$TEXT['HEADING_MODIFY_USER'] = 'Τροποποίηση Χρήστη';
$TEXT['HEADING_CSS_FILE'] = 'Πραγματικό αρχείο λειτουργικής μονάδας: ';
$TEXT['HEIGHT'] = 'Ύψος';
$TEXT['HIDDEN'] = 'Κρυμμένος';
$TEXT['HIDE'] = 'Κρύφτο';
$TEXT['HIDE_ADVANCED'] = 'Απόκρυψη Προχωρημένων Επιλογών';
$TEXT['HOME'] = 'Σπίτι';
$TEXT['HOMEPAGE_REDIRECTION'] = 'Ανακατεύθυνση Αρχικής Σελίδας';
$TEXT['HOME_FOLDER'] = 'Προσωπικός Φάκελος';
$TEXT['HOME_FOLDERS'] = 'Προσωπικοί Φακέλοι';
$TEXT['HOST'] = 'Πλήθος';
$TEXT['ICON'] = 'Εικόνισμα';
$TEXT['IMAGE'] = 'Εικόνα';
$TEXT['INLINE'] = 'Στη γραμμή';
$TEXT['INSTALL'] = 'Εγκαθιστώ';
$TEXT['INSTALLATION'] = 'Εγκατάσταση';
$TEXT['INSTALLATION_PATH'] = 'Διαδρομή Εγκατάστασης';
$TEXT['INSTALLATION_URL'] = 'Διεύθυνση URL Εγκατάστασης';
$TEXT['INSTALLED'] = 'εγκατεστημένο';
$TEXT['INTRO'] = 'Εισαγωγή';
$TEXT['INTRO_PAGE'] = 'Εισαγωγική Σελίδα';
$TEXT['INVALID_SIGNS'] = 'πρέπει να ξεκινά με ένα γράμμα ή να έχει άκυρα σημάδια';
$TEXT['KEYWORDS'] = 'Λέξεις-Κλειδιά';
$TEXT['LANGUAGE'] = 'Γλώσσα';
$TEXT['LAST_UPDATED_BY'] = 'Τελευταία Ενημέρωση Από';
$TEXT['LENGTH'] = 'Μήκος';
$TEXT['LEVEL'] = 'Επίπεδο';
$TEXT['LICENSE'] = 'Άδεια';
$TEXT['LINK'] = 'Σύνδεσμος';
$TEXT['LINUX_UNIX_BASED'] = 'Βασίζεται σε Linux / Unix';
$TEXT['LIST_OPTIONS'] = 'Επιλογές Λίστας';
$TEXT['LOGGED_IN'] = 'Συνδεδεμένοι';
$TEXT['LOGIN'] = 'Σύνδεση';
$TEXT['LONG'] = 'Μεγάλο';
$TEXT['LONG_TEXT'] = 'Μεγάλο Κείμενο';
$TEXT['LOOP'] = 'Βρόχος';
$TEXT['MAIN'] = 'Κύριος';
$TEXT['MAINTENANCE_ON'] = 'Η συντήρηση είναι ενεργή';
$TEXT['MAINTENANCE_OFF'] = 'Η συντήρηση είναι απενεργοποιημένη';
$TEXT['MANAGE'] = 'Διαχειρίζονται';
$TEXT['MANAGE_GROUPS'] = 'Διαχείριση Ομάδων';
$TEXT['MANAGE_USERS'] = 'Διαχείριση Χρηστών';
$TEXT['MATCH'] = 'Ταιριάζω';
$TEXT['MATCHING'] = 'Ταιριάζει';
$TEXT['MAX_EXCERPT'] = 'Μέγιστες γραμμές αποσπάσματος';
$TEXT['MAX_SUBMISSIONS_PER_HOUR'] = 'Μέγιστες. Υποβολές Ανά Ώρα';
$TEXT['MEDIA_DIRECTORY'] = 'Κατάλογος Πολυμέσων';
$TEXT['MENU'] = 'Μενού';
$TEXT['MENU_ICON_0'] = 'Μενού-Εικονίδιο κανονικό';
$TEXT['MENU_ICON_1'] = 'Μετακινήστε το Εικονίδιο μενού';
$TEXT['MENU_TITLE'] = 'Τίτλος Μενού';
$TEXT['MESSAGE'] = 'Μήνυμα';
$TEXT['MODIFY'] = 'Τροποποιώ';
$TEXT['MODIFY_CONTENT'] = 'Τροποποίηση Περιεχομένου';
$TEXT['MODIFY_SETTINGS'] = 'Τροποποίηση Ρυθμίσεων';
$TEXT['MODULE_ORDER'] = 'Ενότητα-παραγγελία για αναζήτηση';
$TEXT['MODULE_PERMISSIONS'] = 'Δικαιώματα Ενότητας';
$TEXT['MORE'] = 'Περισσότερο';
$TEXT['MOVE_DOWN'] = 'Μετακινηθείτε προς τα Κάτω';
$TEXT['MOVE_UP'] = 'Μετακινηθείτε προς τα Πάνω';
$TEXT['MULTIPLE_MENUS'] = 'Πολλαπλά Μενού';
$TEXT['MULTISELECT'] = 'Πολλαπλή επιλογή';
$TEXT['NAME'] = 'Όνομα';
$TEXT['NEED_CURRENT_PASSWORD'] = 'επιβεβαιώστε με τον τρέχοντα κωδικό πρόσβασης';
$TEXT['NEED_TO_LOGIN'] = 'Πρέπει να συνδεθείτε;';
$TEXT['NEW_PASSWORD'] = 'Νέος Κωδικός Πρόσβασης';
$TEXT['NEW_WINDOW'] = 'Νέο Παράθυρο';
$TEXT['NEXT'] = 'Επόμενο';
$TEXT['NEXT_PAGE'] = 'Επόμενη Σελίδα';
$TEXT['NO'] = 'Όχι';
$TEXT['NONE'] = 'Κανένας';
$TEXT['NONE_FOUND'] = 'Δεν Βρέθηκε';
$TEXT['NOT_FOUND'] = 'Δεν βρέθηκε';
$TEXT['NOT_INSTALLED'] = 'μη εγκατεστημενο';
$TEXT['NO_IMAGE_SELECTED'] = 'δεν έχει επιλεγεί εικόνα';
$TEXT['NO_RESULTS'] = 'Χωρίς Αποτέλεσμα';
$TEXT['OF'] = 'Του';
$TEXT['OLDWBCE'] = '<b style="color:red">Your WBCE version is outdated! <a href="https://github.com/WBCE/WBCE_CMS/releases" target="_blank">WBCE Releases on GitHub <i class="fa fa-external-link" aria-hidden="true"></i></a> You are using: WBCE </b>';
$TEXT['ON'] = 'Επάνω';
$TEXT['OPEN'] = 'Ανοιχτό';
$TEXT['OPTION'] = 'Επιλογή';
$TEXT['OTHERS'] = 'Υπόλοιποι';
$TEXT['OUT_OF'] = 'Εκτός';
$TEXT['OVERWRITE_EXISTING'] = 'Αντικατάσταση υπάρχοντος';
$TEXT['PAGE'] = 'Σελίδα';
$TEXT['PAGES_DIRECTORY'] = 'Κατάλογος Σελίδων';
$TEXT['PAGES_PERMISSION'] = 'Άδεια Σελίδων';
$TEXT['PAGES_PERMISSIONS'] = 'Δικαιώματα Σελίδων';
$TEXT['PAGE_EXTENSION'] = 'Επέκταση Σελίδας';
$TEXT['PAGE_ICON'] = 'Εικόνα Σελίδας';
$TEXT['PAGE_ICON_DIR'] = 'Σελίδες διαδρομών / Εικόνες μενού';
$TEXT['PAGE_LANGUAGES'] = 'Πολύγλωσση ιστοσελίδα';
$TEXT['PAGE_LEVEL_LIMIT'] = 'Όριο Επιπέδου Σελίδας';
$TEXT['PAGE_SPACER'] = 'Διαχωριστικό Σελίδας';
$TEXT['PAGE_TITLE'] = 'Τίτλος Σελίδας';
$TEXT['PAGE_TRASH'] = 'Κάδος Απορριμμάτων Σελίδας';
$TEXT['PARENT'] = 'Μητρική εταιρεία';
$TEXT['PASSWORD'] = 'Κωδικός πρόσβασης';
$TEXT['PATH'] = 'Μονοπάτι';
$TEXT['PHP_ERROR_LEVEL'] = 'Επίπεδο Αναφοράς Σφάλματος PHP';
$TEXT['PLEASE_LOGIN'] = 'Παρακαλώ συνδεθείτε';
$TEXT['PLEASE_SELECT'] = 'Παρακαλώ επιλέξτε';
$TEXT['POST'] = 'Άρθρο';
$TEXT['POSTS_PER_PAGE'] = 'Άρθρα Ανά Σελίδα';
$TEXT['POST_FOOTER'] = 'Δημοσίευση Υποσέλιδου';
$TEXT['POST_HEADER'] = 'Δημοσίευση Κεφαλίδας';
$TEXT['PREVIOUS'] = 'Προηγούμενα';
$TEXT['PREVIOUS_PAGE'] = 'Προηγούμενη Σελίδα';
$TEXT['PRIVATE'] = 'Ιδιωτικός';
$TEXT['PRIVATE_VIEWERS'] = 'Ιδιωτικοί Θεατές';
$TEXT['PROFILES_EDIT'] = 'Αλλάξτε το προφίλ';
$TEXT['PUBLIC'] = 'Δημόσιο';
$TEXT['PUBL_END_DATE'] = 'Ημερομηνία λήξης';
$TEXT['PUBL_START_DATE'] = 'Ημερομηνία έναρξης';
$TEXT['QUICK_SEARCH_STRG_F'] = 'Πατήστε <b> Strg + f </b> για γρήγορη αναζήτηση ή χρήση';
$TEXT['RADIO_BUTTON_GROUP'] = 'Ομάδα Κουμπιών Ραδιοφώνου';
$TEXT['READ'] = 'Ανάγνωση';
$TEXT['READ_MORE'] = 'Διαβάστε Περισσότερα';
$TEXT['REDIRECT_AFTER'] = 'Ανακατεύθυνση μετά';
$TEXT['REGISTERED'] = 'Εγγεγραμμένος';
$TEXT['REGISTERED_VIEWERS'] = 'Εγγεγραμμένοι Θεατές';
$TEXT['RELOAD'] = 'Φορτώνω πάλι';
$TEXT['REMAINING'] = 'Παραμένων';
$TEXT['REMEMBER_ME'] = 'Θυμήσου Με';
$TEXT['RENAME'] = 'Μετονομάζω';
$TEXT['RENAME_FILES_ON_UPLOAD'] = 'Χωρίς μεταφόρτωση για αυτούς τους τύπους αρχείων';
$TEXT['REQUIRED'] = 'Απαιτείται';
$TEXT['REQUIREMENT'] = 'Απαίτηση';
$TEXT['RESET'] = 'Επαναφορά';
$TEXT['RESIZE'] = 'Εκ νέου μέγεθος';
$TEXT['RESIZE_IMAGE_TO'] = 'Αλλαγή Μεγέθους Εικόνας σε';
$TEXT['RESTORE'] = 'Επαναφέρω';
$TEXT['RESTORE_DATABASE'] = 'Επαναφορά Βάσης Δεδομένων';
$TEXT['RESTORE_MEDIA'] = 'Επαναφορά Πολυμέσων';
$TEXT['RESULTS'] = 'Αποτελέσματα';
$TEXT['RESULTS_FOOTER'] = 'Υποσέλιδο Αποτελεσμάτων';
$TEXT['RESULTS_FOR'] = 'Αποτελέσματα για';
$TEXT['RESULTS_HEADER'] = 'Κεφαλίδα Αποτελεσμάτων';
$TEXT['RESULTS_LOOP'] = 'Βρόχος Αποτελεσμάτων';
$TEXT['RETYPE_NEW_PASSWORD'] = 'Πληκτρολογήστε ξανά Νέο Κωδικό Πρόσβασης';
$TEXT['RETYPE_PASSWORD'] = 'Πληκτρολογήστε ξανά τον Κωδικό Πρόσβασης';
$TEXT['SAME_WINDOW'] = 'Ίδιο Παράθυρο';
$TEXT['SAVE'] = 'Αποθηκεύσετε';
$TEXT['SEARCH'] = 'Αναζήτηση';
$TEXT['SEARCHING'] = 'Ερευνητικός';
$TEXT['SECTION'] = 'Ενότητα';
$TEXT['SECTION_BLOCKS'] = 'Ενότητα Μπλοκ';
$TEXT['SEC_ANCHOR'] = 'Κείμενο Ενότητας-Στίγμα';
$TEXT['SELECT_BOX'] = 'Επιλέξτε Πλαίσιο';
$TEXT['SEND_DETAILS'] = 'Αποστολή Λεπτομερειών';
$TEXT['SEND_TESTMAIL'] = 'Για να επιβεβαιώσετε ότι οι ρυθμίσεις email λειτουργούν σωστά, μπορείτε να στείλετε ένα δοκιμαστικό email στην παραπάνω διεύθυνση email κάνοντας κλικ στο κουμπί Σημειώστε ότι πρέπει πρώτα να αποθηκεύσετε τις ρυθμίσεις.';
$TEXT['SEPARATE'] = 'Ξεχωριστός';
$TEXT['SEPERATOR'] = 'Διαχωριστής';
$TEXT['SERVER_EMAIL'] = 'Email Διακομιστή';
$TEXT['SERVER_OPERATING_SYSTEM'] = 'Λειτουργικό Σύστημα Διακομιστή';
$TEXT['SESSION_IDENTIFIER'] = 'Αναγνωριστικό Περιόδου Σύνδεσης';
$TEXT['SETTINGS'] = 'Ρυθμίσεις';
$TEXT['SHORT'] = 'Μικρός';
$TEXT['SHORT_TEXT'] = 'Σύντομο Κείμενο';
$TEXT['SHOW'] = 'Προβολή';
$TEXT['SHOW_ADVANCED'] = 'Δείξε Επιλογές για Προχωρημένους';
$TEXT['SIGNUP'] = 'Εγγραφείτε';
$TEXT['SIZE'] = 'Μέγεθος';
$TEXT['SMART_LOGIN'] = 'Έξυπνη Σύνδεση';
$TEXT['START'] = 'Αρχή';
$TEXT['START_PUBLISHING'] = 'Ξεκινήστε τη Δημοσίευση';
$TEXT['SUBJECT'] = 'Θέμα';
$TEXT['SUBMISSIONS'] = 'Υποβολές';
$TEXT['SUBMISSIONS_STORED_IN_DATABASE'] = 'Οι Υποβολές Αποθηκεύονται στη Βάση Δεδομένων';
$TEXT['SUBMISSION_ID'] = 'Αναγνωριστικό Υποβολής';
$TEXT['SUBMITTED'] = 'Υποβλήθηκε';
$TEXT['SUCCESS'] = 'Επιτυχία';
$TEXT['SYSTEM_DEFAULT'] = 'Προεπιλογή Συστήματος';
$TEXT['SYSTEM_PERMISSIONS'] = 'Άδειες Συστήματος';
$TEXT['TABLE_PREFIX'] = 'Διακριτικό Πίνακα(Prefix)';
$TEXT['TARGET'] = 'Στόχος';
$TEXT['TARGET_FOLDER'] = 'Φάκελος προορισμού';
$TEXT['TEMPLATE'] = 'Πρότυπο';
$TEXT['TEMPLATE_PERMISSIONS'] = 'Άδειες Προτύπων';
$TEXT['TEXT'] = 'Κείμενο';
$TEXT['TEXTAREA'] = 'Περιοχή κειμένου';
$TEXT['TEXTFIELD'] = 'Πεδίο κειμένου';
$TEXT['THEME'] = 'Διαχείριση θέματος';
$TEXT['THEME_COPY_CURRENT'] = 'Αντιγραφή διαχείρισης θέματος.';
$TEXT['THEME_NEW_NAME'] = 'Όνομα του νέου θέματος';
$TEXT['THEME_CURRENT'] = 'τρέχον ενεργό θέμα';
$TEXT['THEME_START_COPY'] = 'αντιγραφή';
$TEXT['THEME_IMPORT_HTT'] = 'Εισαγωγή πρόσθετων προτύπων';
$TEXT['THEME_SELECT_HTT'] = 'επιλέξτε πρότυπα';
$TEXT['THEME_NOMORE_HTT'] = 'δεν είναι πλέον διαθέσιμο';
$TEXT['THEME_START_IMPORT'] = 'εισαγωγή';
$TEXT['TIME'] = 'Χρόνος';
$TEXT['TIMEZONE'] = 'Ζώνη ώρας';
$TEXT['TIME_FORMAT'] = 'Μορφή ώρας';
$TEXT['TIME_LIMIT'] = 'Μέγιστος χρόνος συλλογής αποσπασμάτων ανά ενότητα';
$TEXT['TITLE'] = 'Τίτλος';
$TEXT['TO'] = 'Προς το';
$TEXT['TOP_FRAME'] = 'Κορυφαίο Πλαίσιο';
$TEXT['TRASH_EMPTIED'] = 'Ο Κάδος Άδειασε';
$TEXT['TXT_EDIT_CSS_FILE'] = 'Επεξεργαστείτε τους ορισμούς CSS στην παρακάτω περιοχή κειμένου.';
$TEXT['TYPE'] = 'Τύπος';
$TEXT['UNDER_CONSTRUCTION'] = 'Υπό Κατασκευή';
$TEXT['UNINSTALL'] = 'Κατάργηση εγκατάστασης';
$TEXT['UNKNOWN'] = 'Ανώνυμος';
$TEXT['UNLIMITED'] = 'Απεριόριστος';
$TEXT['UNZIP_FILE'] = 'Ανεβάστε και αποσυσκευάστε ένα αρχείο zip';
$TEXT['UP'] = 'Πάνω';
$TEXT['UPGRADE'] = 'Αναβαθμίζω';
$TEXT['UPLOAD_FILES'] = 'Μεταφόρτωση αρχείου(-ων)';
$TEXT['URL'] = 'Διεύθυνση URL';
$TEXT['USER'] = 'Χρήστης';
$TEXT['USERNAME'] = 'Όνομα σύνδεσης';
$TEXT['USERS_ACTIVE'] = 'Ο Χρήστης είναι ενεργός';
$TEXT['USERS_CAN_SELFDELETE'] = 'Ο χρήστης μπορεί να διαγράψει τον εαυτό του';
$TEXT['USERS_CHANGE_SETTINGS'] = 'Ο χρήστης μπορεί να αλλάξει τις δικές του ρυθμίσεις';
$TEXT['USERS_DELETED'] = 'Ο χρήστης επισημαίνεται ως διαγραμμένος';
$TEXT['USERS_FLAGS'] = 'Σημαίες-Χρήστης';
$TEXT['USERS_PROFILE_ALLOWED'] = 'Ο χρήστης μπορεί να δημιουργήσει εκτεταμένο προφίλ';
$TEXT['VERIFICATION'] = 'Επαλήθευση';
$TEXT['VERSION'] = 'Έκδοση';
$TEXT['VIEW'] = 'Θέα';
$TEXT['VIEW_DELETED_PAGES'] = 'Προβολή Διαγραμμένων Σελίδων';
$TEXT['VIEW_DETAILS'] = 'Δείτε Λεπτομέρειες';
$TEXT['VISIBILITY'] = 'Ορατότητα';
$TEXT['WBMAILER_DEFAULT_SENDER_MAIL'] = 'Προεπιλογή Από Αλληλογραφία';
$TEXT['WBMAILER_DEFAULT_SENDER_NAME'] = 'Προεπιλεγμένο Όνομα Αποστολέα';
$TEXT['WBMAILER_DEFAULT_SETTINGS_NOTICE'] = 'Καθορίστε μια προεπιλεγμένη διεύθυνση "FROM" και το όνομα "SENDER" παρακάτω. Συνιστάται να χρησιμοποιήσετε μια διεύθυνση FROM όπως: <strong> admin@ yourdomain.com.com </strong>. Ορισμένοι πάροχοι αλληλογραφίας (π.χ. <em> mail.com </em>) ενδέχεται να απορρίψουν μηνύματα με FROM: διεύθυνση όπως <em> name@mail.com </em> που αποστέλλονται μέσω ξένου ρελέ για αποφυγή ανεπιθύμητων μηνυμάτων. <br /> <br /> Οι προεπιλεγμένες τιμές χρησιμοποιούνται μόνο εάν δεν καθορίζονται άλλες τιμές από το WBCE CMS';
$TEXT['WBMAILER_FUNCTION'] = 'Ρουτίνα Αλληλογραφίας';
$TEXT['WBMAILER_NOTICE'] = '<strong> SMTP Mailer Settings: </strong> <br /> Οι παρακάτω ρυθμίσεις απαιτούνται μόνο εάν θέλετε να στείλετε μηνύματα μέσω <abbr title = "Simple mail transfer protocol"> SMTP </abbr>. Εάν δεν γνωρίζετε τον κεντρικό υπολογιστή SMTP ή δεν είστε σίγουροι για τις απαιτούμενες ρυθμίσεις, απλώς μείνετε στην προεπιλεγμένη ρουτίνα αλληλογραφίας: PHP MAIL.';
$TEXT['WBMAILER_PHP'] = 'PHP MAIL';
$TEXT['WBMAILER_SMTP'] = 'SMTP';
$TEXT['WBMAILER_SMTP_AUTH'] = 'Έλεγχος ταυτότητας SMTP';
$TEXT['WBMAILER_SMTP_AUTH_NOTICE'] = 'ενεργοποίηση μόνο εάν ο κεντρικός υπολογιστής SMTP απαιτεί έλεγχο ταυτότητας';
$TEXT['WBMAILER_SMTP_HOST'] = 'SMTP Πλήθος';
$TEXT['WBMAILER_SMTP_PASSWORD'] = 'SMTP Κωδικός Πρόσβασης';
$TEXT['WBMAILER_SMTP_USERNAME'] = 'SMTP Όνομα σύνδεσης';
$TEXT['WEBSITE'] = 'Ιστότοπος';
$TEXT['WEBSITE_DESCRIPTION'] = 'Περιγραφή Ιστότοπου';
$TEXT['WEBSITE_FOOTER'] = 'Υποσέλιδο Ιστότοπου';
$TEXT['WEBSITE_HEADER'] = 'Κεφαλίδα Ιστοτόπου';
$TEXT['WEBSITE_KEYWORDS'] = 'Λέξεις-κλειδιά Ιστότοπου';
$TEXT['WEBSITE_TITLE'] = 'Τίτλος Ιστότοπου';
$TEXT['WELCOME_BACK'] = 'Καλώς όρισες πίσω';
$TEXT['WIDTH'] = 'Πλάτος';
$TEXT['WINDOW'] = 'Παράθυρο';
$TEXT['WINDOWS'] = 'Παράθυρα';
$TEXT['WORLD_WRITEABLE_FILE_PERMISSIONS'] = 'Παγκόσμια δικαιώματα εγγραφής αρχείων';
$TEXT['WRITE'] = 'Γράφω';
$TEXT['WYSIWYG_EDITOR'] = 'Πρόγραμμα επεξεργασίας WYSIWYG';
$TEXT['WYSIWYG_STYLE'] = 'Στυλ WYSIWYG';
$TEXT['YES'] = 'Ναι';


$HEADING['ADDON_PRECHECK_FAILED'] = 'Δεν πληρούνται οι απαιτήσεις πρόσθετου';
$HEADING['ADD_CHILD_PAGE'] = 'Προσθήκη θυγατρικής σελίδας';
$HEADING['ADD_GROUP'] = 'Προσθήκη Oμάδας';
$HEADING['ADD_GROUPS'] = 'Προσθήκη Oμάδων';
$HEADING['ADD_HEADING'] = 'Προσθήκη Επικεφαλίδας';
$HEADING['ADD_PAGE'] = 'Προσθήκη Σελίδας';
$HEADING['ADD_USER'] = 'Προσθήκη Χρήστη';
$HEADING['ADMINISTRATION_TOOLS'] = 'Εργαλεία Διαχείρισης';
$HEADING['BROWSE_MEDIA'] = 'Αναζήτηση Πολυμέσων';
$HEADING['CREATE_FOLDER'] = 'Δημιουργία Φακέλου';
$HEADING['DEFAULT_SETTINGS'] = 'Προεπιλεγμένες Ρυθμίσεις';
$HEADING['DELETED_PAGES'] = 'Διαγραμμένες Σελίδες';
$HEADING['FILESYSTEM_SETTINGS'] = 'Ρυθμίσεις Συστήματος Αρχείων';
$HEADING['GENERAL_SETTINGS'] = 'Γενικές Ρυθμίσεις';
$HEADING['INSTALL_LANGUAGE'] = 'Εγκατάσταση Γλώσσας';
$HEADING['INSTALL_MODULE'] = 'Εγκατάσταση Μονάδας';
$HEADING['INSTALL_TEMPLATE'] = 'Εγκατάσταση Προτύπου';
$HEADING['INVOKE_LANGUAGE_FILES'] = 'Εκτελέστε μη αυτόματα αρχεία γλώσσας';
$HEADING['INVOKE_MODULE_FILES'] = 'Εκτελέστε χειροκίνητα αρχεία λειτουργικών μονάδων';
$HEADING['INVOKE_TEMPLATE_FILES'] = 'Εκτελέστε χειροκίνητα αρχεία προτύπων';
$HEADING['LANGUAGE_DETAILS'] = 'Λεπτομέρειες Γλώσσας';
$HEADING['MANAGE_SECTIONS'] = 'Διαχείριση Ενοτήτων';
$HEADING['MODIFY_ADVANCED_PAGE_SETTINGS'] = 'Τροποποίηση Ρυθμίσεων Σελίδας για Προχωρημένους';
$HEADING['MODIFY_DELETE_GROUP'] = 'Τροποποίηση / Διαγραφή ομάδας';
$HEADING['MODIFY_DELETE_PAGE'] = 'Τροποποίηση / Διαγραφή Σελίδας';
$HEADING['MODIFY_DELETE_USER'] = 'Τροποποίηση / Διαγραφή Χρήστη';
$HEADING['MODIFY_GROUP'] = 'Τροποποίηση Ομάδας';
$HEADING['MODIFY_GROUPS'] = 'Τροποποίηση Ομάδων';
$HEADING['MODIFY_INTRO_PAGE'] = 'Τροποποίηση Εισαγωγικής Σελίδας';
$HEADING['MODIFY_PAGE'] = 'Τροποποίηση Σελίδας';
$HEADING['MODIFY_PAGE_SETTINGS'] = 'Τροποποίηση Ρυθμίσεων Σελίδας';
$HEADING['MODIFY_USER'] = 'Τροποποίηση Χρήστη';
$HEADING['MODULE_DETAILS'] = 'Λεπτομέρειες Ενότητας';
$HEADING['MY_EMAIL'] = 'Το Email μου';
$HEADING['MY_PASSWORD'] = 'Ο Κωδικός μου';
$HEADING['MY_SETTINGS'] = 'Οι Ρυθμίσεις μου';
$HEADING['SEARCH_SETTINGS'] = 'Ρυθμίσεις Αναζήτησης';
$HEADING['SERVER_SETTINGS'] = 'Ρυθμίσεις Διακομιστή';
$HEADING['TEMPLATE_DETAILS'] = 'Λεπτομέρειες Προτύπου';
$HEADING['UNINSTALL_LANGUAGE'] = 'Απεγκατάσταση Γλώσσας';
$HEADING['UNINSTALL_MODULE'] = 'Απεγκαταστήστε το Module';
$HEADING['UNINSTALL_TEMPLATE'] = 'Απεγκατάσταση Προτύπου';
$HEADING['UPGRADE_LANGUAGE'] = 'Γλωσσικό μητρώο / Αναβάθμιση';
$HEADING['UPLOAD_FILES'] = 'Μεταφόρτωση αρχείου(-ων)';
$HEADING['WBMAILER_SETTINGS'] = 'Ρυθμίσεις Αλληλογραφίας';
$HEADING['WBMAILER_CFG_OVERRIDE_HINT'] = '<b> ΠΑΡΑΚΑΛΩ ΣΗΜΕΙΩΣΗ: </b> αυτήν τη στιγμή οι παρακάτω ρυθμίσεις αλληλογραφίας παρακάμπτονται από ρυθμίσεις στο αρχείο <code> [WB_PATH] /include/PHPMailer/config_mail.php </code>. <br /> Για να χρησιμοποιήσετε τις ρυθμίσεις αλληλογραφίας παρακάτω, θα πρέπει να απενεργοποιήσετε τον πίνακα στο όνομα αρχείου.';
$MESSAGE['ADDON_ERROR_RELOAD'] = 'Σφάλμα κατά την ενημέρωση των Πρόσθετων πληροφοριών.';
$MESSAGE['ADDON_LANGUAGES_RELOADED'] = 'Οι Γλώσσες επαναφορτώθηκαν με επιτυχία';
$MESSAGE['ADDON_MANUAL_FTP_LANGUAGE'] = "<strong> ΠΡΟΣΟΧΗ! </strong> Για λόγους ασφαλείας, ανεβάζετε αρχεία γλωσσών στο φάκελο / γλώσσες / μόνο μέσω FTP και χρησιμοποιήστε τη λειτουργία Αναβάθμιση για εγγραφή ή ενημέρωση.";
$MESSAGE['ADDON_MANUAL_FTP_WARNING'] = 'Προειδοποίηση: Οι υπάρχουσες καταχωρήσεις βάσης δεδομένων της μονάδας θα χαθούν.';
$MESSAGE['ADDON_MANUAL_INSTALLATION'] = 'Όταν οι μονάδες φορτώνονται μέσω FTP (δεν συνιστάται), οι λειτουργίες εγκατάστασης της μονάδας <code> install </code>, <code> upgrade </code> ή <code> uninstall </code> δεν θα εκτελεστούν αυτόματα. Αυτές οι λειτουργικές μονάδες ενδέχεται να μην λειτουργούν σωστά ή να μην απεγκατασταθούν σωστά. <br /> <br /> Μπορείτε να εκτελέσετε τις λειτουργίες της λειτουργικής μονάδας με μη αυτόματο τρόπο για τις ενότητες που μεταφορτώνονται μέσω FTP παρακάτω.';
$MESSAGE['ADDON_MANUAL_INSTALLATION_WARNING'] = 'Προειδοποίηση: Οι υπάρχουσες καταχωρήσεις βάσης δεδομένων της μονάδας θα χαθούν. Χρησιμοποιήστε αυτήν την επιλογή μόνο εάν αντιμετωπίζετε προβλήματα με τις μονάδες που ανεβάζετε μέσω FTP.';
$MESSAGE['ADDON_MANUAL_RELOAD_WARNING'] = 'Προειδοποίηση: Οι υπάρχουσες καταχωρήσεις βάσης δεδομένων της μονάδας θα χαθούν.';
$MESSAGE['ADDON_MODULES_RELOADED'] = 'Οι ενότητες επαναφορτώθηκαν με επιτυχία';
$MESSAGE['ADDON_OVERWRITE_NEWER_FILES'] = 'Αντικατάσταση νεότερων Αρχείων';
$MESSAGE['ADDON_PRECHECK_FAILED'] = 'Η εγκατάσταση του πρόσθετου απέτυχε. Το σύστημά σας δεν πληροί τις απαιτήσεις αυτού του πρόσθετου. Για να λειτουργήσει αυτό το πρόσθετο στο σύστημά σας, διορθώστε τα ζητήματα που συνοψίζονται παρακάτω';
$MESSAGE['ADDON_RELOAD'] = 'Ενημέρωση βάσης δεδομένων με πληροφορίες από πρόσθετα αρχεία (π.χ. μετά την αποστολή FTP).';
$MESSAGE['ADDON_TEMPLATES_RELOADED'] = 'Τα πρότυπα επαναφορτώθηκαν με επιτυχία';
$MESSAGE['ADMIN_INSUFFICIENT_PRIVELLIGES'] = 'Ανεπαρκή προνόμια για να είστε εδώ';
$MESSAGE['FORGOT_PASS_ALREADY_RESET'] = 'Δεν είναι δυνατή η επαναφορά του κωδικού πρόσβασης περισσότερο από μία φορά ανά ώρα, συγγνώμη';
$MESSAGE['FORGOT_PASS_CANNOT_EMAIL'] = 'Δεν είναι δυνατή η αποστολή κωδικού πρόσβασης μέσω email, επικοινωνήστε με τον διαχειριστή του συστήματος';
$MESSAGE['FORGOT_PASS_EMAIL_NOT_FOUND'] = 'Το email που εισαγάγατε δεν μπορεί να βρεθεί στη βάση δεδομένων';
$MESSAGE['FORGOT_PASS_NO_DATA'] = 'Παρακαλώ εισάγετε τη διεύθυνση email σας παρακάτω';
$MESSAGE['FORGOT_PASS_PASSWORD_RESET'] = 'Το όνομα χρήστη και ο κωδικός πρόσβασής σας έχουν σταλεί στη διεύθυνση email σας';
$MESSAGE['FRONTEND_SORRY_NO_ACTIVE_SECTIONS'] = 'Λυπούμαστε, δεν υπάρχει ενεργό περιεχόμενο για προβολή';
$MESSAGE['FRONTEND_SORRY_NO_VIEWING_PERMISSIONS'] = 'Δυστυχώς, δεν έχετε δικαιώματα προβολής αυτής της σελίδας';
$MESSAGE['GENERIC_ALREADY_INSTALLED'] = 'Ηδη εγκατεστημένο';
$MESSAGE['GENERIC_BAD_PERMISSIONS'] = 'Δεν είναι δυνατή η εγγραφή στον κατάλογο προορισμού';
$MESSAGE['GENERIC_BE_PATIENT'] = 'Παρακαλώ να είστε υπομονετικοί.';
$MESSAGE['GENERIC_CANNOT_UNINSTALL'] = 'Η κατάργηση της εγκατάστασης απέτυχε ή δεν επιτρέπεται.';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_CORE_MODULES'] = 'Δεν είναι δυνατή η απεγκατάσταση βασικών ενοτήτων!';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_IN_USE'] = 'Δεν είναι δυνατή η Απεγκατάσταση: το επιλεγμένο αρχείο χρησιμοποιείται';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_IN_USE_TMPL'] =' Δεν ήταν δυνατή η απεγκατάσταση του {<br /> <br /> {{type}} <b> {{type_name}} </b>, επειδή εξακολουθεί να χρησιμοποιείται σε {{pages}}. <br /> ';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_IN_USE_TMPL_PAGES'] = 'αυτή τη σελίδα · αυτές τις σελίδες';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_IS_DEFAULT_TEMPLATE'] = 'Δεν είναι δυνατή η απεγκατάσταση του προτύπου <b> {{name}} </b>, επειδή είναι το προεπιλεγμένο πρότυπο!';
$MESSAGE['GENERIC_CANNOT_UNINSTALL_IS_DEFAULT_THEME'] = 'Δεν είναι δυνατή η απεγκατάσταση του προτύπου <b> {{name}} </b>, επειδή είναι το προεπιλεγμένο θέμα backend!';
$MESSAGE['GENERIC_CANNOT_UNZIP'] = 'Δεν είναι δυνατή η αποσυμπίεση του αρχείου';
$MESSAGE['GENERIC_CANNOT_UPLOAD'] = 'Δεν είναι δυνατή η μεταφόρτωση αρχείου';
$MESSAGE['GENERIC_COMPARE'] = 'επιτυχώς';
$MESSAGE['GENERIC_ERROR_OPENING_FILE'] = 'Σφάλμα κατά το άνοιγμα του αρχείου.';
$MESSAGE['GENERIC_FAILED_COMPARE'] = ' απέτυχε';
$MESSAGE['GENERIC_FILE_TYPE'] = 'Λάβετε υπόψη ότι το αρχείο που ανεβάζετε πρέπει να έχει την ακόλουθη μορφή:';
$MESSAGE['GENERIC_FILE_TYPES'] = 'Λάβετε υπόψη ότι το αρχείο που ανεβάζετε πρέπει να έχει μία από τις ακόλουθες μορφές:';
$MESSAGE['GENERIC_FILL_IN_ALL'] = 'Επιστρέψτε και συμπληρώστε όλα τα πεδία';
$MESSAGE['GENERIC_FORGOT_OPTIONS'] = 'Δεν έχετε επιλέξει καμία επιλογή!';
$MESSAGE['GENERIC_INSTALLED'] = 'Εγκαταστάθηκε με επιτυχία';
$MESSAGE['GENERIC_INVALID'] = 'Το αρχείο που ανεβάσατε δεν είναι έγκυρο';
$MESSAGE['GENERIC_INVALID_ADDON_FILE'] = 'Μη έγκυρο αρχείο εγκατάστασης WBCE CMS. Ελέγξτε τη μορφή * .zip.';
$MESSAGE['GENERIC_INVALID_LANGUAGE_FILE'] = 'Μη έγκυρο αρχείο γλώσσας WBCE CMS. Ελέγξτε το αρχείο κειμένου.';
$MESSAGE['GENERIC_INVALID_MODULE_FILE'] = 'Μη έγκυρο αρχείο λειτουργικής μονάδας WBCE CMS. Ελέγξτε το αρχείο κειμένου.';
$MESSAGE['GENERIC_INVALID_TEMPLATE_FILE'] = 'Μη έγκυρο αρχείο προτύπου WBCE CMS. Ελέγξτε το αρχείο κειμένου.';
$MESSAGE['GENERIC_IN_USE'] = ' αλλά χρησιμοποιείται σε';
$MESSAGE['GENERIC_MISSING_ARCHIVE_FILE'] = 'Λείπει αρχείο Αρχειοθέτησης!';
$MESSAGE['GENERIC_MODULE_VERSION_ERROR'] = 'Η μονάδα δεν έχει εγκατασταθεί σωστά!';
$MESSAGE['GENERIC_NOT_COMPARE'] = ' όχι πιθανώς';
$MESSAGE['GENERIC_NOT_INSTALLED'] = 'Μη εγκατεστημενο';
$MESSAGE['GENERIC_NOT_UPGRADED'] = 'Όχι πιθανώς η ενεργοποίηση';
$MESSAGE['GENERIC_PLEASE_BE_PATIENT'] = 'Να είστε υπομονετικοί, μπορεί να χρειαστεί λίγη ώρα.';
$MESSAGE['GENERIC_PLEASE_CHECK_BACK_SOON'] = 'Ελέγξτε ξανά σύντομα ...';
$MESSAGE['GENERIC_SECURITY_ACCESS'] = 'Αδίκημα ασφαλείας! Δεν επιτρέπεται η πρόσβαση!';
$MESSAGE['GENERIC_SECURITY_OFFENSE'] = 'Αδίκημα ασφαλείας! Η αποθήκευση δεδομένων απορρίφθηκε!';
$MESSAGE['GENERIC_UNINSTALLED'] = 'Απεγκαταστάθηκε με επιτυχία';
$MESSAGE['GENERIC_UPGRADED'] = 'Αναβαθμίστηκε με επιτυχία';
$MESSAGE['GENERIC_VERSION_COMPARE'] = 'Σύγκριση έκδοσης';
$MESSAGE['GENERIC_VERSION_GT'] = 'Απαιτείται αναβάθμιση!';
$MESSAGE['GENERIC_VERSION_LT'] = 'Κατηφορικός';
$MESSAGE['GENERIC_WEBSITE_UNDER_CONSTRUCTION'] = 'Ιστοσελίδα Υπό Κατασκευή';
$MESSAGE['GENERIC_WEBSITE_LOCKED'] = 'Αυτός ο ιστότοπος είναι προσωρινά εκτός λειτουργίας για συντήρηση';
$MESSAGE['GROUP_HAS_MEMBERS'] = 'Αυτή η ομάδα έχει ακόμη μέλη.';
$MESSAGE['GROUPS_ADDED'] = 'Η ομάδα προστέθηκε με επιτυχία';
$MESSAGE['GROUPS_CONFIRM_DELETE'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε την επιλεγμένη ομάδα;(Μπορούν να διαγραφούν μόνο ομάδες χωρίς χρήστες που έχουν εκχωρηθεί)';
$MESSAGE['GROUPS_DELETED'] = 'Η ομάδα διαγράφηκε με επιτυχία';
$MESSAGE['GROUPS_GROUP_NAME_BLANK'] = 'Το όνομα της ομάδας είναι κενό';
$MESSAGE['GROUPS_GROUP_NAME_EXISTS'] = 'Το όνομα ομάδας υπάρχει ήδη';
$MESSAGE['GROUPS_NO_GROUPS_FOUND'] = 'Δεν βρέθηκαν ομάδες';
$MESSAGE['GROUPS_SAVED'] = 'Η ομάδα αποθηκεύτηκε με επιτυχία';
$MESSAGE['LOGIN_AUTHENTICATION_FAILED'] = 'Λάθος όνομα σύνδεσης ή κωδικός πρόσβασης';
$MESSAGE['LOGIN_BOTH_BLANK'] = 'Εισαγάγετε το όνομα χρήστη και τον κωδικό πρόσβασής σας παρακάτω';
$MESSAGE['LOGIN_PASSWORD_BLANK'] = 'Εισαγάγετε έναν κωδικό πρόσβασης';
$MESSAGE['LOGIN_PASSWORD_TOO_LONG'] = 'Παρέχεται κωδικός πρόσβασης για μεγάλο χρονικό διάστημα';
$MESSAGE['LOGIN_PASSWORD_TOO_SHORT'] = 'Παρέχεται κωδικός για συντόμευση';
$MESSAGE['LOGIN_USERNAME_BLANK'] = 'Εισαγάγετε ένα όνομα χρήστη';
$MESSAGE['LOGIN_USERNAME_TOO_LONG'] = 'Παρέχεται όνομα χρήστη σε μεγάλο χρονικό διάστημα';
$MESSAGE['LOGIN_USERNAME_TOO_SHORT'] = 'Παρέχεται σύντομο όνομα σύνδεσης';
$MESSAGE['MEDIA_BLANK_EXTENSION'] = 'Δεν εισαγάγατε επέκταση αρχείου';
$MESSAGE['MEDIA_BLANK_NAME'] = 'You did not enter a new name';
$MESSAGE['MEDIA_CANNOT_DELETE_DIR'] = 'Δεν είναι δυνατή η διαγραφή του επιλεγμένου φακέλου';
$MESSAGE['MEDIA_CANNOT_DELETE_FILE'] = 'Δεν είναι δυνατή η διαγραφή του επιλεγμένου αρχείου';
$MESSAGE['MEDIA_CANNOT_RENAME'] = 'Μετονομασία ανεπιτυχής';
$MESSAGE['MEDIA_CONFIRM_DELETE'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε το ακόλουθο αρχείο ή φάκελο;';
$MESSAGE['MEDIA_DELETED_DIR'] = 'Ο φάκελος διαγράφηκε με επιτυχία';
$MESSAGE['MEDIA_DELETED_FILE'] = 'Το αρχείο διαγράφηκε με επιτυχία';
$MESSAGE['MEDIA_DIR_ACCESS_DENIED'] = 'Ο καθορισμένος κατάλογος δεν υπάρχει ή δεν επιτρέπεται.';
$MESSAGE['MEDIA_DIR_DOES_NOT_EXIST'] = 'Ο κατάλογος δεν υπάρχει';
$MESSAGE['MEDIA_DIR_DOT_DOT_SLASH'] = 'Δεν είναι δυνατή η συμπερίληψη ../ στο όνομα του φακέλου ';
$MESSAGE['MEDIA_DIR_EXISTS'] = 'Υπάρχει ήδη ένας φάκελος που ταιριάζει με το όνομα που εισαγάγατε';
$MESSAGE['MEDIA_DIR_MADE'] = 'Ο φάκελος δημιουργήθηκε με επιτυχία';
$MESSAGE['MEDIA_DIR_NOT_MADE'] = 'Δεν είναι δυνατή η δημιουργία φακέλου';
$MESSAGE['MEDIA_FILE_EXISTS'] = 'Υπάρχει ήδη ένα αρχείο που ταιριάζει με το όνομα που εισαγάγατε';
$MESSAGE['MEDIA_FILE_NOT_FOUND'] = 'Το αρχείο δε βρέθηκε';
$MESSAGE['MEDIA_NAME_DOT_DOT_SLASH'] = 'Δεν είναι δυνατή η συμπερίληψη ../ στο όνομα';
$MESSAGE['MEDIA_NAME_INDEX_PHP'] = 'Δεν είναι δυνατή η χρήση του index.php ως όνομα';
$MESSAGE['MEDIA_NO_FILE_UPLOADED'] = 'Δεν ελήφθη αρχείο';
$MESSAGE['MEDIA_NONE_FOUND'] = 'Δεν βρέθηκαν μέσα στον τρέχοντα φάκελο';
$MESSAGE['MEDIA_RENAMED'] = 'Μετονομασία επιτυχής';
$MESSAGE['MEDIA_SINGLE_UPLOADED'] = ' το αρχείο μεταφορτώθηκε με επιτυχία';
$MESSAGE['MEDIA_TARGET_DOT_DOT_SLASH'] = 'Δεν είναι δυνατή η ../ στο στόχο φακέλου';
$MESSAGE['MEDIA_UPLOADED'] = ' τα αρχεία μεταφορτώθηκαν με επιτυχία';
$MESSAGE['MOD_FORM_EXCESS_SUBMISSIONS'] = 'Δυστυχώς, αυτή η φόρμα έχει υποβληθεί πάρα πολλές φορές αυτήν την ώρα. Δοκιμάστε ξανά την επόμενη ώρα.';
$MESSAGE['MOD_FORM_INCORRECT_CAPTCHA'] = 'Ο αριθμός επαλήθευσης (επίσης γνωστός ως Captcha) που εισαγάγατε είναι λανθασμένος. Εάν αντιμετωπίζετε προβλήματα με την ανάγνωση του Captcha, στείλτε μήνυμα ηλεκτρονικού ταχυδρομείου: <a href="mailto:{SERVER_EMAIL}"> {SERVER_EMAIL} </a>';
$MESSAGE ['MOD_FORM_REQUIRED_FIELDS'] = 'Πρέπει να εισαγάγετε λεπτομέρειες για τα ακόλουθα πεδία';
$MESSAGE['PAGES_ADDED'] = 'Page added successfully';
$MESSAGE['PAGES_ADDED_HEADING'] = 'Η επικεφαλίδα της σελίδας προστέθηκε με επιτυχία';
$MESSAGE['PAGES_BLANK_MENU_TITLE'] = 'Εισαγάγετε έναν τίτλο μενού';
$MESSAGE['PAGES_BLANK_PAGE_TITLE'] = 'Εισαγάγετε έναν τίτλο σελίδας';
$MESSAGE['PAGES_CANNOT_CREATE_ACCESS_FILE'] = 'Σφάλμα κατά τη δημιουργία αρχείου πρόσβασης στον κατάλογο / pages (ανεπαρκή δικαιώματα)';
$MESSAGE['PAGES_CANNOT_DELETE_ACCESS_FILE'] = 'Σφάλμα κατά τη διαγραφή του αρχείου πρόσβασης στον κατάλογο / pages (ανεπαρκή δικαιώματα)';
$MESSAGE['PAGES_CANNOT_REORDER'] = "Σφάλμα αναδιάταξης σελίδας";
$MESSAGE['PAGES_DELETED'] = 'Η σελίδα διαγράφηκε με επιτυχία';
$MESSAGE['PAGES_DELETE_CONFIRM'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε την επιλεγμένη σελίδα (και όλες τις υποσελίδες της)';
$MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'] = 'Δεν έχετε δικαιώματα τροποποίησης αυτής της σελίδας';
$MESSAGE['PAGES_INTRO_LINK'] = 'Κάντε κλικ ΕΔΩ για να τροποποιήσετε τη σελίδα εισαγωγής';
$MESSAGE['PAGES_INTRO_NOT_WRITABLE'] = 'Δεν είναι δυνατή η εγγραφή στο αρχείο /pages/intro.php (ανεπαρκή δικαιώματα)';
$MESSAGE['PAGES_INTRO_SAVED'] = 'Η σελίδα εισαγωγής αποθηκεύτηκε με επιτυχία';
$MESSAGE['PAGES_LAST_MODIFIED'] = 'Τελευταία τροποποίηση από';
$MESSAGE['PAGES_NOT_FOUND'] = 'Η σελίδα δεν βρέθηκε';
$MESSAGE['PAGES_NOT_SAVED'] = 'Σφάλμα κατά την αποθήκευση της σελίδας';
$MESSAGE['PAGES_PAGE_EXISTS'] = 'Υπάρχει μια σελίδα με τον ίδιο ή παρόμοιο τίτλο';
$MESSAGE['PAGES_REORDERED'] = 'Η σελίδα αναδιατάχθηκε με επιτυχία';
$MESSAGE['PAGES_RESTORED'] = 'Η σελίδα αποκαταστάθηκε με επιτυχία';
$MESSAGE['PAGES_RETURN_TO_PAGES'] = 'Επιστροφή στις σελίδες';
$MESSAGE['PAGES_SAVED'] = 'Η σελίδα αποθηκεύτηκε με επιτυχία';
$MESSAGE['PAGES_SAVED_SETTINGS'] = 'Οι ρυθμίσεις σελίδας αποθηκεύτηκαν με επιτυχία';
$MESSAGE['PAGES_SECTIONS_PROPERTIES_SAVED'] = 'Οι ιδιότητες ενότητας αποθηκεύτηκαν με επιτυχία';
$MESSAGE['PREFERENCES_CURRENT_PASSWORD_INCORRECT'] = 'Ο κωδικός πρόσβασης που εισαγάγατε είναι λανθασμένος. <br /> <b> Πρέπει να επιβεβαιώσετε με τον τρέχοντα κωδικό πρόσβασής σας </b>.';
$MESSAGE['PREFERENCES_DETAILS_SAVED'] = 'Οι λεπτομέρειες αποθηκεύτηκαν με επιτυχία';
$MESSAGE['PREFERENCES_EMAIL_UPDATED'] = 'Το email ενημερώθηκε με επιτυχία';
$MESSAGE['PREFERENCES_INVALID_CHARS'] = 'Χρησιμοποιήθηκαν μη έγκυροι χαρακτήρες κωδικού πρόσβασης';
$MESSAGE['PREFERENCES_PASSWORD_CHANGED'] = 'Ο κωδικός άλλαξε επιτυχώς';
$MESSAGE['RECORD_MODIFIED_FAILED'] = 'Η αλλαγή του δίσκου έχασε.';
$MESSAGE['RECORD_MODIFIED_SAVED'] = 'Η αλλαγή εγγραφής ενημερώθηκε με επιτυχία.';
$MESSAGE['RECORD_NEW_FAILED'] = 'Η προσθήκη νέας εγγραφής έχει χάσει.';
$MESSAGE['RECORD_NEW_SAVED'] = 'Νέα εγγραφή προστέθηκε με επιτυχία.';
$MESSAGE['SETTINGS_MODE_SWITCH_WARNING'] = 'Σημείωση: Πατώντας αυτό το κουμπί επαναφέρετε όλες τις μη αποθηκευμένες αλλαγές';
$MESSAGE['SETTINGS_SAVED'] = 'Οι ρυθμίσεις αποθηκεύτηκαν με επιτυχία';
$MESSAGE['SETTINGS_UNABLE_OPEN_CONFIG'] = 'Δεν είναι δυνατό το άνοιγμα του αρχείου διαμόρφωσης';
$MESSAGE['SETTINGS_UNABLE_WRITE_CONFIG'] = 'Δεν είναι δυνατή η εγγραφή στο αρχείο διαμόρφωσης';
$MESSAGE['SETTINGS_WORLD_WRITEABLE_WARNING'] = 'Σημείωση: αυτό συνιστάται μόνο για δοκιμές σε περιβάλλοντα';
$MESSAGE['SIGNUP2_ADMIN_INFO'] = '
Καταγράφηκε ένας νέος χρήστης.

Loginname: {LOGIN_NAME}
UserId: {LOGIN_ID}
E-Mail: {LOGIN_EMAIL}
IP-Adress: {LOGIN_IP}
Registration date: {SIGNUP_DATE}

----------------------------------------
This message was automatic generated!';
$MESSAGE['SIGNUP2_BODY_LOGIN_FORGOT'] = '
Γεια σας {LOGIN_DISPLAY_NAME},

This mail was sent because the forgot password function has been applied to your account.

Your new {LOGIN_WEBSITE_TITLE} login details are:

Loginname: {LOGIN_NAME}
Password: {LOGIN_PASSWORD}

Your password has been reset to the one above.
This means that your old password will no longer work anymore!
If you\'ve got any questions or problems within the new login-data
you should contact the website-team or the admin of {LOGIN_WEBSITE_TITLE}.
Please remember to clean you browser-cache before using the new one to avoid unexpected fails.

------------------------------------
This message was automatic generated';
$MESSAGE['SIGNUP2_BODY_LOGIN_INFO'] = '
Γεια σας {LOGIN_DISPLAY_NAME},

Welcome to our {LOGIN_WEBSITE_TITLE}.

Your {LOGIN_WEBSITE_TITLE} login details are:
Loginname: {LOGIN_NAME}
Password: {LOGIN_PASSWORD}

Please:
if you have received this message by an error, please delete it immediately!

-------------------------------------
This message was automatic generated!';
$MESSAGE['SIGNUP2_SUBJECT_LOGIN_INFO'] = 'Τα στοιχεία σύνδεσής σας ...';
$MESSAGE['SIGNUP_NO_EMAIL'] = 'Πρέπει να εισαγάγετε μια διεύθυνση email';
$MESSAGE['START_CURRENT_USER'] = 'Αυτήν τη στιγμή είστε συνδεδεμένοι ως:';
$MESSAGE['START_INSTALL_DIR_EXISTS'] = 'Προειδοποίηση, Ο Κατάλογος Εγκατάστασης Εξακολουθεί να Υπάρχει!';
$MESSAGE['START_UPGRADE_SCRIPT_EXISTS'] = 'Διαγράψτε το αρχείο "upgrade-script.php" από το χώρο σας.';
$MESSAGE['START_WELCOME_MESSAGE'] = 'Καλώς ήλθατε στο WBCE CMS Administration';
$MESSAGE['TEMPLATES_CHANGE_TEMPLATE_NOTICE'] = 'Σημείωση: για να αλλάξετε το πρότυπο πρέπει να μεταβείτε στην ενότητα Ρυθμίσεις';
$MESSAGE['TESTMAIL_SUCCESS'] = "Το δοκιμαστικό email εστάλη στο <code>% s </code>. Ελέγξτε τα εισερχόμενά σας.";
$MESSAGE['TESTMAIL_FAILURE'] = "Δεν ήταν δυνατή η αποστολή του δοκιμαστικού email στο <code>% s </code>. <br /> Ελέγξτε τις ρυθμίσεις σας και δοκιμάστε ξανά.";
$MESSAGE['THEME_COPY_CURRENT'] = 'Αντιγράψτε το τρέχον ενεργό θέμα και αποθηκεύστε το με νέο όνομα.';
$MESSAGE['THEME_ALREADY_EXISTS'] = 'Αυτός ο νέος περιγραφέας θέματος υπάρχει ήδη.';
$MESSAGE['THEME_INVALID_SOURCE_DESTINATION'] = 'Μη έγκυρος περιγραφέας για το νέο θέμα που δόθηκε!';
$MESSAGE['THEME_DESTINATION_READONLY'] = 'Δεν υπάρχουν δικαιώματα δημιουργίας νέου καταλόγου θεμάτων!';
$MESSAGE['THEME_IMPORT_HTT'] = 'Εισαγάγετε πρόσθετα πρότυπα στο τρέχον ενεργό θέμα. <br /> Χρησιμοποιήστε αυτά τα πρότυπα για να αντικαταστήσετε το αντίστοιχο προεπιλεγμένο πρότυπο.';
$MESSAGE['UPLOAD_ERR_OK'] = 'Το αρχείο μεταφορτώθηκε με επιτυχία';
$MESSAGE['UPLOAD_ERR_INI_SIZE'] = 'Το μεταφορτωμένο αρχείο υπερβαίνει την οδηγία upload_max_filesize στο php.ini';
$MESSAGE['UPLOAD_ERR_FORM_SIZE'] = 'Το μεταφορτωμένο αρχείο υπερβαίνει την οδηγία MAX_FILE_SIZE που καθορίστηκε στη φόρμα HTML ';
$MESSAGE['UPLOAD_ERR_PARTIAL'] = 'Το μεταφορτωμένο αρχείο μεταφορτώθηκε μόνο εν μέρει';
$MESSAGE['UPLOAD_ERR_NO_FILE'] = 'Δεν μεταφορτώθηκε κανένα αρχείο';
$MESSAGE['UPLOAD_ERR_NO_TMP_DIR'] = 'Λείπει ένας προσωρινός φάκελος';
$MESSAGE['UPLOAD_ERR_CANT_WRITE'] = 'Αποτυχία εγγραφής αρχείου στο δίσκο';
$MESSAGE['UPLOAD_ERR_EXTENSION'] = 'Η μεταφόρτωση αρχείου σταμάτησε κατά επέκταση';
$MESSAGE['UNKNOW_UPLOAD_ERROR'] = 'Άγνωστο σφάλμα μεταφόρτωσης';
$MESSAGE['USERS_ADDED'] = 'Ο χρήστης προστέθηκε με επιτυχία';
$MESSAGE['USERS_CANT_SELFDELETE'] = 'Η λειτουργία απορρίφθηκε, Δεν μπορείτε να διαγράψετε τον εαυτό σας!';
$MESSAGE['USERS_CHANGING_PASSWORD'] = 'Σημείωση: εισαγάγετε τιμές στα παραπάνω πεδία μόνο εάν θέλετε να αλλάξετε τον κωδικό πρόσβασης';
$MESSAGE['USERS_CONFIRM_DELETE'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε τον επιλεγμένο χρήστη;';
$MESSAGE['USERS_DELETED'] = 'Ο χρήστης διαγράφηκε με επιτυχία';
$MESSAGE['USERS_EMAIL_TAKEN'] = 'Το email που εισαγάγατε χρησιμοποιείται ήδη';
$MESSAGE['USERS_INVALID_EMAIL'] = 'Η διεύθυνση ηλεκτρονικού ταχυδρομείου που εισάγατε δεν είναι έγκυρη';
$MESSAGE['USERS_NAME_INVALID_CHARS'] = 'Βρέθηκαν μη έγκυρες χαρακτήρες για το όνομα χρήστη';
$MESSAGE['USERS_NO_GROUP'] = 'Δεν επιλέχθηκε ομάδα';
$MESSAGE['USERS_PASSWORD_MISMATCH'] = 'Οι κωδικοί πρόσβασης που εισάγατε δεν ταιριάζουν';
$MESSAGE['USERS_PASSWORD_TOO_SHORT'] = 'Ο κωδικός πρόσβασης που εισαγάγατε ήταν πολύ μικρός';
$MESSAGE['USERS_SAVED'] = 'Ο χρήστης αποθηκεύτηκε με επιτυχία';
$MESSAGE['USERS_USERNAME_TAKEN'] = 'Το όνομα σύνδεσης που εισαγάγατε έχει ήδη ληφθεί';
$MESSAGE['USERS_USERNAME_TOO_SHORT'] = 'Το όνομα σύνδεσης που εισαγάγατε ήταν πολύ μικρό';
$MESSAGE['INVALID_SESSION_NAME'] = 'Το αναγνωριστικό περιόδου σύνδεσης που εισαγάγατε περιέχει μη έγκυρους χαρακτήρες. Επιτρέπονται μόνο μικρά γράμματα, αριθμοί και παύλα.';


$OVERVIEW['ADMINTOOLS'] = 'Πρόσβαση στα εργαλεία διαχείρισης WBCE CMS ...';
$OVERVIEW['GROUPS'] = 'Διαχείριση ομάδων χρηστών και των δικαιωμάτων συστήματος ...';
$OVERVIEW['HELP'] = 'Έχετε ερωτήσεις; Βρείτε την απάντησή σας ...';
$OVERVIEW['LANGUAGES'] = 'Διαχείριση γλωσσών WBCE CMS ...';
$OVERVIEW['MEDIA'] = 'Διαχείριση αρχείων που είναι αποθηκευμένα στο φάκελο πολυμέσων ...';
$OVERVIEW['MODULES'] = 'Διαχείριση μονάδων WBCE CMS ...';
$OVERVIEW['PAGES'] = 'Διαχείριση των σελίδων των ιστότοπών σας ...';
$OVERVIEW['PREFERENCES'] = 'Αλλαγή προτιμήσεων όπως διεύθυνση email, κωδικός πρόσβασης κ.λπ.';
$OVERVIEW['SETTINGS'] = 'Αλλάζει τις ρυθμίσεις για το WBCE CMS ...';
$OVERVIEW['START'] = 'Επισκόπηση διαχείρισης';
$OVERVIEW['TEMPLATES'] = 'Αλλάξτε την εμφάνιση και την αίσθηση του ιστότοπού σας με πρότυπα ...';
$OVERVIEW['USERS'] = 'Διαχείριση χρηστών που μπορούν να συνδεθούν στο WBCE CMS ...';
$OVERVIEW['VIEW'] = 'Γρήγορη προβολή και περιήγηση στον ιστότοπό σας σε νέο παράθυρο ...';
