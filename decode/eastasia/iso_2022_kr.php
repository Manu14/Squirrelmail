<?php
/**
 * iso-2022-kr decoding functions
 *
 * This script provides iso-2022-kr (rfc1557) decoding functions.
 *
 * @copyright (c) 2004-2012 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 * @package decode
 * @subpackage eastasia
 */

/**
 * Converts iso-2022-kr texts
 * @param string $string iso-2022-kr encoded string
 * @param boolean $save_html don't html encode special characters if true
 * @return string html encoded string
 */
function charset_decode_iso_2022_kr ($string,$save_html=false) {
    global $aggressive_decoding;

    // undo htmlspecial chars (they can break iso-2022-kr)
    if (! $save_html) {
        $string=str_replace(array('&quot;','&lt;','&gt;','&amp;'),array('"','<','>','&'),$string);
    }
    // recode
    // this is CPU intensive task. Use recode functions if they are available. 
    if (function_exists('recode_string')) {
        $string = recode_string("iso-2022-kr..html",$string);

        // if string sanitizing is not needed, undo htmlspecialchars applied by recode.
        if ($save_html) {
            $string=str_replace(array('&quot;','&lt;','&gt;','&amp;'),array('"','<','>','&'),$string);
        }
        return $string;
    }

    // iconv does not support html target, but internal utf-8 decoding is faster than iso-2022-kr. 
    if (function_exists('iconv') && file_exists(SM_PATH . 'functions/decode/utf_8.php') ) {
        include_once(SM_PATH . 'functions/decode/utf_8.php');
        $string = iconv('iso-2022-kr','utf-8',$string);
        // redo htmlspecial chars
        if (! $save_html) $string = htmlspecialchars($string);
        return charset_decode_utf_8($string);
    }

    // aggressive decoding disabled. iso-2022-kr is not supported by iso_2022_support.php
    //    if (! isset($aggressive_decoding) || ! $aggressive_decoding )
        return htmlspecialchars($string);

    /**
     * Include common iso-2022-xx functions
     */
    include_once(SM_PATH . 'functions/decode/iso_2022_support.php');

    $index=0;
    $ret='';
    $enc_table='ascii';

    while ( $index < strlen($string)) {
        if (isset($string[$index+2]) && $string[$index]=="\x1B") {
            // table change
            switch ($string[$index].$string[$index+1].$string[$index+2]) {
            case "\x1B\x28\x42":
                $enc_table='ascii';
                $index=$index+3;
                break;
            case "\x1B\x24\x42":
                $enc_table='jis0208-1983';
                $index=$index+3;
                break;
            case "\x1B\x28\x4A":
                $enc_table='jis0201-1976';
                $index=$index+3;
                break;
            case "\x1B\x24\x40":
                $enc_table='jis0208-1978';
                $index=$index+3;
                break;
            default:
                return _("Unsupported ESC sequence.");
            }
        }

        $ret .= get_iso_2022_symbol($string,$index,$enc_table);
        $index=$index+get_iso_2022_symbolsize($enc_table);
    }
    return $ret;
}
