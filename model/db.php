<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX')) die("Hacking attempt");

function mass_replace_into($table, $field, $query)
{
    global $db;
    $max_requete = (int)find_config("requete_max");

    $new_query = array();
    if ($max_requete != 0) {
        $new_query = array_chunk($query, $max_requete); // on decompose la requete ( pour pas atteindre le max de requete simultané)

    } else {
        //sinon on balance le tout
        $new_query[] = $query;
    }

    // maintenant on lance les requetes de replace

    foreach ($new_query as $q) {
        $db->sql_query('REPLACE INTO ' . $table . ' (' . $field . ') VALUES ' . implode(',', $q));
        // avant de finir boucle on va faire patienter une demi seconde
        //   usleep(500000) ;



    }
}
