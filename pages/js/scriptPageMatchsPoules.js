//on passe du tableau de chaine de caractères en tableau clé => valeur (ex : eq1-eq3 => "2-0")
function StringtoTab(tableauString)
{
    var tab = [];
    var equipesScore = tableauString.split(',');
    index = 0;
    while (equipesScore[index]) {
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
        var separationMatchScore = equipesScore[index].split('_');
        tab[index] = separationMatchScore[0];

        index++; 
    }

    return tab;
}

//vérifie que chaque équipe de notre tableau des scores à un score
function tousLesScoresSontRemplis(tableauScore, tableauMatchs)
{
    index = 0;
    while (tableauMatchs[index]) {
        if (tableauScore[tableauMatchs[index]] === "") {
            return false;
        }
        index++;
    }

    return true;
}

function getNbPoule(poules) {
    separationPoules = poules.split(',');

    return separationPoules.length;
}

function getNbEquipeDeSaPoule(equipe, poules) {
    let compteur = 0;
    let estDansCettePoule = false;

    let separationPoules = poules.split(',');
    let index = 0;
    while (!estDansCettePoule && index < separationPoules.length) {
        let separationEquipe = separationPoules[index].split('-');
        let indexParcoursEquipes = 0;
        while (indexParcoursEquipes < separationEquipe.length) {
            if (separationEquipe[indexParcoursEquipes] === equipe) {
                estDansCettePoule = true;
            }
            compteur++;
            indexParcoursEquipes++;
        }
        if (!estDansCettePoule)
            compteur = 0;
        index++;
    }
    
    return compteur;
}

function getNbEquipeProchainTour(tableauMatchs, poules) {
    let indexTableau = 0;
    let tabEquipes = [];

    let index = 0;
    while (tableauMatchs[index]) {
        separationEquipes = tableauMatchs[index].split('-');
        if (!tabEquipes.includes(separationEquipes[0])) {
            tabEquipes[indexTableau] = separationEquipes[0];
            indexTableau++;
        }
        if (!tabEquipes.includes(separationEquipes[1])) {
            tabEquipes[indexTableau] = separationEquipes[1];
            indexTableau++;
        }
        index++;
    }

    let nbPoule = getNbPoule(poules);
    let nbTotalEquipes = tabEquipes.length;
    if (nbTotalEquipes > 8 && nbTotalEquipes - 8 >= nbPoule) { //on regarde si on peut enlever une equipe par poule et etre tj >= 8
        return 8; //quart 
    }
    else if (nbTotalEquipes > 4 && nbTotalEquipes - 4 >= nbPoule) {
        return 4; //demi
    }
    else if (nbTotalEquipes > 3 && nbTotalEquipes - 3 >= nbPoule) { //3 poules de 2 joueurs (6 joueurs)
        return 3; //final
    }
    else if (nbTotalEquipes > 2 && nbTotalEquipes - 2 >= nbPoule) { //2 quand nbTotaleEquipe = 5, 4, 3
        return 2; //final
    }
    else {
        return 1;
    }
}

function rempliTabPointParEquipe(tableauScore, tableauMatchs) {
    //tabMatchsPointParEquipe = {nomEquipe: [nbMatchGagné, nbMatchPerdu, nbMatchEgalité], ...}
    let tabMatchsPointParEquipe = [];

    index = 0;
    while (tableauMatchs[index]) {
        let score = tableauScore[tableauMatchs[index]];
        separationScore = score.split('-');
        separationEquipes = tableauMatchs[index].split('-');

        //si equipe 1 gagne
        if (separationScore[0] > separationScore[1]) {
            if (tabMatchsPointParEquipe.includes(separationEquipes[0])) {
                tabMatchsPointParEquipe[separationEquipes[0]][0]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][0] = 1;
            }
            if (tabMatchsPointParEquipe.includes(separationEquipes[1])) {
                tabMatchsPointParEquipe[separationEquipes[1]][1]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[1]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[1]][1] = 1;
            }
        }
        //si equipe 2 gagne
        else if (separationScore[0] < separationScore[1]) {
            if (tabMatchsPointParEquipe.includes(separationEquipes[0])) {
                tabMatchsPointParEquipe[separationEquipes[0]][1]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][1] = 1;
            }
            if (tabMatchsPointParEquipe.includes(separationEquipes[1])) {
                tabMatchsPointParEquipe[separationEquipes[1]][0]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[1]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[1]][0] = 1;
            }
        }
        //si egalité
        else {
            if (tabMatchsPointParEquipe.includes(separationEquipes[0])) {
                tabMatchsPointParEquipe[separationEquipes[0]][2]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][2] = 1;
            }
            if (tabMatchsPointParEquipe.includes(separationEquipes[1])) {
                tabMatchsPointParEquipe[separationEquipes[1]][2]++;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[1]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[1]][2] = 1;
            }
        }

        index++;
    }
    return tabMatchsPointParEquipe;
}

