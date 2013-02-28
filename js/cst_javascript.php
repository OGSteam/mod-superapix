<?php 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

?>

<script type="text/javascript">
var nb_gal = <?php echo $server_config['num_of_galaxies'] ; ?>;
var nb_sys =  <?php echo $server_config['num_of_systems'] ; ?>;
var nb_row = 15 ;
var nb_send_max = 500;
var conteneur = null;
var timestamp = null;
var value = null;
var step = null;
var task = 0;

</script>
