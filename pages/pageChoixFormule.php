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

function creeFormules($nbEquipe)
{
    echo '<option value=" 1x' .$nbEquipe . '"> 1x'.$nbEquipe . ' </option>';
    $nbEquipePoule = ($nbEquipe%2==0) ? $nbEquipe/2 : floor($nbEquipe/2);

    while($nbEquipePoule != 1)
    {
        $nbPoules = $nbEquipe/$nbEquipePoule;
        if(is_int($nbPoules))
        {
            echo '<option value="' . $nbPoules."x".$nbEquipePoule . '"> ' . $nbPoules."x".$nbEquipePoule . ' </option>';
        }
        else
        {
            $nbEqDejaUtilise = (floor($nbPoules)-1)*$nbEquipePoule;
            $IndexNbEqPoule = $nbEquipe - $nbEqDejaUtilise;
            if(($nbEquipePoule == $IndexNbEqPoule-1) || ($nbEquipePoule == $IndexNbEqPoule+1))
            {
                echo '<option value="' . (floor($nbPoules)-1)."x".$nbEquipePoule."+1x".$IndexNbEqPoule . '"> ' . (floor($nbPoules)-1)."x".$nbEquipePoule."+1x".$IndexNbEqPoule. ' </option>';
            }
        }
        $nbEquipePoule--;
    }
}


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page choix formule</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
  </head>
  <body>
    <div class="barreTitre">
      <a class="retour"></a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection"></a>
      </div>
    </div>
    <h1>Choisissez une formules pour les poules :</h1>
    <?php 
    if ($numTournois !== NULL) {
        $nbEquipe = getNbEquipe($_SESSION["listeEquipes" . $numTournois]);
        echo 'Le tournois est composé de ' . $nbEquipe . ' équipes.<br>';
        echo '<form method="post" action="pageTournois.php">';
        echo '<input type="hidden" name="numtournois" value="' . $numTournois . '">';
        echo '<label for="choix">Choisissez une formule (nombre de poule x nombre d\'équipe) :</label> ';
        echo '<select name="choix">';
        creeFormules($nbEquipe);
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