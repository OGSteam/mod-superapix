<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

// etapes
$tab = constante_stepper();
$tcheckSecurity = checkSecurity();
$tcallbacks = constante_xtense_callbacks();
$uIdSuperapix = spaModId();


?>

<style>
    .progress {
        width: 100%;
        height: 30px;
        color: #ddd;
        padding: 3px 3px 3px 3px;
        border-radius: 5px;
    }

    .progress[value] {
        --color: Green;
        --background: lightgrey;
        appearance: none;
        border: none;
        width: 100%;
        padding: 3px 3px 3px 3px;
        border-radius: 5px;
        background: var(--background);
    }


</style>



<div class="og-msg ">
    <h3 class="og-title">Mod Superapix</h3>
    <p class="og-content">Superapix est un mod Ogspy permettant de mettre à jour depuis l'api XML d'ogame</p>
    <p class="og-content">Celui ci est maintenant profilé pour automatiquement se mettre à jour sans actions utilisateurs </p>
</div>



<div class="og-msg">
    <progress id="spaavancement" class="progress" value="0" max="39">

    </progress>
    <p id="spacontent" class="og-highlight"></p>


</div>



<?php if ($tcheckSecurity != NULL) : ?>
    <div class="og-msg og-msg-danger ">
        <h3 class="og-title">Mod Superapix</h3>
        <p class="og-content"> La configuration du mod semble incorrecte (<?php echo count($tcheckSecurity); ?> erreur(s)).</p>
    </div>
<?php else : ?>
    <!--
    <div class="og-msg og-msg-success">
        <p class="og-content">La configuration du mod semble correcte <br> </p>
        <br>

    </div>
-->
    <table class="og-table ">
        <tbody>
            <tr>
                <td>
                    <a class="og-button og-button-success" class="btn" onclick="startStepping()">Mettre à jour </a>
                </td>
            </tr>
        </tbody>


    </table>


<?php endif; ?>

<table class="og-table og-small-table">
    <thead>
        <tr>
            <th colspan="2"><?php echo help("liste des dernieres mises à jour"); ?>Dernieres mise à jour</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tab as $key => $value) : ?>
            <tr>
                <td class="tdstat">
                    <?php echo lang($value); ?>
                </td>
                <td class="tdvalue">
                    <?php echo date('d M Y H:i', ((int) find_config("last_" . $value))); ?>
                </td>
            </tr>
        <?php endforeach; ?>


    </tbody>
</table>

<script src="mod/superapix/js/step.js"></script>