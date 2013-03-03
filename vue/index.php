<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if (isset($pub_uni)){insert_config("uni", (int)($pub_uni)); }

$tab =  constante_stepper();

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
	<th width="60%">lancer la mise a jour</th>
	<th><?php if (((int)find_config("uni")) != 0) :?><a href="index.php?action=superapix&step=0">ENJOY</a><?php else : ?> <?php endif ; ?></th>
</tr>
<tr>
<td class="c_tech" colspan="2">Information serveur</td>
</tr>
<tr>
	<th width="60%">allow_url_fopen</th>
	<th><?php echo ini_get('allow_url_fopen');?></th>
</tr>



<tr>
<td class="c_tech" colspan="2">Dernieres maj via superapix</td>
</tr>

<?php foreach ($tab as $key => $value) : ?>
<tr>
	<th width="60%"><?php echo $value ; ?></th>
	<th><?php echo strftime("%d %b %Y %H:%M", ((int)find_config("last_".$value)));?></th>
</tr>
<?php endforeach ; ?>
</table>

<?php


//var_dump($user_data);