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
function getMatchs(tableauString) {
    var tab = [];
    var matchsScore = tableauString.split(',');
    index = 0;
    while (matchsScore[index]) {
        var separationMatchScore = matchsScore[index].split('_');
        tab[index] = separationMatchScore[0];

        index++; 
    }

    return tab;
}

function getEquipes(tableauString) {
    let indexTab = 0;
    let tab = [];

    let tableauMatchs = getMatchs(tableauString);
    let index = 0;
    while (index < tableauMatchs.length) {
        let separationEquipes = tableauMatchs[index].split('-');
        if (!tab.includes(separationEquipes[0])) {
            tab[indexTab] = separationEquipes[0];
            indexTab++;
        }
        if (!tab.includes(separationEquipes[1])) {
            tab[indexTab] = separationEquipes[1];
            indexTab++;
        }
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
    while (index < tableauMatchs.length) {
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
            if (separationEquipes[0] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[0]][0] += 1;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][0] = 1;
            }
            if (separationEquipes[1] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[1]][1] += 1;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[1]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[1]][1] = 1;
            }
        }
        //si equipe 2 gagne
        else if (separationScore[0] < separationScore[1]) {
            if (separationEquipes[0] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[0]][1] += 1;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][1] = 1;
            }
            if (separationEquipes[1] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[1]][0] += 1;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[1]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[1]][0] = 1;
            }
        }
        //si egalité
        else {
            if (separationEquipes[0] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[0]][2] += 1;
            }
            else {
                tabMatchsPointParEquipe[separationEquipes[0]] = [0, 0, 0];
                tabMatchsPointParEquipe[separationEquipes[0]][2] = 1;
            }
            if (separationEquipes[1] in tabMatchsPointParEquipe) {
                tabMatchsPointParEquipe[separationEquipes[1]][2] += 1;
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


function afficheTab(tabMatchsPointParEquipe) {
    let keys = Object.keys(tabMatchsPointParEquipe);
    let index = 0;
    while (index < keys.length) {
        console.log(keys[index] + " : ");
        for (i = 0; i < 3; i++) {
            console.log(tabMatchsPointParEquipe[keys[index]][i]);
        }
        index++;
    }
}

function getClassement(strMatchsScore, tabMatchsPointParEquipe, poules) {
    let copyTabPoints = tabMatchsPointParEquipe;

    let indexClassement = 0;
    let classement = [];

    let tabEquipes = getEquipes(strMatchsScore);
    while (classement.length < tabEquipes.length) {
        let indexCherchePremier = 0;
        let equipePlusPoint;
        do {
            equipePlusPoint = tabEquipes[indexCherchePremier];
            indexCherchePremier++;
        } while (copyTabPoints[equipePlusPoint][0] == -1);

        index = 0;
        while (index < tabEquipes.length) {
            //variables bool
            let plusVictoire = copyTabPoints[tabEquipes[index]][0] > copyTabPoints[equipePlusPoint][0];
            let victoireEgale = copyTabPoints[tabEquipes[index]][0] === copyTabPoints[equipePlusPoint][0];
            let victoireEgaleMaisQuotientVictoireNbJoueurDansLaPouleSup = victoireEgale && (copyTabPoints[tabEquipes[index]][0]/getNbEquipeDeSaPoule(tabEquipes[index], poules)) > (copyTabPoints[equipePlusPoint][0]/getNbEquipeDeSaPoule(equipePlusPoint, poules));
            let QuotientVictoireNbJoueurDansLaPouleEgale = (copyTabPoints[tabEquipes[index]][0]/getNbEquipeDeSaPoule(tabEquipes[index], poules)) === (copyTabPoints[equipePlusPoint][0]/getNbEquipeDeSaPoule(equipePlusPoint, poules));
            let quotientMatchPerduSurMatchJoue = victoireEgale && QuotientVictoireNbJoueurDansLaPouleEgale && (copyTabPoints[tabEquipes[index]][1]/getNbEquipeDeSaPoule(tabEquipes[index], poules)) < (copyTabPoints[equipePlusPoint][1]/getNbEquipeDeSaPoule(equipePlusPoint, poules));
            //VICTOIREs
            //marche si une seule equipe avec le plus de match gagné
            if (plusVictoire) {
                equipePlusPoint = tabEquipes[index];
            }
            //nombre de matchs gagné égalité alors => nbMatchGagné/nbEquipePoule
            else if (victoireEgaleMaisQuotientVictoireNbJoueurDansLaPouleSup) {
                equipePlusPoint = tabEquipes[index];
            }
            //DEFAITES
            //nombre de matchs gagné égalité alors => nbMatchGagné/nbEquipePoule
            else if (quotientMatchPerduSurMatchJoue) {
                equipePlusPoint = tabEquipes[index];
            }
            else if (quotientMatchPerduSurMatchJoue) {
                equipePlusPoint = tabEquipes[index];
            }
            index++;
        }
        //on met le nombre de point de l'equipe avec le plus de point à -1 pour la 'sortir' des equipes à regarder
        classement[indexClassement] = equipePlusPoint;
        copyTabPoints[equipePlusPoint] = [-1, -1, -1];
        
        indexClassement++;
    }

    return classement;
}

//ex : tab = {eq1: 0, eq3: 1} où 0 et 1 sont les poules de eq1 et eq3
function getTabEquipePoule(poules) {
    let tabEquipePoule = [];

    let separationPoule = poules.split(',');
    index = 0;
    while (index < separationPoule.length) {
        let indexParcoursEquipe = 0;
        let separationEquipes = separationPoule[index].split('-');
        while (indexParcoursEquipe < separationEquipes.length) {
            tabEquipePoule[separationEquipes[indexParcoursEquipe]] = index;
            indexParcoursEquipe++;
        }

        index++;
    } 

    return tabEquipePoule;
}   

//renvoi la liste des équipes qui passe au prochain tour
function getEquipesProchainTour(strMatchsScore, tableauScore, tableauMatchs, poules) {
    let listeEquipes = "";
    //en fct du nb d'équipes dans le tour (faire une fonction) => on connait le nb d'équipes à renvoyer (ex : > 8 = 8, 7-4 > 2 &&  > 4 = 4, <4 = 1)
    //en fct des scores => on connait le classement (faire une fonction)
    //avec les deux variables précédentes on renvoie les n premières équipes dans le classement
    let nbEquipesProchainTour = getNbEquipeProchainTour(tableauMatchs, poules);
    let tabMatchsPointParEquipe = rempliTabPointParEquipe(tableauScore, tableauMatchs);

    let classement = getClassement(strMatchsScore, tabMatchsPointParEquipe, poules);    //tab = {eq1, eq3, eq4}; en fonction de leur point
    //retourner les nbEquipeProchainTour-nbPoule premieres equipes de chaque poule (ex : 3 Poules de 2 joueurs => 1 joueur de chaque poule)
    //2 poules 4 joueurs => 2 joueur par poules selectionné (nbEquipeProchainTour = 4, nbPoules = 2. On a bien 2 equipes par poule)
    let tabEquipePoule = getTabEquipePoule(poules);
    let tableauPouleEncorePossible = []; //ex : tab = {(poule)0 = 3, 1 = 2} on peut encore prendre 3joueurs de la poule 0 et 2 joueurs de la poule 1
    let nbPoule = getNbPoule(poules);
    let index = 0;
    while (index < nbPoule) {
        tableauPouleEncorePossible[index] = nbEquipesProchainTour/nbPoule;
        index++;
    }

    let tabEquipesProchainTour = []; //listeEquipe sous forme de tableau
    index = 0;

    let indexParcoursClassement = 0;
    //on parcours le classement en regardant a chaque fois si la poule de l'équipe peut encore donner un joueur pour le prochain tour
    while (tabEquipesProchainTour.length < nbEquipesProchainTour) {
        let pouleDeLequipe = tabEquipePoule[classement[indexParcoursClassement]];
        if (tableauPouleEncorePossible[pouleDeLequipe] > 0) {
            tabEquipesProchainTour[index] = classement[indexParcoursClassement];
            index++;
            tableauPouleEncorePossible[pouleDeLequipe]--;
        }

        indexParcoursClassement++;
    } 
    //transforme le tableau en string
    index = 0;
    while (index < tabEquipesProchainTour.length) {
        listeEquipes += tabEquipesProchainTour[index] + ",";
        index++;
    }
    listeEquipes = listeEquipes.substring(0, listeEquipes.length-1);

    return listeEquipes;
}

//permet de mettre à jour la variable global "$_SESSION['classementTournois']" 
function getClassementPerdants(strMatchsScore, tableauScore, tableauMatchs, poules) {
    let classementPerdants = "";
    //en fct du nb d'équipes dans le tour (faire une fonction) => on connait le nb d'équipes à renvoyer (ex : > 8 = 8, 7-4 > 2 &&  > 4 = 4, <4 = 1)
    //en fct des scores => on connait le classement (faire une foncton)
    //avec les deux variables précédentes on renvoi les n premières équipes dans le classement
    let tabMatchsPointParEquipe = rempliTabPointParEquipe(tableauScore, tableauMatchs);

    let classement = getClassement(strMatchsScore, tabMatchsPointParEquipe, poules);    //tab = {eq1, eq3, eq4}; en fonction de leur point
    let listeGagnants = getEquipesProchainTour(strMatchsScore, tableauScore, tableauMatchs, poules);
    let tabGagnants = listeGagnants.split(',');
      
    let index = 0;
    while (index < classement.length) {
        if (!tabGagnants.includes(classement[index])) {
            classementPerdants += classement[index] + ",";
        }

        index++;
    }
    classementPerdants = classementPerdants.substring(0, classementPerdants.length-1);

    return classementPerdants;
}

function validerTour(strMatchsScore, poules)
{
    let tableauScore = StringtoTab(strMatchsScore);
    let tableauMatchs = getMatchs(strMatchsScore);  

    if(tousLesScoresSontRemplis(tableauScore, tableauMatchs))//envoie de la liste des joueurs qui continuent au tour prochain, remplis le classement du tournois
    {
        let listeEquipesPourProchainTour = getEquipesProchainTour(strMatchsScore, tableauScore, tableauMatchs, poules);
        let listeEquipes = '<input type="hidden" name="listeEquipes" value="' + listeEquipesPourProchainTour + '">';

        let classementPerdantsDuTour = getClassementPerdants(strMatchsScore, tableauScore, tableauMatchs, poules);
        let classmentTourPerdants = '<input type="hidden" name="classementTour" value="' + classementPerdantsDuTour + '">';
        
        $("#validerTour").append(listeEquipes);
        $("#validerTour").append(classmentTourPerdants);
        $("#validerTour").submit();
    }
    else //msg d'alerte 'tous les matchs ne sont pas encore terminés'
    {
        alert("Erreur, Tous les matchs ne sont pas encore terminés !");
    }
}