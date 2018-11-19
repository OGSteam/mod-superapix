<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

function create_uni_vide() {
    global $db, $server_config;

    $query = array();
    for ($g = 1; $g <= $server_config['num_of_galaxies']; $g++) {
        for ($s = 1; $s <= $server_config['num_of_systems']; $s++) {
            for ($r = 1; $r <= 15; $r++) {
                $query[] = '("' . (int) ($g) . '", "' . (int) ($s) . '", "' . (int) ($r) . '")';
            }
        }

        // on lance les requetes
        $db->sql_query('INSERT  IGNORE  INTO ' . TABLE_UNIVERSE . ' ( galaxy,system,row) VALUES ' . implode(',', $query));
        $query = array();
    }
}

function reinit(){
    //change last date
    $tab = constante_stepper();
foreach ($tab as $key => $value)
{
    mod_set_option("last_" . $value,0);
}

    // purge le dossier xml (voir pour glob dans prochaine maj )
    $rep=opendir(MOD_ROOT_XML);
    while($file = readdir($rep)){
        if($file != '..' && $file !='.' && $file !='' && $file!='.htaccess'&& $file!='index.php'){
            unlink(MOD_ROOT_XML.$file);
        }
    }
}

function defineDebug() {

        //define("DEBUG", mod_get_option("debug"));
        define("DEBUG", 1);
    }
