<?php

/**

  @author          Christian M. Stefan
  @copyright       GPL v2

  DateTimePicker Class to easily implement XDSoft DateTimePicker in WBCE Addons

 **/

class DateTimePicker {

    public $_oReg           = null;
    public $sDateFormat     = ''; // Fetched date format
    public $sTimeFormat     = ''; // Fetched time format 
    public $sDateTimeFormat = ''; // Date and Time format combined
    public $selector        = '';
    public $datepicker      = true;
    public $timepicker      = true;
    public $time_range      = "full";
    public $mask            = false;
    public $step            = 60; // may be 1, 5, 10, 15 (between 1-60)
    public $lazyInit        = true;
    public $delete_date_handle = true;

    /**
      @brief The constructor takes care of loading the config array, 
      starting the Script if needed and fetch some default data.
      On a procedural call this takes care of reading the configuration array 
      into the class values.
      Then it loads in some default information as TimeFormat and DateFormat.
      And finally its starts inserting the content into the Template but only 
      on a procedural call.
      On an OOP call this only loads the defaults.

      @param array $aConfig The configuration array used on procedural calls.
     */
    public function __construct($aConfig = false) {
        if (is_array($aConfig)) {
            foreach ($aConfig as $Key => $Value) {
                $this->$Key = $Value;
            }
        }

        $this->sTimeFormat = $this->_getTimeFormat();
        $this->sDateFormat = $this->_getDateFormat();
        $this->sDateTimeFormat = $this->_getDTFormat();

        if (is_array($aConfig)) {
            $this->linkScriptsAndStylesheets();
        }
    }

    public function theme_icon($sIconName) {
        $sRetVal = WB_URL . '/templates/theme_fallbacks/icons/no-icon-found.png?' . $sIconName;
        $sIconLoc = THEME_PATH . '/icons/' . $sIconName;
        $sIconFallback = WB_PATH . '/templates/theme_fallbacks/icons/' . $sIconName;
        if (file_exists($sIconLoc)) {
            $sRetVal = get_url_from_path($sIconLoc);
        } elseif (file_exists($sIconFallback)) {
            $sRetVal = get_url_from_path($sIconFallback);
        }
        return $sRetVal;
    }