// function pointGagneSurPointPerdu(equipe) {

// }

function getClassement(strMatchsScore, tabMatchsPointParEquipe, poules) {
    let copyTabPoints = tabMatchsPointParEquipe;

    let indexClassement = 0;
    let classement = [];

    let tabEquipes = getEquipes(strMatchsScore);
    while (classement.lengt < tabEquipes.length) {
        index = 0;
        let equipePlusPoint = tabEquipes[0];
        while (tabEquipes[index]) {
            //marche si une seule equipe avec le plus de match gagné
            if (copyTabPoints[tabEquipes[index]][0] > copyTabPoints[equipePlusPoint][0]) {
                equipePlusPoint = tabEquipes[index];
            }
            //nombre de matchs gagné égalité alors => nbMatchGagné/nbEquipePoule
            else if (copyTabPoints[tabEquipes[index]][0] === copyTabPoints[equipePlusPoint][0] && (copyTabPoints[tabEquipes[index]][0]/getNbEquipeDeSaPoule(tabEquipes[index], poules)) > (copyTabPoints[equipePlusPoint][0]/getNbEquipeDeSaPoule(equipePlusPoint, poules))) {
                equipePlusPoint = tabEquipes[index];
            }
            //en fonction du score de leur match nbPoint mis sur tous les matchs et le diviser par le nombre de point pris sur tous les matchs => comparer avec l'autre equipe
            // else if (copyTabPoints[tabEquipes[index]][0] === copyTabPoints[equipePlusPoint][0] && (copyTabPoints[tabEquipes[index]][0]/getNbEquipeDeSaPoule(tabEquipes[index], poules)) === (copyTabPoints[equipePlusPoint][0]/getNbEquipeDeSaPoule(equipePlusPoint, poules)) && pointGagneSurPointPerdu(tabEquipes[index]) > pointGagneSurPointPerdu(equipePlusPoint)) {
            //     equipePlusPoint = tabEquipes[index];
            // }
            index++;
        }
        //on met le nombre de point de l'equipe avec le plus de point à 0 pour la 'sortir' des equipes à regarder
        classement[indexClassement] = equipePlusPoint;
        copyTabPoints[equipePlusPoint] = [0, 0, 0];
        
        indexClassement++;
    }

    return classement;
}

//renvoi la liste des équipes qui passe au prochain tour
function getEquipesProchainTour(strMatchsScore, tableauScore, tableauMatchs, poules) {
    let listeEquipes = "";
    //en fct du nb d'équipes dans le tour (faire une fonction) => on connait le nb d'équipes à renvoyer (ex : > 8 = 8, 7-4 > 2 &&  > 4 = 4, <4 = 1)
    //en fct des scores => on connait le classement (faire une foncton)
    //avec les deux variables précédentes on renvoi les n premières équipes dans le classement
    let nbEquipesProchainTour = getNbEquipeProchainTour(tableauMatchs, poules);
    let tabMatchsPointParEquipe = rempliTabPointParEquipe(tableauScore, tableauMatchs);

    console.log(tabMatchsPointParEquipe);
    let classement = getClassement(strMatchsScore, tabMatchsPointParEquipe, poules);    //tab = {eq1, eq3, eq4}; en fonction de leur point
    //retourner les nbEquipeProchainTour-nbPoule premieres equipes de chaque poule (ex : 3 Poules de 2 joueurs => 1 joueur de chaque poule)
    //2 poules 4 joueurs => 2 joueur par poules selectionné (nbEquipeProchainTour = 4, nbPoules = 2. On a bien 2 equipes par poule)


    return listeEquipes;
}

//permet de mettre à jour la variable global "$_SESSION['classementTournois']" 
// => il reste à trouver une solution !!!!
function miseAJourClassement() {

}

function validerTour(strMatchsScore, poules)
{
    let tableauScore = StringtoTab(strMatchsScore);
    console.log(tableauScore);
    let tableauMatchs = getEquipes(strMatchsScore);
    console.log(tableauMatchs);

    console.log(getNbEquipeProchainTour)

    if(tousLesScoresSontRemplis(tableauScore, tableauMatchs))//envoie de la liste des joueurs qui continuent au tour prochain, remplis le classement du tournois
    {
        listeEquipesPourProchainTour = getEquipesProchainTour(strMatchsScore, tableauScore, tableauMatchs, poules);
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