<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @description Fichier de liaison xtense avec le mod superapix
 */
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

global $db, $table_prefix, $user, $xtense_version;
$xtense_version = "2.6.0";

if (class_exists("Callback")) {

    class superapix_Callback extends Callback {

        public $version = '2.6.0';

        public function spaXtense($mixData) {
            global $io;
            if ($this->callSpa()) {
                return Io::SUCCESS;
            } else {
                return Io::ERROR;
            }
        }

        public function getCallbacks() {
// la gestion des callbacks se fait dans l admin de superapix
            return NULL;
        }

        private function callSpa() {
            define('IN_SUPERAPIX', true); // pour inclusion de fichier
            include_once("mod/superapix/common.php");
            $sSheme = "http";
            if(isSecure())
            {
                $sSheme = "https";
            }
            
            $sUri = $sSheme."://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
            $sUri = str_replace("xtense/xtense.php", "superapix/cron.php", $sUri); // récupération url

            $page = file_get_contents($sUri);
            loggeur("PAGE => " . $page); // pour logger directement le résultat 
            //echo "SUPERAPIX : " . $page; // pour visualiser directement sur page ogame le résultat  => pour dev only car si activé pas de status xtense

            $page = json_decode($page, true);

            if (isset($page['ok'])) {
                return true;
            }
            return false;
        }

    }

}
