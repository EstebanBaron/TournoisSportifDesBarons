function onDragStart(event) {
    //définir l'id de l'élément qu'on drag
    event
        .dataTransfer
        .setData('text/plain', event.target.id);
        
    //mise en jaune de l'équipe qu'on est entrain de drag
    event
        .currentTarget
        .style
        .backgroundColor = '#D11D20';
}

//la div devient une zone de drop potentiel
function onDragOver(event) {
    event.preventDefault();
}

function onDrop(event) {
    const id = event
        .dataTransfer
        .getData('text/plain');

    //on récupère l'objet draggable
    const draggableElement = document.getElementById(id);

    //on récupère la cible
    const dropzone = event.target;

    //Deux cas : 
    //1) cas où la dropzone est une équipe => la dropzone devient son parent (la poule)
    if (dropzone.className !== 'poules') {  
        const dropzoneParent = event.target.parentNode;
        dropzoneParent.appendChild(draggableElement);
        //on clear les data transféré de la zone du départ
        event
            .dataTransfer
            .clearData();
    }
    //2) cas où la dropzone est bien une poule => on drop puis clear les data sans changer de cible
    else {
        dropzone.appendChild(draggableElement);
        event
            .dataTransfer
            .clearData();
    }
}


function verifieChangement(nbEquipeParPoule, formuleImpaire) {
    let poules = document.getElementsByClassName("poules");
    let poulesString = "";

    let bienModifie = true;
    let index = 0;
    //on parcours les divs qui contient les poules
    while (poules[index] != null) {
        console.log(poules[index]);
        let nbEquipeDeLaPoule = poules[index].childElementCount;

        //une poule peut avoir 3 équipes pour la formule 2x2+1x3 par exemple
        let nbEquipeParPouleFormuleImpaire = nbEquipeParPoule;
        if (formuleImpaire) {
            nbEquipeParPouleFormuleImpaire++;
        }
        if (nbEquipeDeLaPoule !== nbEquipeParPoule && nbEquipeDeLaPoule !== nbEquipeParPouleFormuleImpaire) {
            bienModifie = false;
        }
        //on créer le noubeau string des poules à renvoyer
        let indexEquipe = 0;
        let equipes = poules[index].childNodes;
        while (indexEquipe < nbEquipeDeLaPoule - 1) {
            poulesString += equipes[indexEquipe].textContent + '-';
            indexEquipe++;  
        }
        poulesString += equipes[indexEquipe].textContent + ',';

        index++;
    }
    poulesString = poulesString.substr(0, poulesString.length-1);   //enlève la dernière virgule

    console.log(poulesString);
    //creer le formulaire avec le numtournois et les poules modifiées
    if (bienModifie) {
        $("#verifie").remove();

        let message = "<h3>Tous les changements effectués sont valides</h3>"
        $("#message").append(message);

        let poulesModifiees = '<input type="hidden" name="poules" value=' + poulesString + '>';
        let bouton = '<input class="button" type="submit" value="confirmer les changements">';
        $("#formulaire").append(poulesModifiees);
        $("#formulaire").append(bouton);
    }
    else {
        alert("Erreur, le nombre d'équipe par poule n'est pas correct !");
    }
}