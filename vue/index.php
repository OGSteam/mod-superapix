<?php
/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

// etapes
$tab = constante_stepper();
$tcheckSecurity = checkSecurity();
$tcallbacks = constante_xtense_callbacks();
$uIdSuperapix = spaModId();



$adminview = 0;
if (isset($pub_admin)) {
    $adminview = (int) $pub_admin;
}



// enregistrement formulaire
if (isset($pub_uni) && $adminview == 1) {
    insert_config("uni", (int) ($pub_uni));
}
if (isset($pub_requete_max) && $adminview == 1) {
    insert_config("requete_max", (int) ($pub_requete_max));
}
if (isset($pub_pays) && strlen($pub_pays) < 4 && $adminview == 1) {
    insert_config("pays", $pub_pays);
}
if (isset($pub_debug) && $adminview == 1) {
    insert_config("debug", (int) $pub_debug);
}
// partie callbacks
if ($adminview == 1) {
    foreach ($tcallbacks as $callback) {
        $sVarName = "pub_" . $callback;
        if (isset($$sVarName)) {
            if ($$sVarName == 1) {
                // on demande le call back
                AddCallback($callback, $uIdSuperapix);
            } elseif ($$sVarName == 0) {
                DelCallback($callback, $uIdSuperapix);
            }
        }
    }
}

include_once MOD_ROOT_VUE . "css.php";

?>

<?php if ($adminview != 1): ?>


    <div class ="mod">
        <h1>Superapix</h1>
        <?php if ($user_data["user_admin"] = 1 || $user_data["user_coadmin"] = 1) : ?>
            <p><a class="btn" href="index.php?action=superapix&admin=1">Administration </a></p>
        <?php endif; ?>

        <p>Superapix est un mod Ogspy permettant de mettre à jour depuis l'api XML d'ogame</p>
        <p>Celui ci est maintenant profilé pour automatiquement se mettre à jour sans actions utilisateurs  </p>
        <?php if ($tcheckSecurity != NULL): ?>
            <p class="error">
                La configuration du mod semble incorrecte (<?php echo count($tcheckSecurity); ?> erreur(s)).
            </p>
        <?php else : ?>
            <p class="success">
                La configuration du mod semble correcte
            </p>


            <h2>Mettre à jour</h2>
            <p>

            <progress id="avancement" class="progress"  value="0" max="39"><div id="content"></div></progress> <a class=""  onclick="startStepping()">Mettre à jour </a>
            </p>

        <?php endif; ?>


        <h2><?php echo help("liste des dernieres mises à jour"); ?>Dernieres mise à jour</h2>


        <ul>
            <?php foreach ($tab as $key => $value) : ?>
                <li>
                    <?php echo lang($value); ?>: <strong><?php echo strftime("%d %b %Y %H:%M", ((int) find_config("last_" . $value))); ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>liens</h2>
        <ul>
            <li>
                <a href="https://forum.ogsteam.fr/">Forum Ogsteam/</a>
            </li>
            <li>
                <a href="https://forum.ogsteam.fr/index.php?topic=783.0">Topic du mod/</a>
            </li>
            <li>
                <a href="https://github.com/OGSteam/mod-superapix/issues">Signaler un Bug/</a>
            </li>
        </ul>


    </div>

