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
<?php $xml =  MOD_ROOT_XML .  "CST_SERVERDATA.xml"; ?>
<?php if (is_file($xml)) : ?>
    <?php $simplexml = simplexml_load_file($xml); ?>
    <?php echo ConvertXmlToHtmlTable($simplexml); ?>
<?php else : ?>
    <div class="og-msg og-msg-danger ">
        <h3 class="og-title">Fichier absent</h3>
        <p class="og-content"> Le XML de configuration du serveur ogame n'est pas present?</p>
    </div>
<?php endif; ?>




<?php
function ConvertXmlToHtmlTable($xml) {
    $html = "<table align='center' border='1' class='og-table og-full-table'>\r\n";
    $html .= "<thead><tr><th colspan='2'>".$xml->getName()."</th></tr></thead>\r\n";
    $html .= "<tbody>";
    foreach ($xml->children() as $ele) {
        $elename = $ele->getName();
        $attributes = "";
        
        if ($ele->attributes()->count()) {
            foreach ($ele->attributes() as $attribName => $attribValue) {
                $attributes .= "\r\n" . $attribName . "=" . $attribValue;
            }
        }
        
        $html .= "<tr><td>{$elename}{$attributes}</td>";
        
        if ($ele->count()) {
            $html .= "<td>" . ConvertXmlToHtmlTable($ele) . "</td>";
        } else {
            $html .= "<td>{$ele}</td>";
        }
        
        $html .= "</tr>";
    }
    $html .= "</tbody>";
    $html .= "</table>";
    
    return $html;
}
