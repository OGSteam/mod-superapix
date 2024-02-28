<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");
$pub_subaction = (isset($pub_subaction)) ? $pub_subaction : "superapix";
$activelink = ($pub_subaction == "link") ? "active" : "";
$activeadmin = ($pub_subaction == "admin") ? "active" : "";
$activesuperadmin = ($pub_subaction == "superapix") ? "active" : "";

?>

<div class="nav-page-menu">
<div class="nav-page-menu-item  <?php echo $activesuperadmin; ?> ">
        <a class="nav-page-menu-link" href="index.php?action=superapix&amp;subaction=superapix">
            Superapix
        </a>
    </div>
    <div class="nav-page-menu-item  <?php echo $activelink; ?> ">
        <a class="nav-page-menu-link" href="index.php?action=superapix&amp;subaction=link">
            Liens
        </a>
    </div>
    <div class="nav-page-menu-item  <?php echo $activeadmin; ?> ">
        <a class="nav-page-menu-link" href="index.php?action=superapix&amp;subaction=admin">
            Administration
        </a>
    </div>
</div>