<?php else : ?>




    <div class="mod">

        <a href="index.php?action=superapix">Retour</a>

        <form method="post" action="index.php?action=superapix&admin=1">
            <legend>Administration</legend>
            <div class="form-grp tooltip">
                <label for="name">Numero D'univers <span class="required">*</span></label>
                <input type="text" id="uni" name="uni" value="<?php echo (int) find_config("uni"); ?>" placeholder="67" required="required" />
                <span> <div class="pop-title">Numero </div>
                    Indiquer le numero  de la page du jeu <br />
                    exemple : 01, 67, ... <br />
                    cf : https://s<b>01</b>-fr.ogame.gameforge.com

                </span>
            </div>


            <div class="form-grp tooltip">
                <label for="name">Nombre de requere max <span class="required">*</span></label>
                <input type="text" id="requete_max" name="requete_max" value="<?php echo (int) find_config("requete_max"); ?>" placeholder="500" required="required" />
                <span> <div class="pop-title">Requete max</div>
                    500 semble etre correct
                </span>
            </div>

            <div class="form-grp tooltip">
                <label for="enquiry">Pays </label>
                <input type="text" id="pays" name="pays" value="<?php echo find_config("pays"); ?>" placeholder="it" required="required" />
                <span> <div class="pop-title">Pays</div>
                    Indiquer le pays de la page du jeu <br />
                    exemple : fr, it, en , ...
                     cf : https://s01-<b>fr</b>.ogame.gameforge.com
                </span>
            </div>

            <div class="form-grp tooltip">
                <label for="enquiry">Mode developpeur </label>
                <select id="debug" name="debug">
                    <?php if (find_config("debug") == 1) : ?>
                        <option value="0">
                            NON
                        </option>
                        <option value="1" selected>
                            OUI
                        </option>
                    <?php else : ?>
                        <option value="0" selected>
                            NON
                        </option>
                        <option value="1" >
                            OUI
                        </option>
                    <?php endif; ?>
                </select>
                <span> <div class="pop-title">Debug</div>
                    Activer la journalisation des actions du mod.
                </span>

            </div>

            <hr />

            <legend>Options xtense CallBacks</legend>
            <?php $tReelCallBacks = GetAllCallBacks($uIdSuperapix); ?>
            <p class="success">Nombre de CallBacks Xtense activé : <?php echo count($tReelCallBacks); ?></p>



            <?php foreach ($tcallbacks as $callback) : ?>
                <div class="form-grp tooltip">
                    <label for="enquiry"><?php echo $callback; ?></label>
                    <select id="<?php echo $callback; ?>" name="<?php echo $callback; ?>">
                        <?php if (in_array($callback, $tReelCallBacks)) : ?>
                            <option value="0">
                                NON
                            </option>
                            <option value="1" selected>
                                OUI
                            </option>
                        <?php else : ?>
                            <option value="0" selected>
                                NON
                            </option>
                            <option value="1" >
                                OUI
                            </option>
                        <?php endif; ?>
                    </select>

                    <span> <div class="pop-title">CallBacks Xtense</div>
                        Ajouter ou supprimer la liaison avec la barre xtense sur la page "<?php echo $callback; ?>"
                    </span>

                </div>



            <?php endforeach; ?>
            <input class = "btn" type="submit" value="Envoyer!"  />

            <hr />

            <legend>Autres</legend>
               <div class="form-grp tooltip">
                   <a class ="btn" href="index.php?action=superapix&create_uni">Uni vide</a>
                   <span> <div class="pop-title">Uni Vide</div>
                        rempli l'univers d'entrée vide,<br /> Pour ogspy tout neuf.<br /><br /> Ne lancer qu'une seule fois
                    </span>
               </div>
                   <div class="form-grp tooltip">
            <a class ="btn" href="index.php?action=superapix&reinit">Réinitalisation</a>
            <span> <div class="pop-title">Réinitalisation</div>
                      En cas de blocage ponctuel, permet de :<br /> Vider le cache XML <br /> et de <br /> supprimer la date de derniere insertion

                    </span>
    </div>
</div>
</form>
        <?php
        if (find_config("debug") == 1) {
            loggeur("INFO Conf php allow_url_fopen " . ini_get('allow_url_fopen'));
            loggeur("Conf php max_execution_time" . ini_get('max_execution_time'));
            loggeur("Conf php post_max_size" . ini_get('post_max_size'));
        }
        ?>

        <?php if ($tcheckSecurity != NULL):
            ?>
            <?php foreach ($tcheckSecurity as $error) : ?>
                <p class="error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="success">
                La configuration du mod semble correcte
</p>

        <?php endif; ?>




        <!--
                <table width = "100%">
                    <form method = "POST" action = "index.php?action=superapix">
                        <input name = "max_battlereport" type = "hidden" size = "5" value = "10" />
                        <tr>
                            <td class = "c_ogspy" colspan = "2">Options <?php echo MOD_NAME;
        ?></td>
                        </tr>
                        <tr>
                            <th width="60%">numero d'univers</th>
                            <th><input type="text" name="uni" size="5" value="<?php echo (int) find_config("uni"); ?>" /></th>
                        </tr>
                        <tr>
                            <th width="60%">Nombre Max de requete</th>
                            <th><input type="text" name="requete_max" size="5" value="<?php echo (int) find_config("requete_max"); ?>" /></th>
                        </tr>
                        <tr>
                            <th width="60%">lancer la mise a jour</th>
                            <th><?php if (((int) find_config("uni")) != 0) : ?><a href="index.php?action=superapix&sub_action=cross&step=0">ENJOY</a><?php else : ?> <?php endif; ?></th>
                        </tr>
                        <tr>
                            <th width="60%">Creer univers vide</th>
                            <th><a href="index.php?action=superapix&create_uni">CREATE</a></th>
                        </tr>
                        <tr>
                            <th width="60%"></th>
                            <th><input type="submit" /></th>
                        </tr>
                    </form>
                    <tr>
                        <td class="c_tech" colspan="2">Information serveur</td>
                    </tr>
                    <tr>
                        <th width="60%">allow_url_fopen</th>
                        <th><?php echo ini_get('allow_url_fopen'); ?></th>
                    </tr>
                    <tr>
                        <th width="60%">max_execution_time</th>
                        <th><?php echo ini_get('max_execution_time'); ?></th>
                    </tr>
                    <tr>
                        <th width="60%">post_max_size</th>
                        <th><?php echo ini_get('post_max_size'); ?></th>
                    </tr>

                    <tr>
                        <td class="c_tech" colspan="2">Dernieres maj via superapix</td>
                    </tr>

        <?php foreach ($tab as $key => $value) : ?>
                                                                                            <tr>
                                                                                                <th width="60%"><?php echo lang($value); ?></th>
                                                                                                <th><?php echo strftime("%d %b %Y %H:%M", ((int) find_config("last_" . $value))); ?></th>
                                                                                            </tr>
        <?php endforeach; ?>
                </table>


    <?php
    endif;
    ?>


        <script src="mod/superapix/js/step.js"><script>