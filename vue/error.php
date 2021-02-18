<?php
/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2020, http://ogsteam.eu/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");


include_once MOD_ROOT_VUE . "css.php";

?>


<?php if (isset($errormsg)): ?>
    <?php foreach ($errormsg as $msg) : ?>
        <p class="error">
            <?php echo $msg; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>


