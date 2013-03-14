$(document).ready(function() {

next_step(step);

});

function next_step(nb)
{
    nb = nb + 1 ;
    if ( nb == 19 ) {
        window.location = "index.php?action=superapix"  ;
         }
    else
    {
        window.location = "index.php?action=superapix&step=" + nb ;
    }
     
}
