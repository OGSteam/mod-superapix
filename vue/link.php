<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

?>
<table class="og-table og-small-table">
    <thead>
        <tr>
            <th>Liens</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <a href="index.php?action=superapix&amp;subaction=link&amp;help">Aide à L'usage (Tuto Video)</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="https://forum.ogsteam.eu/">Forum Ogsteam/</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="https://forum.ogsteam.eu/index.php?topic=783.0">Topic du mod/</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="https://github.com/OGSteam/mod-superapix/issues">Signaler un Bug/</a>
            </td>
        </tr>
    </tbody>
</table>

<?php if (isset($pub_help)) : ?>
    <table class="og-table og-small-table">
        <tr>
            <td>
                <iframe width="880" height="470" src="https://www.youtube.com/embed/2Y6iT6jYnk0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen>
                </iframe>
            </td>
        </tr>

    </table>
<?php endif; ?>