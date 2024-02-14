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
 * @brief      This extend is applying translation processing using 
 *             the function L_() to message strings and implements 
 *             class Insert methods for jQuery handling.
 *
 * @category   framework
 * @package    Message extend class for FlashMessages
 * @copyright  2015 Mike Everhart & PlasticBrain Media LLC for parent class
 * @copyright  Christian M. Stefan <stefek@designthings.de> for child class
 * @license    The MIT License (MIT)
 *
 *
 * The parent class can be found here:
 * https://github.com/plasticbrain/PhpFlashMessages
 * http://mikeeverhart.net/php-flash-messages/
 */


WbAuto::AddFile("FlashMessages", "/include/FlashMessages/src/FlashMessages.php"); // get parent class

class MessageBox extends FlashMessages
{
    public $ShowMissingKeys = true;


    public $closeBtn = '<button type="button" class="close" 
        data-dismiss="alert" 
        aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>';

    // Message types and order
    //
    // Note:  The order that message types are listed here is the same order
    // they will be printed on the screen (ie: when displaying all messages)
    //
    // This can be overridden with the display() method by manually defining
    // the message types in the order you want to display them. For example:
    //
    // $msg->display([$msg::SUCCESS, $msg::INFO, $msg::ERROR, $msg::WARNING])
    //
    public $cssClassMap = [
        self::INFO => 'alert alert-info',
        self::SUCCESS => 'alert alert-success',
        self::WARNING => 'alert alert-warning',
        self::ERROR => 'alert alert-danger',
    ];


    public $msgWrapper = "<div class='%s'>%s</div>\n";

    // Each message gets wrapped in this
    // protected $msgWrapper = '<div class="%s"><h4>%s</h4>%s</div>';


    public function fetchDisplay($mTypes = null)
    {
        return $this->display($mTypes = null, false);
    }

    /**
     * @brief  Display the flash messages
     *
     * @param mixed $mTypes (null)   print all of the message types
     *                      (array)  print the given message types
     *                      (string) print a single message type
     * @param bool $bPrint Whether to print the data or return it
     * @return string
     *
     */
    public function display($mTypes = null, $bPrint = true)
    {
        if (!isset($_SESSION['flash_messages'])) {
            return false;
        }

        $sRetVal = '';

        // Print all the message types
        if (is_null($mTypes) || !$mTypes || (is_array($mTypes) && empty($mTypes))) {
            $mTypes = array_keys($this->msgTypes);

            // Print multiple message types (as defined by an array)
        } elseif (is_array($mTypes) && !empty($mTypes)) {
            $theTypes = $mTypes;
            $mTypes = [];
            foreach ($theTypes as $type) {
                $mTypes[] = strtolower($type[0]);
            }

            // Print only a single message type
        } else {
            $mTypes = [strtolower($mTypes[0])];
        }

        // Retrieve and format the messages, then remove them from session data
        foreach ($mTypes as $type) {
            if (!isset($_SESSION['flash_messages'][$type]) || empty($_SESSION['flash_messages'][$type])) {
                continue;
            }
            foreach ($_SESSION['flash_messages'][$type] as $msgData) {
                if (
                    strpos($msgData['message'], ':') !== false
                ) {
                    $msgData['message'] = L_($msgData['message']);
                }
                $sRetVal .= $this->formatMessage($msgData, $type);
            }
            $this->clear($type);
        }

        // Print everything to the screen (or return the data)
        if ($bPrint) {
            echo $sRetVal;
        } else {
            return $sRetVal;
        }
    }

    /**
     * Format a message
     *
     * @param array $msgDataArray Array of message data
     * @param string $type The $msgType
     * @return string                 The formatted message
     *
     */
    protected function formatMessage($msgDataArray, $type)
    {
        $msgType = isset($this->msgTypes[$type]) ? $type : $this->defaultType;
        $cssClass = $this->msgCssClass . ' ' . $this->cssClassMap[$type];
        $msgBefore = $this->msgBefore;

        $iTimer = defined('REDIRECT_TIMER') ? REDIRECT_TIMER : 0;
        $iTimer = $iTimer > 10000 ? 10000 : $iTimer;

        $sToJs = "jQuery(document).ready(function($) {";
        $sToJs .= "   
        $('.close').on( 'click', function( event ) {
            $( event.target ).closest( '.dismissable' ).hide();
        });";

        // ERROR boxes are automatically set to "sticky"
        if ($msgDataArray['sticky'] || $msgType == 'e') {
            // If sticky then append the sticky CSS class
            $cssClass .= ' ' . $this->stickyCssClass;
            $msgBefore = $this->closeBtn . $msgBefore; // add close button to the MsgBox
        } else {
            // If it's not sticky let it disappear using REDIRECT_TIMER
            if ($iTimer != -1) {
                // timer isn't off, apply the fade off timer
                $sToJs .= "$('.dismissable').delay($iTimer).fadeOut('slow');";
            }
        }
        $sToJs .= "});";
        I::insertJsCode($sToJs, 'BODY BTM-', 'MessageBox');
        // Wrap the message if necessary
        $formattedMessage = $msgBefore . $msgDataArray['message'] . $this->msgAfter;

        if (defined('WB_FRONTEND')) {
            return sprintf(
                $this->msgWrapper,
                $cssClass,
                $formattedMessage
            );
        } else {
            $msgType = strtr($msgType, array(
                'w' => 'warning',
                'i' => 'info',
                's' => 'success',
                'e' => 'error',
            ));
            $aToTwig = array(
                'MESSAGES' => array($formattedMessage),
                'REDIRECT_URL' => '',
                'REDIRECT_TIME' => $iTimer,
                'USE_REDIRECT' => false,
                'MESSAGE_TYPE' => $msgType
            );
            ob_start();
            global $TEXT;
            $GLOBALS['admin']->getThemeFile('message_box.twig', $aToTwig);
            $sTmp = ob_get_clean();
            $sBox = str_replace('alertbox_' . $msgType, 'alertbox_' . $msgType . ' dismissable', $sTmp);

            return $sBox;
        }
    }

    /**
     * @brief  redirect or window location, depending on
     *         whether or not headers already sent
     *
     * @param string $sUrl
     * @return object $this
     */
    public function redirect($sUrl = '')
    {
        if ($sUrl != '') {
            if (!headers_sent()) {
                header('Location: ' . $sUrl);
                exit();
            } else {
                echo '<script>window.location="' . $sUrl . '";</script>';
            }
        }
        return $this;
    }

}
