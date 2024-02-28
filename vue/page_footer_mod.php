<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");


global $db;
    //Récupére le numéro de version du mod
    $request = 'SELECT `version` from `' . TABLE_MOD . '` WHERE title=\'superapix\'';
    $result = $db->sql_query($request);
    list($version) = $db->sql_fetch_row($result);

    echo "<div class=\"ogspy-mod-footer\">";
    echo "<p>Superapix (v" . $version . ") créé par <i>Machine</i></p>";
    echo "</div>";