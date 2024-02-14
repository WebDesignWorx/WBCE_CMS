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

// Prevent this file from being access directly
defined('WB_PATH') or die('Cannot access this file directly');

// Load Language Array
if (LANGUAGE_LOADED) {
    include __DIR__ .'/languages/EN.php';
    if (LANGUAGE != 'EN') {        
        if (is_readable($sLangFile = __DIR__.'/languages/'.LANGUAGE.'.php')) {
            include $sLangFile;
        }
    }
}
include_once ADMIN_PATH .'/pages/functions/functions.pageTree.php';
insertCssFile(theme_file('js/selectee/selectee.css'));
insertJsFile(theme_file('js/selectee/selectee.jquery.js'));

// get target page_id
$sql_result = $database->query("SELECT * FROM `{TP}mod_menu_link` WHERE `section_id` = ".$section_id);
$aData      = $sql_result->fetchRow(MYSQLI_ASSOC);

// Get list of all visible pages and build a page-tree
// get list of all page_ids and page_titles
global $aMenulinkTitles;
$aMenulinkTitles = array();
if ($query_page = $database->query("SELECT `page_id`, `menu_title` FROM `{TP}pages`")) {
    while ($page = $query_page->fetchRow(MYSQLI_ASSOC)) {
        $aMenulinkTitles[$page['page_id']] = $page['menu_title'];
    }
}

// Get list of targets
$aTargets = array();
$aLinks = pageTreeCombobox(nestedPagesArray(), $page_id);

foreach ($aLinks as $p) {
    if ($query_section = $database->query("SELECT `section_id`, `namesection` FROM `{TP}sections` WHERE `page_id` = ".$p['page_id']." ORDER BY `position`")) {
        while ($section = $query_section->fetchRow(MYSQLI_ASSOC)) {
            // get section-anchor
            if (defined('SEC_ANCHOR') && SEC_ANCHOR != '') {
                if (isset($section['namesection'])) {
                    $aTargets[$p['page_id']][] = "[#".SEC_ANCHOR.$section['section_id']."]  ".$section['namesection'];
                    continue;
                }
                $aTargets[$p['page_id']][] = '[#'.SEC_ANCHOR.$section['section_id'].'] ';
            } else {
                $aTargets[$p['page_id']] = array();
            }
        }
    }
}

