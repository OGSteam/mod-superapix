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
    // Échapper $table et $field une seule fois avant la boucle
    $table = $db->sql_escape_string($table);
    $field = $db->sql_escape_string($field);

    $new_query = array();
    if ($max_requete != 0) {
        $new_query = array_chunk($query, $max_requete); // on decompose la requete ( pour pas atteindre le max de requete simultané)

    } else {
        //sinon on balance le tout
        $new_query[] = $query;
    }

    $db->sql_query("START TRANSACTION;");
    // maintenant on lance les requetes de replace
    try {
        foreach ($new_query as $q) {

            $query = 'REPLACE INTO ' . $table . ' (' . $field . ') VALUES ' . implode(',', $q);
            $db->sql_query($query);
        }
    } catch (Exception $e) {
        $db->sql_query("ROLLBACK;");
        throw new Exception($e);
    }

    $db->sql_query("COMMIT;");
}


function escape($value)
{
    global $db;
    // Si la valeur est une chaîne de caractères, échapper et mettre des guillemets simples
    if (is_string($value)) {
        return "'" . $db->sql_escape_string($value) . "'";
    }
    // Pour les autres types de données, retourner la valeur telle quelle
    return $value;
}
