<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
$temp = constante_stepper();
$step = $temp[(int)($pub_step)]; // récuperation de la ""cle""
$now = time();
?>

<script >
$(document).ready(function() {
    
step = <?php echo (int)($pub_step) ;?> ;    
    
<?php if (is_out_of_date($step)) : ?>
    
// ben vu qu on est ready, on va taffer :
<?php if( strstr($step, "CST_UNIVERSE")): ?> 


get_CST_crossdomain("CST_UNIVERSE");
sending_conteneur_CST_UNIVERSE("<?php echo $step;?>")  ;



<?php else  : ?>

get_CST_crossdomain("<?php echo $step;?>");
sending_conteneur_<?php echo $step;?>("<?php echo $step;?>")      
    
    
<?php endif ; ?>






<?php else : ?>
next_step(<?php echo (int)($pub_step) ; ?>)  
    
 <?php endif ; ?> 
  
});
</script>



<?php




//1 on attend que la page sois chargé 
//2 on recupere les infos distantes ...
//3 on envoit les infos /// des que retour on passe a step + 1
