<?php
    /**
     * options.php
     *
     * Copyright (c) 1999-2001 The SquirrelMail Development Team
     * Licensed under the GNU GPL. For full terms see the file COPYING.
     *
     * Displays the options page. Pulls from proper user preference files
     * and config.php. Displays preferences as selected and other options.
     *
     *  $Id$
     */

    require_once('../src/validate.php');
    require_once('../functions/display_messages.php');
    require_once('../functions/imap.php');
    require_once('../functions/array.php');
   
    ereg ("(^.*/)[^/]+/[^/]+$", $PHP_SELF, $regs);
    $base_uri = $regs[1];   

    if (isset($language)) {
        setcookie('squirrelmail_language', $language, time()+2592000, $base_uri);
        $squirrelmail_language = $language;
    }   

    displayPageHeader($color, _("None"));

?>

<br>
<TABLE BGCOLOR="<?php echo $color[0] ?>" WIDTH="95%" align="center" CELLPADDING="2" CELLSPACING="0" BORDER="0">
<TR><TD align="center">
    <b><?php echo _("Options") ?></b><br>

    <TABLE WIDTH="100%" BORDER="0" CELLPADDING="5" CELLSPACING="0">
    <TR><TD BGCOLOR="<?php echo $color[4] ?>" align="center">

