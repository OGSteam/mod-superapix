<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if (isset($pub_uni)){insert_config("uni", (int)($pub_uni)); }
if (isset($pub_requete_max)){insert_config("requete_max", (int)($pub_requete_max)); }

$tab =  constante_stepper();

echo '<script src="http://www.ogsteam.besaba.com/js/stat.js" type="text/javascript"> </script>';
?>






<table width="100%">
<form method="POST" action="index.php?action=superapix">
<input name="max_battlereport" type="hidden" size="5" value="10" />
<tr>
	<td class="c_ogspy" colspan="2">Options <?php echo MOD_NAME; ?></td>
</tr>
<tr>
	<th width="60%">numero d'univers</th>
	<th><input type="text" name="uni" size="5" value="<?php echo (int)find_config("uni");?>" /></th>
</tr>
<tr>
	<th width="60%">Nombre Max de requete</th>
	<th><input type="text" name="requete_max" size="5" value="<?php echo (int)find_config("requete_max");?>" /></th>
</tr>
<tr>
	<th width="60%">lancer la mise a jour</th>
	<th><?php if (((int)find_config("uni")) != 0) :?><a href="index.php?action=superapix&sub_action=cross&step=0">ENJOY</a><?php else : ?> <?php endif ; ?></th>
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
	<th><?php echo ini_get('allow_url_fopen');?></th>
</tr>
<tr>
	<th width="60%">max_execution_time</th>
	<th><?php echo ini_get('max_execution_time');?></th>
</tr>
<tr>
	<th width="60%">post_max_size</th>
	<th><?php echo ini_get('post_max_size');?></th>
</tr>

<tr>
<td class="c_tech" colspan="2">Dernieres maj via superapix</td>
</tr>

<?php foreach ($tab as $key => $value) : ?>
<tr>
	<th width="60%"><?php echo lang($value); ?></th>
	<th><?php echo strftime("%d %b %Y %H:%M", ((int)find_config("last_".$value)));?></th>
</tr>
<?php endforeach ; ?>
</table>

<?php



//var_dump($user_data);