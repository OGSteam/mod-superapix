var step = 40;
var currentstep = 0;

function startStepping() {
    startstep(currentstep);
}

function startstep(step) {
    $.ajax({
        url: "mod/superapix/cron.php",
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        success: function (data) {
            console.log(data);
            stepProgressBar(data);


        },
        error: function (err) {
            alert("une erreur est survenue : Vérifiez la console de votre Navigateur");
            console.log("une erreur est survenue " + JSON.stringify(err))
        }

    });


}


function stepProgressBar(data) {
    if (currentstep <= step) { // si bug et reponse inconnu
        if (data == null || data["ok"] == null)
            {
                alert("Une erreur est survenue");
                $('#content').text("Une erreur est survenue"); // information  utilisateur
                $('#avancement').attr('value', step);// change l'attribut'

            }
        else
            if (data["ok"] == "Aucune Action") {
                alert("aucune mise à jour disponible");
                $('#content').text("aucune mise à jour disponible"); // information  utilisateur
                $('#avancement').attr('value', step);// change l'attribut'

            }
            else {
                currentstep = currentstep + 1;
                $('#avancement').attr('value', currentstep);// change l'attribut'
                $('#content').text("<< " + data["ok"] + "(" + data["temps"] + " s) >>"); // information  utilisateur
                startstep(currentstep); // next step
            }
        }
    }



