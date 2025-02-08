<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");



$adminview = isset($pub_subaction) && $pub_subaction === "admin" ? 1 : 0;

$tab = constante_stepper();
$tcheckSecurity = checkSecurity();
$tcallbacks = constante_xtense_callbacks();
$uIdSuperapix = spaModId();


// Enregistrement du formulaire
if ($adminview) {
    if (isset($pub_uni)) insert_config("uni", (int)$pub_uni);
    if (isset($pub_requete_max)) insert_config("requete_max", (int)$pub_requete_max);
    if (isset($pub_pays) && strlen($pub_pays) < 4) insert_config("pays", $pub_pays);
    if (isset($pub_tempo)) {
        $tempo = max(1, min(3, (int)$pub_tempo));
        insert_config("tempo", $tempo);
    }
    if (isset($pub_debug)) insert_config("debug", (int)$pub_debug);

    // Partie callbacks
    foreach ($tcallbacks as $callback) {
        $sVarName = "pub_" . $callback;
        if (isset($$sVarName)) {
            $$sVarName == 1 ? AddCallback($callback, $uIdSuperapix) : DelCallback($callback, $uIdSuperapix);
        }
    }
}
?>

<?php if ($adminview) : ?>
    <table class="og-table og-little-table">
        <form method="post" action="index.php?action=superapix&subaction=admin&admin=1">
            <thead>
                <tr>
                    <th colspan="2">Configuration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tdstat">Numero D'univers</td>
                    <td class="tdvalue">
                        <input type="text" id="uni" name="uni" value="<?= (int) find_config("uni") ?>" placeholder="67" required />
                    </td>
                </tr>
                <tr>
                    <td class="tdstat">Nombre de requete max</td>
                    <td class="tdvalue">
                        <input type="text" id="requete_max" name="requete_max" value="<?= (int) find_config("requete_max") ?>" placeholder="500" required />
                    </td>
                </tr>
                <tr>
                    <td class="tdstat">Pays</td>
                    <td class="tdvalue">
                        <input type="text" id="pays" name="pays" value="<?= find_config("pays") ?>" placeholder="it" required />
                    </td>
                </tr>
                <tr>
                    <td class="tdstat">Temporisation API</td>
                    <td class="tdvalue">
                        <input type="text" id="tempo" name="tempo" maxlength="1" value="<?= (int) find_config("tempo") ?>" placeholder="1" required />
                    </td>
                </tr>
                <tr>
                    <td class="tdstat">Mode developpeur</td>
                    <td class="tdvalue">
                        <select id="debug" name="debug">
                            <option value="0" <?= find_config("debug") == 0 ? 'selected' : '' ?>>NON</option>
                            <option value="1" <?= find_config("debug") == 1 ? 'selected' : '' ?>>OUI</option>
                        </select>
                    </td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th colspan="2">Options xtense CallBacks</th>
                </tr>
            </thead>
            <tbody>
                <?php $tReelCallBacks = GetAllCallBacks($uIdSuperapix); ?>
                <tr>
                    <td colspan="2">Nombre de CallBacks Xtense activé : <span class="og-highlight"><?= count($tReelCallBacks) ?></span></td>
                </tr>
                <?php foreach ($tcallbacks as $callback) : ?>
                    <tr>
                        <td><?= $callback ?></td>
                        <td>
                            <select id="<?= $callback ?>" name="<?= $callback ?>">
                                <option value="0" <?= !in_array($callback, $tReelCallBacks) ? 'selected' : '' ?>>NON</option>
                                <option value="1" <?= in_array($callback, $tReelCallBacks) ? 'selected' : '' ?>>OUI</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <input class="btn og-button" type="submit" value="Envoyer!" />
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
                    <p><a class="btn og-button og-button-danger" href="index.php?action=superapix&reinit">Réinitalisation</a></p>
                    En cas de blocage ponctuel, permet de : Vider le cache XML et de supprimer la date de derniere insertion
                </td>
            </tr>
        </tbody>
    </table>

    <?php if (find_config("debug") == 1) : ?>
        <?php
        loggeur("INFO Conf php allow_url_fopen " . ini_get('allow_url_fopen'));
        loggeur("Conf php max_execution_time " . ini_get('max_execution_time'));
        loggeur("Conf php post_max_size " . ini_get('post_max_size'));
        ?>
    <?php endif; ?>

    <?php if ($tcheckSecurity) : ?>
        <?php foreach ($tcheckSecurity as $error) : ?>
            <div class="og-msg og-msg-danger">
                <p class="og-content"><?= $error ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="og-msg og-msg-success">
            <p class="og-content">La configuration du mod semble correcte</p>
        </div>
    <?php endif; ?>
<?php endif; ?>