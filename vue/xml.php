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
<?php $xmlPath = MOD_ROOT_XML . "CST_SERVERDATA.xml";?>

<?php if (is_file($xmlPath)) : ?>
    <?php $simpleXml = simplexml_load_file($xmlPath); ?>
    <?php echo convertXmlToHtmlTable($simpleXml); ?>
<?php else : ?>
    <div class="og-msg og-msg-danger">
        <h3 class="og-title">Fichier absent</h3>
        <p class="og-content">Le XML de configuration du serveur ogame n'est pas présent.</p>
    </div>
<?php endif; ?>

<?php
function convertXmlToHtmlTable($xml) {
    $html = "<table align='center' border='1' class='og-table og-full-table'>
                <thead><tr><th colspan='2'>" . htmlspecialchars((string)$xml->getName(), ENT_QUOTES, 'UTF-8') . "</th></tr></thead>
                <tbody>";

    foreach ($xml->children() as $ele) {
        $elename = $ele->getName();
        $attributes = "";

        if ($ele->attributes()->count()) {
            foreach ($ele->attributes() as $attribName => $attribValue) {
                $attributes .= "\n" . htmlspecialchars((string)$attribName, ENT_QUOTES, 'UTF-8') . "='" . htmlspecialchars((string)$attribValue, ENT_QUOTES, 'UTF-8') . "'";
            }
        }

        $html .= "<tr><td>{$elename}{$attributes}</td>";

        if ($ele->count()) {
            $html .= "<td>" . convertXmlToHtmlTable($ele) . "</td>";
        } else {
            $html .= "<td>" . htmlspecialchars((string)$ele, ENT_QUOTES, 'UTF-8') . "</td>";
        }

        $html .= "</tr>";
    }

    $html .= "</tbody></table>";

    return $html;
}
?>