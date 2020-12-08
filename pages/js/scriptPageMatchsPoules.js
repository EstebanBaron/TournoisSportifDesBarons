

function StringtoTab(cdc)
{
    var arrayEqScore  = cdc.split(",");
    var arrayEqScore2  = arrayEqScore.split("_")//soit ramplacer par un for soit découper le string ("eq1-eq2_14-15") dans le else
    var tab = [];
    for(var i=0; i<arrayEqScore2.length; i++)
    {
        if(arrayEqScore2[i] == NULL)
        {
            i=arrayEqScore2.length;
            return false;
        }
        else
        {
            tab.push($arrayEqScore2[i]);
            tab[$arrayEqScore2[i][0]] = $arrayEqScore2[i+1];
            i += 2;
        }
    }
    return tab;
}


function tousLesScoresSontRemplis()
{

}


function validerTour(strMatchsScore)
{
    console.log(StringtoTab(strMatchsScore));
    // if(tousLesScoresSontRemplis())//créer le classement du Tour, envoie de la liste des joueurs qui continuent au tour prochain, remplis le classement du tournois
    // {

    // }
    // else //msg d'alerte 'tous les matchs ne sont pas encore terminés'
    // {

    // }
}