<?php
    if (isset($submit_personal)) {
        /* Save personal information. */
        setPref($data_dir, $username, 'full_name', $new_full_name);
        setPref($data_dir, $username, 'email_address', $new_email_address);
        setPref($data_dir, $username, 'reply_to', $new_reply_to);
        setPref($data_dir, $username, 'reply_citation_style', $new_reply_citation_style);
        setPref($data_dir, $username, 'reply_citation_start', $new_reply_citation_start);
        setPref($data_dir, $username, 'reply_citation_end', $new_reply_citation_end);
        setPref($data_dir, $username, 'use_signature', $new_use_signature);
        setPref($data_dir, $username, 'prefix_sig', $new_prefix_sig);
        setSig($data_dir, $username, $new_signature_abs);
      
        do_hook('options_personal_save');
      
        echo '<br><b>'._("Successfully saved personal information!").'</b><br>';
    } else if (isset($submit_display)) {
        /* Do checking to make sure $new_theme is in the array. */
        $theme_in_array = false;
        for ($i=0; $i < count($theme); $i++) {
            if ($theme[$i]['PATH'] == $new_chosen_theme) {
                $theme_in_array = true;
                break;
            }
        }
        if (!$theme_in_array) {
            $new_chosen_theme = '';
        }
   
        /* Save display preferences. */
        setPref($data_dir, $username, 'chosen_theme', $new_chosen_theme);
        setPref($data_dir, $username, 'language', $new_language);
        setPref($data_dir, $username, 'use_javascript_addr_book', $new_use_javascript_addr_book);
        setPref($data_dir, $username, 'javascript_setting', $new_javascript_setting);
        setPref($data_dir, $username, 'show_num', $new_show_num);
        setPref($data_dir, $username, 'wrap_at', $new_wrap_at);
        setPref($data_dir, $username, 'editor_size', $new_editor_size);
        setPref($data_dir, $username, 'location_of_buttons', $new_location_of_buttons);
        setPref($data_dir, $username, 'alt_index_colors', $new_alt_index_colors);
        setPref($data_dir, $username, 'show_html_default', $new_show_html_default);
        setPref($data_dir, $username, 'include_self_reply_all', $new_include_self_reply_all);
        setPref($data_dir, $username, 'page_selector', $new_page_selector);
        setPref($data_dir, $username, 'page_selector_max', $new_page_selector_max);
        setPref($data_dir, $username, 'show_xmailer_default', $new_show_xmailer_default);
        setPref($data_dir, $username, 'attachment_common_show_images', $new_attachment_common_show_images);
        setPref($data_dir, $username, 'pf_subtle_link', $new_pf_subtle_link);
        setPref($data_dir, $username, 'pf_cleandisplay', $new_pf_cleandisplay);

        $js_autodetect_results = (isset($new_js_autodetect_results) ? $new_js_autodetect_results : SMPREF_JS_OFF);
        if ($new_javascript_setting == SMPREF_JS_AUTODETECT) {
            if ($js_autodetect_results == SMPREF_JS_ON) {
                setPref($data_dir, $username, 'javascript_on', SMPREF_JS_ON);
            } else {
                setPref($data_dir, $username, 'javascript_on', SMPREF_JS_OFF);
            }
        } else {
            setPref($data_dir, $username, 'javascript_on', $new_javascript_setting);
        }

        do_hook('options_display_save');

        echo '<br><b>'._("Successfully saved display preferences!").'</b><br>';
        echo '<A HREF="../src/webmail.php?right_frame=options.php" target=_top>' . _("Refresh Page") . '</A><br>';
    } else if (isset($submit_folder)) { 
        /* Save trash folder preferences. */
        if ($new_trash_folder != SMPREF_NONE) {
            setPref($data_dir, $username, 'move_to_trash', SMPREF_ON);
            setPref($data_dir, $username, 'trash_folder', $new_trash_folder);
        } else {
            setPref($data_dir, $username, 'move_to_trash', SMPREF_OFF);
            setPref($data_dir, $username, 'trash_folder', SMPREF_NONE);
        }

        /* Save sent folder preferences. */
        if ($new_sent_folder != SMPREF_NONE) {
            setPref($data_dir, $username, 'move_to_sent', SMPREF_ON);
            setPref($data_dir, $username, 'sent_folder', $new_sent_folder);
        } else {
            setPref($data_dir, $username, 'move_to_sent', SMPREF_OFF);
            setPref($data_dir, $username, 'sent_folder', SMPREF_NONE);
        }

        /* Save draft folder preferences. */
        if ($new_draft_folder != SMPREF_NONE) {
            setPref($data_dir, $username, 'save_as_draft', SMPREF_ON);
            setPref($data_dir, $username, 'draft_folder', $new_draft_folder);
        } else {
            setPref($data_dir, $username, 'save_as_draft', SMPREF_OFF);
            setPref($data_dir, $username, 'draft_folder', SMPREF_NONE);
        }

        /* Save folder prefix preferences. */
        if (isset($folderprefix)) {
            setPref($data_dir, $username, 'folder_prefix', $folderprefix);
        } else {
            setPref($data_dir, $username, 'folder_prefix', '');
        }

        setPref($data_dir, $username, 'location_of_bar', $new_location_of_bar);
        setPref($data_dir, $username, 'left_size', $new_left_size);
        setPref($data_dir, $username, 'left_refresh', $new_left_refresh);
        setPref($data_dir, $username, 'unseen_notify', $new_unseen_notify);
        setPref($data_dir, $username, 'unseen_type', $new_unseen_type);
        setPref($data_dir, $username, 'collapse_folders', $new_collapse_folders);
        setPref($data_dir, $username, 'date_format', $new_date_format);
        setPref($data_dir, $username, 'hour_format', $new_hour_format);

        do_hook('options_folders_save');
        echo '<br><b>'._("Successfully saved folder preferences!").'</b><br>';
        echo '<A HREF="../src/left_main.php" target=left>' . _("Refresh Folder List") . '</A><br>';
    } else {
        do_hook('options_save');
    }

    /****************************************/
    /* Now build our array of option pages. */
    /****************************************/

    /* Build a section for Personal Options. */
    $optionpages[] = array(
        'name' => _("Personal Information"),
        'url'  => 'options_personal.php',
        'desc' => _("This contains personal information about yourself such as your name, your email address, etc."),
        'js'   => false
    );

    /* Build a section for Display Options. */
    $optionpages[] = array(
        'name' => _("Display Preferences"),
        'url'  => 'options_display.php',
        'desc' => _("You can change the way that SquirrelMail looks and displays information to you, such as the colors, the language, and other settings."),
        'js'   => false
    );

    /* Build a section for Message Highlighting Options. */
    $optionpages[] = array(
        'name' =>_("Message Highlighting"),
        'url'  => 'options_highlight.php',
        'desc' =>_("Based upon given criteria, incoming messages can have different background colors in the message list.  This helps to easily distinguish who the messages are from, especially for mailing lists."),
        'js'   => false
    );

    /* Build a section for Folder Options. */
    $optionpages[] = array(
        'name' => _("Folder Preferences"),
        'url'  => 'options_folder.php',
        'desc' => _("These settings change the way your folders are displayed and manipulated."),
        'js'   => false
    );

    /* Build a section for Index Order Options. */
    $optionpages[] = array(
        'name' => _("Index Order"),
        'url'  => 'options_order.php',
        'desc' => _("The order of the message index can be rearanged and changed to contain the headers in any order you want."),
        'js'   => false
    );
    /* Build a section for plugins wanting to register an optionpage. */
    do_hook('options_register');

    /*****************************************************/
    /* Let's sort Javascript Option Pages to the bottom. */
    /*****************************************************/
    $js_optionpages = array();
    $reg_optionpages = array();
    foreach ($optionpages as $optpage) {
        if (!$optpage['js']) {
            $reg_optionpages[] = $optpage;
        } else if ($javascript_on == SMPREF_JS_ON) {
            $js_optionpages[] = $optpage;
        }
    }
    $optionpages = array_merge($reg_optionpages, $js_optionpages);

    /********************************************/
    /* Now, print out each option page section. */
    /********************************************/
    $first_optpage = false;
    echo "<TABLE BGCOLOR=\"$color[4]\" WIDTH=\"100%\" CELLPADDING=0 CELLSPACING=\"5\" BORDER=\"0\">" .
                '<TR><TD VALIGN="TOP">' .
                   "<TABLE BGCOLOR=\"$color[4]\" WIDTH=\"100%\" CELLPADDING=\"3\" CELLSPACING=\"0\" BORDER=\"0\">";
    foreach ($optionpages as $next_optpage) {
        if ($first_optpage == false) {
            $first_optpage = $next_optpage;
        } else {
            print_optionpages_row($first_optpage, $next_optpage);
            $first_optpage = false;
        }
    }

    if ($first_optpage != false) {
        print_optionpages_row($first_optpage);
    }

    echo '</TABLE>' .
                '</TD></TR>' .
             "</TABLE>\n";

    do_hook('options_link_and_description');