?>
<form name="menulink" action="<?=WB_URL ?>/modules/menu_link/save.php" method="post">
    <input type="hidden" name="page_id" value="<?=$page_id ?>" />
    <input type="hidden" name="section_id" value="<?=$section_id ?>" />
    <?=$admin->getFTAN(); ?>
    <div class="cp-settings">
        <div class="cp-setting-row">
            <label class="cp-setting-name"><?=$TEXT['LINK'].'-'.$TEXT['TYPE'] ?></label>
            <div class="cp-setting-value">
                <input id="external_link" type="radio" name="linktype" value="ext" <?=($aData['target_page_id'] == '-1') ? 'checked' : ''?> /><label for="external_link"><?=$MOD_MENU_LINK['EXTERNAL_LINK']; ?></label>
                <input id="internal_link" type="radio" name="linktype" value="int" <?=($aData['target_page_id'] == '-1') ? '' : 'checked'?> /><label for="internal_link"><?=$MOD_MENU_LINK['INTERNAL_LINK']; ?></label>
            </div>
        </div>
        <div class="cp-setting-row" id="page_link_selection">
            <label class="cp-setting-name"><?= $TEXT['PAGE'] ?></label>
            <div class="cp-setting-value"><?php

                $sel = ' selected="selected"';
                ?>
                <select name="menu_link" id="parent_page" data-search-label="<?=$TEXT['SEARCH']?> ... [<?=$TEXT['PAGE']?>-ID, <?=$TEXT['MENU_TITLE']?>]">
                    <option value="0"<?= $aData['target_page_id'] == '0' ? $sel : '' ?>><?= $TEXT['PLEASE_SELECT']; ?> &hellip;</option>
                    <?php
                    foreach ($aLinks as $p) {
                        $flagIcon = WB_URL . '/languages/'.$p['language'].'.svg';

                        ?>
                        <option style="font-size:15px" value="<?= $p['page_id'] ?>" title="<?= $p['page_title'] ?>"
                        <?= ($p['page_id'] == $aData['target_page_id']) ? ' selected' : '' ?>
                                <?= ($p['page_id'] == $page_id) ? ' disabled' : '' ?>	data-right="<?= $p['page_id'] ?>" data-title="<?= $p['page_title'] ?>" data-class="type-<?= $p['visibility'] ?> mid-<?= $p['menu'] ?>" data-left="<?=$flagIcon?>"
                                ><?= $p['menu_title'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                &nbsp;
            </div>
        </div>
        <div class="cp-setting-row" id="external">
            <label class="cp-setting-name">URL</label>
            <div class="cp-setting-value">
                    <input type="text" name="extern" id="extern" value="<?=$aData['extern']; ?>" style="width:80%;" <?php if ($aData['target_page_id'] != '-1') {
            echo 'disabled="disabled"';
            } ?> />
            </div>
        </div>
        <div class="cp-setting-row" id="sec_anchor">
            <label class="cp-setting-name"><?=$TEXT['ANCHOR'] ?></label>
            <div class="cp-setting-value">
                    <select class="menuLink" name="anchor" id="page_target">
                    <?php
                        $sAnchor = $aData['anchor'] == '0' ? ' ':'[#'.$aData['anchor'].']';
                        if ((SEC_ANCHOR!="") && (strpos($aData['anchor'], SEC_ANCHOR) !== false)) {
                            $aTmp1 = explode(SEC_ANCHOR, $aData['anchor']);
                            $iSectionID = $aTmp1[1];
                            if ($sNameSection = $database->get_one("SELECT `namesection` FROM `{TP}sections` WHERE `section_id`=".$iSectionID)) {
                                $sAnchor = $sAnchor.' '.$sNameSection;
                            }
                        }
                    ?>
                    <option value="<?=$aData['anchor'] ?>" selected="selected"><?=$sAnchor ?></option>
                </select>
            </div>
        </div>
        <?php
        // get target-window for actual page
        $sTarget = $database->get_one("SELECT `target` FROM `{TP}pages` WHERE `page_id` = '$page_id'");
        ?>
        <div class="cp-setting-row">
            <label class="cp-setting-name"><?=$TEXT['TARGET'] ?></label>
            <div class="cp-setting-value">
                <select class="menuLink" name="target" id="target">
                    <option value="_blank"<?php if ($sTarget == '_blank') { echo ' selected="selected"'; } ?> data-right="_blank">&nbsp; <?=$TEXT['NEW_WINDOW'] ?></option>
                    <option value="_self"<?php  if ($sTarget == '_self') { echo ' selected="selected"'; } ?> data-right="_self">&nbsp; <?=$TEXT['SAME_WINDOW'] ?></option>
                    <option value="_top"<?php   if ($sTarget == '_top') { echo ' selected="selected"'; } ?> data-right="_top">&nbsp; <?=$TEXT['TOP_FRAME'] ?></option>
                </select>
            </div>
        </div>
        <div class="cp-setting-row">
            <label class="cp-setting-name"><?=$MOD_MENU_LINK['R_TYPE'] ?></label>
            <div class="cp-setting-value">
                <select class="menuLink" name="r_type" id="redirect">
                    <option value="301" data-right="301"<?php if ($aData['redirect_type'] == '301') { echo ' selected="selected"'; } ?> data-subtitle="<?=$MOD_MENU_LINK['R-301-INFO']?>"><?=$MOD_MENU_LINK['R-301']?></option>
                    <option value="302" data-right="302"<?php if ($aData['redirect_type'] == '302') { echo ' selected="selected"'; } ?> data-subtitle="<?=$MOD_MENU_LINK['R-302-INFO']?>"><?=$MOD_MENU_LINK['R-302']?></option>
                    <option value="200" data-right="200"<?php if ($aData['redirect_type'] == '200') { echo ' selected="selected"'; } ?> data-subtitle="<?=$MOD_MENU_LINK['R-200-INFO']?>"><?=$MOD_MENU_LINK['R-200']?></option>
                </select>
            </div>
        </div>

        <div class="cp-buttons-row">
            <button type="button" data-redirect-location="index.php?latest_page=<?=$page_id?>#pageID_<?=$page_id?>" class="button ico-cancel"><?=$TEXT['CANCEL'] ?></button>
            <button type="submit" class="button ico-save pos-right"><?=$TEXT['SAVE'] ?></button> 
        </div>
    </div>
</form>

<script type="text/javascript">
$(function () {
    $('#parent_page').selectee({
        searchFields: 'text right', 
        customSelector: 'flag-right'
    });    
    $('#redirect').selectee();
    $('#target').selectee();

    var countries = {
<?php foreach ($aLinks as $p) {
    $sToJS = "\t\t'{$p['page_id']}':{ '{$TEXT['PLEASE_SELECT']} ...':'0',";

    if (is_array($aTargets) && is_array($aTargets[$p['page_id']])) {
        foreach ($aTargets[$p['page_id']] as $value) {
            $aTmp1 = explode('[#'.SEC_ANCHOR, $value);
            $aTmp2 = explode(']', $aTmp1[1]);
            $sAnchor = SEC_ANCHOR.$aTmp2[0];
            $sToJS .= "'".addslashes($value)."':";
            $sToJS .= "'$sAnchor',";
        }
        $sToJS  = rtrim($sToJS, ',');
        $sToJS .= "},".PHP_EOL;
    }
    $sToJS  .= "\t\t";
    echo $sToJS;
}
?>
    };

    var $locations = $('#page_target');

    $('#parent_page').change(function () {
        var country = $(this).val(), locs = countries[country] || [];

        var html = $.map(locs, function(id, name){
            return '<option value="' + id + '"' + (id == "<?=$aData['anchor'] ?>" ? "selected" : "") +'>' + name + '</option>'
        }).join('');
        $locations.html(html);
    });

    $('#parent_page').trigger("change");
    $('.selectator_value_<?= $page_id ?>').addClass('disabled-selection');

    $('#page_link_selection').hide();
    $('#sec_anchor').hide();
    $('#external').hide();
    $('input:radio[name="linktype"]').change(function(){
        if ($(this).is(':checked') && $(this).val() == 'int') {
            $('#sec_anchor').show();
            $('#page_link_selection').show();
            $('#external').hide();
            $('#extern').prop('disabled', false);
        } else {
            $('#sec_anchor').hide();
            $('#page_link_selection').hide();
            $('#external').show();
            $('#extern').prop('disabled', false);
        }
    });

    $('input:radio[name="linktype"]').trigger('change');
});
</script>
