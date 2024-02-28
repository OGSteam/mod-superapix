$(document).ready(function () {
  //alert($(location).attr('href'));

  next_step(step)

});

function next_step(nb) {
  nb = nb + 1;
  limit = count(constante_stepper()) +1 ;
  if (nb == limit) { window.location = "index.php?action=superapix&step=0"; }
  else {
    window.location = "index.php?action=superapix&sub_action=cross&step=" + nb;
  }

}