    /**
      @brief The Workhorse that does the actuall inserting.

      Inserts all necessary settings and configurations into the Template using the I(Insert) class
     */
    public function linkScriptsAndStylesheets() {
        // DateTimePicker CSS
        $cssFileUrl = get_url_from_path(__DIR__).'/XDSoftDateTimePicker/css/jquery.datetimepicker.css';
        I::insertCssFile($cssFileUrl);
        // DateTimePicker_overrides.css
        $cssOverrides = THEME_URL . '/css/date_time_picker_override.css';
        if (is_readable(str_replace(WB_URL, WB_PATH, $cssOverrides))) {
            I::insertCssFile($cssOverrides);
        }
        // DateTimePicker Plugin JS File
        $jsFile = get_url_from_path(__DIR__).'/XDSoftDateTimePicker/js/jquery.datetimepicker.full.min.js';
        I::insertJsFile($jsFile);

        $sPluginCfg = " lang: '" . strtolower(LANGUAGE) . "'";
        // take care of the leading comma (,) before each new setting
        $sPluginCfg .= ($this->mask == true) ? '", mask: "true' : '';
        $sPluginCfg .= ($this->lazyInit == true) ? ", lazyInit: 'true'" : '';
        $sPluginCfg .= ($this->step != 60) ? ", step: " . $this->step : '';

        if ($this->timepicker == false) {
            $sPluginCfg .= ", timepicker: 'false'";
        } else {
            $sPluginCfg .= ", formatTimeScroller: '" . $this->sTimeFormat . "'";
        }
        if ($this->datepicker == false) {
            $sPluginCfg .= ", datepicker: 'false'";
        }

        $sPluginCfg .= ", format: '" . $this->sDateTimeFormat . "'";
        //generate inlineJS from above string and add to Queue
        $bJsCodeLoaded = false;
        if ($this->selector != '') {
            global $TEXT;
            if ($bJsCodeLoaded == false) {
                $sJS = ("
                    var THEME_URL = '" . THEME_URL . "';
                    $(document).ready(function(){

                        $.datetimepicker.setLocale('" . strtolower(LANGUAGE) . "');
                        var DELETE_DATE = Boolean(" . $this->delete_date_handle . ");
                        var SELECTOR = $(\"[rel='" . $this->selector . "']\");
                        SELECTOR.datetimepicker({" . $sPluginCfg . "});

                        // add ICONS
                        SELECTOR.each(function() {		
                            var oInputField = this;
                            var sFieldID = this.getAttribute('id');
                            var CAL_ICON = ' <i class=\"fa fa-calendar showcal\" id=\"show_' + sFieldID + '\" title=\"" . $TEXT['CALENDAR'] . "\"></i>';
                            var RESET_ICON = ' <i class=\"fa fa-times reset_datetime\"  rel=\"reset_' + sFieldID + '\" title=\"" . $TEXT['CALENDAR'] . "\"></i>';
                            if(DELETE_DATE == false){ 
                                var RESET_ICON = '';
                            }
                            $(this).after('<span class=\"dtp-icons\">' + CAL_ICON + RESET_ICON + '</span>');
                            var RESET_ICON2 = $(\"img.reset[rel=\" + sFieldID + \"]\");
                            if($(this).val() == ''){
                                RESET_ICON2.css({ opacity: 0.2 });
                            }else{
                                RESET_ICON2.css('cursor', 'pointer').click(function() {
                                   $('input#' + sFieldID).val('');
                                   RESET_ICON2.css({ opacity: 0.8 });
                                });
                            }	
                            $('#show_' + sFieldID).css('cursor', 'pointer').click(function(){							
                              oInputField.focus();		
                            });		
                        });	

                        // empty date input
                        if(DELETE_DATE == true){
                            $('.reset_datetime').click(function () {
                                var FIELD = this.getAttribute('rel');
                                var ID = '#' + FIELD.replace('reset_', '');
                                $(ID).attr('value', '');
                            });
                        }					
                    });
                ");
                I::insertJsCode($sJS, 'BODY BTM-', 'datetimepicker');
            }
        }
    }

    /**
      @brief Fetches the time format from the WBCE enviroment
     */
    protected function _getTimeFormat() {
        $sFormat = '';
        if ($this->timepicker == true) {
            switch (TIME_FORMAT) {
                case "h:i a":   //  10:23 pm
                    $sFormat = 'h:i a';
                    break;
                case "h:i A":   //  10:23 PM
                    $sFormat = 'h:i A';
                    break;
                case "H:i":     // 22:23
                case "H:i:s":   // 22:23:39				
                default:
                    $sFormat = 'H:i';
                    break;
            }
        }
        return $this->sTimeFormat = $sFormat;
    }

    /**
      @brief Fetches the date format from the WB enviroment
     */
    protected function _getDateFormat() {
        $sFormat = '';
        if ($this->datepicker == true) {
            switch (DATE_FORMAT) {

                case 'm/d/Y':
                case 'm-d-Y':
                case 'D M d, Y':        // Mon May 26, 2015
                case 'M d Y':           // May 26 2015
                case 'm.d.Y':
                case 'Y-m-d':           // 2015/05/26 
                    $sFormat = 'm/d/Y'; // 02/15/2016 
                    break;
                /*
                  case 'Y-m-d':
                  $sFormat = 'Y-m-d';   // 2015/05/26
                  break;
                 */
                case 'd.m.Y':
                case 'd M Y':           // 26 May 2015
                case 'l, jS F, Y':      // Monday, 26th May, 2015
                case 'jS F, Y':         // 26th May, 2015
                case 'D M d, Y':
                case 'd-m-Y':
                case 'd/m/Y':
                case 'j.n.Y':
                default:
                    $sFormat = 'd.m.Y'; // 15.02.2016 
                    break;
            }
        }
        return $this->sDateFormat = $sFormat;
    }

    /**
      @brief Fetches the DTFormat from WBCE enviroment ???
     */
    protected function _getDTFormat($sFormat = '') {
        $sDate = $this->sDateFormat;
        $sTime = $this->sTimeFormat;
        if ($sDate != '' && $sTime != '') {
            $sFormat = $sDate . ' ' . $sTime;
        } else {
            $sFormat = $sDate . $sTime; // no space will be generated in string
        }
        return $this->sDateTimeFormat = $sFormat;
    }

    /**
      @brief - format the timestamp into a human readable shape using the preset Date/Time Format
     */
    public function reformatTimeStamp($sTimeStamp) {
        $sRetVal = ($sTimeStamp == 0 || $sTimeStamp == '') ? '' : date($this->sDateTimeFormat, $sTimeStamp + TIMEZONE);
        return $sRetVal;
    }

    /**
      @brief - Take the date string from the form field and convert it into a timestamp
     */
    public function strToTimestamp($sPickerString, $offset = '') {
        $sPickerString = trim($sPickerString);
        if ($sPickerString == '0' || $sPickerString == '')
            return('0');
        if ($offset == '0')
            $offset = '';

        if ($this->timepicker == true) {
            // convert given string to {yyyy-mm-dd} for use with strtotime function:			
            // "dd.mm.yyyy"?
            if (preg_match('/^\d{1,2}\.\d{1,2}\.\d{2}(\d{2})?/', $sPickerString)) {
                $sPickerString = preg_replace('/^(\d{1,2})\.(\	d{1,2})\.(\d{2}(\d{2})?)/', '$3-$2-$1', $sPickerString);
            }
            // "mm/dd/yyyy"?
            if (preg_match('#^\d{1,2}/\d{1,2}/(\d{2}(\d{2})?)#', $sPickerString)) {
                $sPickerString = preg_replace('#^(\d{1,2})/(\d{1,2})/(\d{2}(\d{2})?)#', '$3-$1-$2', $sPickerString);
            }
        }
        // apply strtotime()
        if ($offset != ''){
            return(strtotime($sPickerString, $offset) - TIMEZONE);
        } else {
            return(strtotime($sPickerString) - TIMEZONE);
        }
    }

}
