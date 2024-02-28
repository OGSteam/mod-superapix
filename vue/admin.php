<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");


$adminview = 0;
if (isset($pub_subaction) && $pub_subaction == "admin") {
    $adminview = 1;
}

$tab = constante_stepper();
$tcheckSecurity = checkSecurity();
$tcallbacks = constante_xtense_callbacks();
$uIdSuperapix = spaModId();



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
if (isset($pub_tempo) && $adminview == 1) {
    $tempo = (int)$pub_tempo > 3 ? 3 : (int)$pub_tempo; // inf a 3 s
    $tempo = (int)$pub_tempo < 1 ? 1 : (int)$tempo; // sup a 1 s
    insert_config("tempo", (int)$tempo);
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
?>

<?php if ($adminview == 1) : ?>

    <table class="og-table og-little-table">
        <form method="post" action="index.php?action=superapix&amp;subaction=admin&amp;admin=1">
                <tr>
                    <th colspan="2">Configuration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tdstat">
                        Numero D'univers
                    </td>
                    <td class="tdvalue">
                        <input type="text" id="uni" name="uni" value="<?php echo (int) find_config("uni"); ?>" placeholder="67" required="required" />
                    </td>
                    <!--
                    <td>
                        Indiquer le numero de la page du jeu -
                        exemple : 01, 67, ... <br />
                        cf : https://s<b>01</b>-fr.ogame.gameforge.com
                    </td>
-->
                </tr>
                <tr>
                    <td class="tdstat">
                        Nombre de requete max
                    </td>
                    <td class="tdvalue">
                        <input type="text" id="requete_max" name="requete_max" value="<?php echo (int) find_config("requete_max"); ?>" placeholder="500" required="required" />
                    </td>
                    <!--
                    <td>
                    500 semble etre correct
                    </td>
-->
                </tr>
                <tr>
                    <td class="tdstat">
                        Pays
                    </td>
                    <td class="tdvalue">
                        <input type="text" id="pays" name="pays" value="<?php echo find_config("pays"); ?>" placeholder="it" required="required" />
                    </td>
                    <!--
                    <td>
                                       <div class="pop-title">Pays</div>
                    Indiquer le pays de la page du jeu <br />
                    exemple : fr, it, en , ...
                    cf : https://s01-<b>fr</b>.ogame.gameforge.com
                    </td>
-->
                </tr>
                <tr>
                    <td class="tdstat">
                        Temporisation API
                    </td>
                    <td class="tdvalue">
                        <input type="text" id="tempo" name="tempo" maxlength="1" value="<?php echo (int) find_config("tempo"); ?>" placeholder="1" required="required" />

                    </td>
                    <!--
                    <td>  
                        Temps d attente entre deux appels.<br /> 1, 2 ou 3 seconde(s).
                    </td>
-->
                </tr>
                <tr>
                    <td class="tdstat">
                        Mode developpeur
                    </td>
                    <td class="tdvalue">
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
                                <option value="1">
                                    OUI
                                </option>
                            <?php endif; ?>
                        </select>
                    </td>
                    <!--
                    <td>  
                           Activer la journalisation des actions du mod.
                    </td>
-->
                </tr>


            </tbody>
            <thead>
                <tr>
                    <th colspan="2">Options xtense CallBacks</th>
                </tr>
                <?php $tReelCallBacks = GetAllCallBacks($uIdSuperapix); ?>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">Nombre de CallBacks Xtense activé : <span class="og-highlight"><?php echo count($tReelCallBacks); ?></span></td>
                </tr>
                <?php foreach ($tcallbacks as $callback) : ?>
                    <tr>
                        <td><?php echo $callback; ?></td>
                        <td>
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
                                    <option value="1">
                                        OUI
                                    </option>
                                <?php endif; ?>
                            </select>
                        </td>
                        <!--
                        <td>
                            <div class="pop-title">CallBacks Xtense</div>
                            Ajouter ou supprimer la liaison avec la barre xtense sur la page "<?php echo $callback; ?>"
                                </td>
                                -->
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <input class="btn og-button " type="submit" value="Envoyer!" />
                    </td>
                </tr>
            </tbody>
        </form>
        <thead>
            <tr>
                <th colspan="2">Autres</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">
                    <p><a class="btn og-button  og-button-danger" href="index.php?action=superapix&amp;reinit">Réinitalisation</a></p>
                    En cas de blocage ponctuel, permet de : Vider le cache XML et de supprimer la date de derniere insertion
                </td>
            </tr>

        </tbody>
    </table>

    <!--MESSAGE ERREUR OU MESSAGE CORRECT-->
    <?php
    if (find_config("debug") == 1) {
        loggeur("INFO Conf php allow_url_fopen " . ini_get('allow_url_fopen'));
        loggeur("Conf php max_execution_time" . ini_get('max_execution_time'));
        loggeur("Conf php post_max_size" . ini_get('post_max_size'));
    }
    ?>

    <?php if ($tcheckSecurity != NULL) :
    ?>
        <?php foreach ($tcheckSecurity as $error) : ?>
            <div class="og-msg og-msg-error">
                <p class="og-content"><?php echo $error; ?> </p>
                <br>

            </div>

        <?php endforeach; ?>
    <?php else : ?>
        <div class="og-msg og-msg-success">
            <p class="og-content">La configuration du mod semble correcte <br> </p>
            <br>

        </div>
    <?php endif; ?>



<?php endif; ?>