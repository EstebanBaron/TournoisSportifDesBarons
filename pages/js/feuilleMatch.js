function plusUnJ1() {
    //on récupere la ligne du score du joueur 1
    let ligneJ1 = document.getElementById("scoreJ1");
    //on récupère le score
    scoreJ1 = parseInt(ligneJ1.textContent);
    //on change le score en faisant +1
    ligneJ1.innerText = (scoreJ1+1).toString();
}

function plusUnJ2() {
    let ligneJ2 = document.getElementById("scoreJ2");
    scoreJ2 = parseInt(ligneJ2.textContent);
    ligneJ2.innerText = (scoreJ2+1).toString();
}

function moinsUnJ1() {
    //on récupere la ligne du score du joueur 1
    let ligneJ1 = document.getElementById("scoreJ1");
    //on récupère le score
    scoreJ1 = parseInt(ligneJ1.textContent);
    //on change le score en faisant +1
    if (scoreJ1 > 0) {
        ligneJ1.innerText = (scoreJ1-1).toString();
    }
}

function moinsUnJ2() {
    let ligneJ2 = document.getElementById("scoreJ2");
    scoreJ2 = parseInt(ligneJ2.textContent);
    if (scoreJ2 > 0) {
        ligneJ2.innerText = (scoreJ2-1).toString();
    }
}

function ajoutScore() {
    //on récupère les scores
    let ligneJ1 = document.getElementById("scoreJ1");
    scoreJ1 = parseInt(ligneJ1.textContent);
    let ligneJ2 = document.getElementById("scoreJ2");
    scoreJ2 = parseInt(ligneJ2.textContent);

    //on récupère le nom des équipes
    let ligneEquipe1 =  document.getElementById("equipe1");
    nomEquipe1 = ligneEquipe1.textContent;
    let ligneEquipe2 =  document.getElementById("equipe2");
    nomEquipe2 = ligneEquipe2.textContent;

    let ligneScore = '<input type="hidden" name="score" value="' + nomEquipe1 + '-' + nomEquipe2 + '_' + scoreJ1 + '-' + scoreJ2 + '">';

    $("#formulaire").append(ligneScore);
    $("#formulaire").submit();
}