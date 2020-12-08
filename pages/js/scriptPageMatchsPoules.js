//on passe du tableau de chaine de caractères en tableau clé => valeur (ex : eq1-eq3 => "2-0")
function StringtoTab(tableauString)
{
    var tab = [];
    var equipesScore = tableauString.split(',');
    index = 0;
    while (equipesScore[index]) {
        console.log(equipesScore[index]);
        var separationEquipeScore = equipesScore[index].split('_');//soit ramplacer par un for soit découper le string ("eq1-eq2_14-15") dans le else
        tab[separationEquipeScore[0]] = separationEquipeScore[1];

        index++; 
    }

    return tab;
}

//on récupère dans un tableau toutes les équipes pour pouvoir itéré sur le tableau des scores (clé valeur) 
function getEquipes(tableauString) {
    var tab = [];
    var equipesScore = tableauString.split(',');
    index = 0;
    while (equipesScore[index]) {
        console.log(equipesScore[index]);
        var separationEquipeScore = equipesScore[index].split('_');
        tab[index] = separationEquipeScore[0];

        index++; 
    }

    return tab;
}

//vérifie que chaque équipe de notre tableau des scores à un score
function tousLesScoresSontRemplis(tableauScore, tableauEquipes)
{
    index = 0;
    while (tableauEquipes[index]) {
        if (tableauScore[tableauEquipes[index]] === "") {
            return false;
        }
        index++;
    }

    return true;
}

//renvoi la liste des équipes qui passe au prochain tour
function getEquipesProchainTour() {
    let listeEquipes = "";
    //en fct du nb d'équipes dans le tour (faire une fonction) => on connait le nb d'équipes à renvoyer (ex : >8 = 8, >4 = 4, <4 = 1)
    //en fct des scores => on connait le classement (faire une foncton)
    //avec les deux variables précédentes on renvoi les n premères équipes dans le classement

    return listeEquipes;
}

//permet de mettre à jour la variable global "$_SESSION['classementTournois']" 
// => il reste à trouver une solution !!!!
function miseAJourClassement() {

}

function validerTour(strMatchsScore)
{
    let tableauScore = StringtoTab(strMatchsScore);
    console.log(tableauScore);
    let tableauEquipes = getEquipes(strMatchsScore);
    console.log(tableauEquipes);

    if(tousLesScoresSontRemplis(tableauScore, tableauEquipes))//envoie de la liste des joueurs qui continuent au tour prochain, remplis le classement du tournois
    {
        listeEquipesPourProchainTour = getEquipesProchainTour();
        let listeEquipes = '<input type="hidden" name="listeEquipes" value="' + listeEquipesPourProchainTour + '">';

        miseAJourClassement();

        $("#validerTour").append(listeEquipes);
        $("#validerTour").submit();
    }
    else //msg d'alerte 'tous les matchs ne sont pas encore terminés'
    {
        alert("Erreur, Tous les matchs ne sont pas encore terminés !");
    }
}