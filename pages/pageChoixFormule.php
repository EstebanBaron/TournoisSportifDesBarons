<?php
session_start();

$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
}

function getNbEquipe($listeEquipes) {
    $nbEquipe = 0;
    
    $tabEquipe = explode(',', $listeEquipes);
    $index = 0;
    while ($index < count($tabEquipe)) {
      $nbEquipe++;
      $index++;
    }
  
    return $nbEquipe;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page choix formule</title>
  </head>
  <body>
    <h1>Choisissez une formules pour les poules :</h1>
    <?php 
    if ($numTournois !== NULL) {
        $nbEquipe = getNbEquipe($_SESSION["listeEquipes" . $numTournois]);
        echo 'Le tournois est composé de ' . $nbEquipe . ' équipes.<br>';
        echo '<form method="post" action="pageTournois.php">';
        echo '<input type="hidden" name="numtournois" value="' . $numTournois . '">';
        echo '<label for="choix">Choisissez une formule (nombre de poule x nombre d\'équipe) :</label> ';
        echo '<select name="choix">';
    
        if ($nbEquipe != -1) {
            //propose différentes formules
            //1 - formule par défault
            if ($nbEquipe % 2 == 0) { //CAS PAIR
                echo '<option value="' . ($nbEquipe/2) . 'x2"> ' . ($nbEquipe/2) . 'x2 </option>';
            }
            else{   //CAS IMPAIR
                $nbPoulesADeuxJoueur = floor($nbEquipe/2 - 1);
                if ($nbPoulesADeuxJoueur != 0)
                    echo '<option value="' . $nbPoulesADeuxJoueur . 'x2+1x3"> ' . $nbPoulesADeuxJoueur . 'x2+1x3 </option>';
            } 

            if ($nbEquipe % 3 == 0) {
                echo '<option value="' . ($nbEquipe/3) . 'x3"> ' . ($nbEquipe/3) . 'x3 </option>';
            }

            if ($nbEquipe % 4 == 0) {
                echo '<option value="' . ($nbEquipe/4) . 'x4"> ' . ($nbEquipe/4) . 'x4 </option>';
            }

            if ($nbEquipe % 5 == 0) {
                echo '<option value="' . ($nbEquipe/5) . 'x5"> ' . ($nbEquipe/5) . 'x5 </option>';
            }
        }
        echo '</select>';
        echo '<br>';
        echo '<br>';
        echo '<input type="submit" value="Valider">';
        echo '</form>';
    }
    else {
        echo "Erreur, les données de la page n'ont pas pu être récupérées !<br>";
    }
    ?>
  </body>
</html>