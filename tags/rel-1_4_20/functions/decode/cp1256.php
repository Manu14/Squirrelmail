<?php

/**
 * decode/cp1256.php
 *
 * This file contains cp1256 decoding function that is needed to read
 * cp1256 encoded mails in non-cp1256 locale.
 *
 * Original data taken from:
 *  ftp://ftp.unicode.org/Public/MAPPINGS/VENDORS/MICSFT/WINDOWS/CP1256.TXT
 *
 *   Name:     cp1256 to Unicode table
 *   Unicode version: 2.1
 *   Table version: 2.01
 *   Table format:  Format A
 *   Date:          01/5/99
 *   Contact:       cpxlate@microsoft.com
 *
 * @copyright 2003-2010 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 * @package squirrelmail
 * @subpackage decode
 */

/**
 * decode cp1256-encoded string
 * @param string $string Encoded string
 * @return string $string Decoded string
 */
function charset_decode_cp1256 ($string) {
    // don't do decoding when there are no 8bit symbols
    if (! sq_is8bit($string,'windows-1256'))
        return $string;

    $cp1256 = array(
        "\x80" => '&#8364;',
        "\x81" => '&#1662;',
        "\x82" => '&#8218;',
        "\x83" => '&#402;',
        "\x84" => '&#8222;',
        "\x85" => '&#8230;',
        "\x86" => '&#8224;',
        "\x87" => '&#8225;',
        "\x88" => '&#710;',
        "\x89" => '&#8240;',
        "\x8A" => '&#1657;',
        "\x8B" => '&#8249;',
        "\x8C" => '&#338;',
        "\x8D" => '&#1670;',
        "\x8E" => '&#1688;',
        "\x8F" => '&#1672;',
        "\x90" => '&#1711;',
        "\x91" => '&#8216;',
        "\x92" => '&#8217;',
        "\x93" => '&#8220;',
        "\x94" => '&#8221;',
        "\x95" => '&#8226;',
        "\x96" => '&#8211;',
        "\x97" => '&#8212;',
        "\x98" => '&#1705;',
        "\x99" => '&#8482;',
        "\x9A" => '&#1681;',
        "\x9B" => '&#8250;',
        "\x9C" => '&#339;',
        "\x9D" => '&#8204;',
        "\x9E" => '&#8205;',
        "\x9F" => '&#1722;',
        "\xA0" => '&#160;',
        "\xA1" => '&#1548;',
        "\xA2" => '&#162;',
        "\xA3" => '&#163;',
        "\xA4" => '&#164;',
        "\xA5" => '&#165;',
        "\xA6" => '&#166;',
        "\xA7" => '&#167;',
        "\xA8" => '&#168;',
        "\xA9" => '&#169;',
        "\xAA" => '&#1726;',
        "\xAB" => '&#171;',
        "\xAC" => '&#172;',
        "\xAD" => '&#173;',
        "\xAE" => '&#174;',
        "\xAF" => '&#175;',
        "\xB0" => '&#176;',
        "\xB1" => '&#177;',
        "\xB2" => '&#178;',
        "\xB3" => '&#179;',
        "\xB4" => '&#180;',
        "\xB5" => '&#181;',
        "\xB6" => '&#182;',
        "\xB7" => '&#183;',
        "\xB8" => '&#184;',
        "\xB9" => '&#185;',
        "\xBA" => '&#1563;',
        "\xBB" => '&#187;',
        "\xBC" => '&#188;',
        "\xBD" => '&#189;',
        "\xBE" => '&#190;',
        "\xBF" => '&#1567;',
        "\xC0" => '&#1729;',
        "\xC1" => '&#1569;',
        "\xC2" => '&#1570;',
        "\xC3" => '&#1571;',
        "\xC4" => '&#1572;',
        "\xC5" => '&#1573;',
        "\xC6" => '&#1574;',
        "\xC7" => '&#1575;',
        "\xC8" => '&#1576;',
        "\xC9" => '&#1577;',
        "\xCA" => '&#1578;',
        "\xCB" => '&#1579;',
        "\xCC" => '&#1580;',
        "\xCD" => '&#1581;',
        "\xCE" => '&#1582;',
        "\xCF" => '&#1583;',
        "\xD0" => '&#1584;',
        "\xD1" => '&#1585;',
        "\xD2" => '&#1586;',
        "\xD3" => '&#1587;',
        "\xD4" => '&#1588;',
        "\xD5" => '&#1589;',
        "\xD6" => '&#1590;',
        "\xD7" => '&#215;',
        "\xD8" => '&#1591;',
        "\xD9" => '&#1592;',
        "\xDA" => '&#1593;',
        "\xDB" => '&#1594;',
        "\xDC" => '&#1600;',
        "\xDD" => '&#1601;',
        "\xDE" => '&#1602;',
        "\xDF" => '&#1603;',
        "\xE0" => '&#224;',
        "\xE1" => '&#1604;',
        "\xE2" => '&#226;',
        "\xE3" => '&#1605;',
        "\xE4" => '&#1606;',
        "\xE5" => '&#1607;',
        "\xE6" => '&#1608;',
        "\xE7" => '&#231;',
        "\xE8" => '&#232;',
        "\xE9" => '&#233;',
        "\xEA" => '&#234;',
        "\xEB" => '&#235;',
        "\xEC" => '&#1609;',
        "\xED" => '&#1610;',
        "\xEE" => '&#238;',
        "\xEF" => '&#239;',
        "\xF0" => '&#1611;',
        "\xF1" => '&#1612;',
        "\xF2" => '&#1613;',
        "\xF3" => '&#1614;',
        "\xF4" => '&#244;',
        "\xF5" => '&#1615;',
        "\xF6" => '&#1616;',
        "\xF7" => '&#247;',
        "\xF8" => '&#1617;',
        "\xF9" => '&#249;',
        "\xFA" => '&#1618;',
        "\xFB" => '&#251;',
        "\xFC" => '&#252;',
        "\xFD" => '&#8206;',
        "\xFE" => '&#8207;',
        "\xFF" => '&#1746;'
    );

    $string = str_replace(array_keys($cp1256), array_values($cp1256), $string);

    return $string;
}

