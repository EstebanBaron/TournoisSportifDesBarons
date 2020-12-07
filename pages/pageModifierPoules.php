<?php
session_start();

$poules = NULL;
$numTournois = NULL;
if (isset($_POST['poules']) && isset($_POST['numtournois'])) {
    $poules = $_SESSION['poules'];
    $numTournois = $_SESSION['numtournois'];
    $_SESSION['poules'] = $poules;
    $_SESSION['numtournois'] = $numTournois;
}
else {
    $poules = $_SESSION['poules'];
    $numTournois = $_SESSION['numtournois'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Tour</title>
        <link rel="stylesheet" href="stylePageModifierPoules.css" />
    </head>
    <body>
        <?php
        if ($poules !== NULL && $numTournois !== NULL) {
        ?>
        <h1>Poules actuelles : </h1>
        <div id="ContentantDesPoules">
            <?php
            $separationPoules = explode(',', $_POST['poules']);
            //récupère le nombre de poules
            $nbPoules = 0;
            $index = 0;
            while ($separationPoules[$index] !== NULL) {
                $nbPoules++;
                $index++;
            }
            
            //pour chaque poule on affich/créer les objets draggable etc...
            $indexToNbPoules = 0;
            while ($indexToNbPoules < $nbPoules) {  //pour toutes les poules séparé par des virgules
                $equipes = explode('-', $separationPoules[$indexToNbPoules]);
                echo '<div class="poules" ondragover="onDragOver(event);" ondrop="onDrop(event);">';
                $indexToNbEquipe = 0;
                while ($equipes[$indexToNbEquipe]) { //pour chaque équipe de la poule
                    echo '<div ondragover="return false" style="border : 1px solid black;" id="equipe' . ($indexToNbEquipe+1) . 'Poule' . ($indexToNbPoules+1) . '" draggable="true" ondragstart="onDragStart(event);">'; //ex : equipe1Poule1
                    echo $equipes[$indexToNbEquipe];
                    echo '</div>';
                    $indexToNbEquipe++;
                }
                echo '</div>';
                $indexToNbPoules++;
            }
            ?>
        </div>
        <!-- <button type="button" value="confirmer"></button> -->
        <?php
        }
        else {
            echo "Erreur, la page n'a pas pu être chargé!<br>";
        }
        ?>
        <script src="dragAndDrop.js"></script>
    </body>
</html>