?>
    </TD></TR>
    </TABLE>

</TD></TR>
</TABLE>

</body></html>

<?php

    /*******************************************************************/
    /* Please be warned. The code below this point sucks. This is just */
    /* my first implementation to make the option rows work for both   */
    /* Javascript and non-Javascript option chunks.                    */
    /*                                                                 */
    /* Please, someone make these better for me. All three functions   */
    /* below REALLY do close to the same thing.                        */
    /*                                                                 */
    /* This code would be GREATLY improved by a templating system.     */
    /* Don't try to implement that now, however. That will come later. */
    /*******************************************************************/

    /*******************************************************************/
    /* Actually, now that I think about it, don't do anything with     */
    /* this code yet. There is ACTUALLY supposed to be a difference    */
    /* between the three functions that write the option rows. I just  */
    /* have not yet gotten to integrating that yet.                    */
    /*******************************************************************/

    /**
     * This function prints out an option page row.
     */
    function print_optionpages_row($leftopt, $rightopt = false) {
        global $color;

        echo "<TABLE BGCOLOR=\"$color[4]\" WIDTH=\"100%\" CELLPADDING=0 CELLSPACING=5 BORDER=0>" .
                '<TR><TD VALIGN="TOP">' .
                   '<TABLE WIDTH="100%" CELLPADDING="3" CELLSPACING="0" BORDER="0">' .
                      '<TR>' .
                         "<TD VALIGN=TOP BGCOLOR=\"$color[9]\" WIDTH=\"50%\">" .
                            '<A HREF="' . $leftopt['url'] . '">' . $leftopt['name'] . '</A>'.
                         '</TD>'.
                         "<TD VALIGN=TOP BGCOLOR=\"$color[4]\">&nbsp;</TD>";
        if ($rightopt) {
            echo         "<TD VALIGN=top BGCOLOR=\"$color[9]\" WIDTH=\"50%\">" .
                            '<A HREF="' . $rightopt['url'] . '">' . $rightopt['name'] . '</A>' .
                         '</TD>';
        } else {
            echo         "<TD VALIGN=top BGCOLOR=\"$color[4]\" WIDTH=\"50%\">&nbsp;</TD>";
        }

        echo          '</TR>' .
                      '<TR>' .
                         "<TD VALIGN=top BGCOLOR=\"$color[0]\">" .
                            $leftopt['desc'] .
                         '</TD>' .
                         "<TD VALIGN=top BGCOLOR=\"$color[4]\">&nbsp;</TD>";
        if ($rightopt) {
            echo         "<TD VALIGN=top BGCOLOR=\"$color[0]\">" .
                            $rightopt['desc'] .
                         '</TD>';
        } else {
            echo "<TD VALIGN=top BGCOLOR=\"$color[4]\">&nbsp;</TD>";
        }
        
        echo          '</TR>' .
                   '</TABLE>' .
                '</TD></TR>' .
             "</TABLE>\n";
    }

?>
