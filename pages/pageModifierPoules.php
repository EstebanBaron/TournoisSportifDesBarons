<?php
session_start();

$poules = NULL;
$numTournois = NULL;
if (isset($_POST['poules'], $_POST['numtournois'])) {
    $poules = $_POST['poules'];
    $numTournois = $_POST['numtournois'];
    $_SESSION['poules'] = $poules;
    $_SESSION['numtournois'] = $numTournois;
}
else if (isset($_SESSION['poules'], $_SESSION['numtournois'])) {
    $poules = $_SESSION['poules'];
    $numTournois = $_SESSION['numtournois'];
}

function nbEquipeParPoule($formule) {
    if(strpos($formule,'+'))
    {
        //exemple : "3x2+1x3"
        $parties = explode('+',$formule);
        $partieG = explode('x',$parties[0]);
        return  $partieG[1];
    }
    else
    {
        //exemple : "3x2"
        $partie = explode('x',$formule);
        return $partie[1];
    }
}

function formuleImpaire($formule) {
    if(strpos($formule,'+'))
        return true;
    else
        return false;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page modification poules</title>
        <link rel="stylesheet" href="css/barreTitre.css" />
        <link rel="stylesheet" href="css/stylePoules.css" />
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <div class="barreTitre">
            <a class="titre">La Baronnerie</a>
        </div>
        <?php
        if ($poules !== NULL && $numTournois !== NULL) {
        ?>
        <h1>Poules actuelles : </h1>
        <p>(Vous pouvez changer les équipes de place avec la technique du Drag&Drop)</p>
        <div id="ContentantDesPoules">
            <?php
            $separationPoules = explode(',', $poules);
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
                //il faut changer le code de la fonction dans le fichier js pour mettre ça
                // echo '<h3>Poule ' . ($indexToNbPoules+1) . '</h3>'; 
                $indexToNbEquipe = 0;
                while ($equipes[$indexToNbEquipe]) { //pour chaque équipe de la poule
                    echo '<div style="border : 1px solid black;" id="equipe' . ($indexToNbEquipe+1) . 'Poule' . ($indexToNbPoules+1) . '" draggable="true" ondragstart="onDragStart(event);">'; //ex : equipe1Poule1
                    echo $equipes[$indexToNbEquipe];
                    echo '</div>';
                    $indexToNbEquipe++;
                }
                echo '</div>';
                $indexToNbPoules++;
            }
            if (isset($_SESSION['formule'.$numTournois])) {
                $nbEquipeParPoule = nbEquipeParPoule($_SESSION['formule'.$numTournois]);
                $formuleImpaire = formuleImpaire($_SESSION['formule'.$numTournois]);
            }
            else {
                $nbEquipeParPoule = 0;
                $formuleImpaire = false;
                echo "Erreur, la formule n'a pas pu être chargé!<br>";
            }
            ?>
        </div>

        <br><br>
        <div id="message">
        </div>

        <form method="post" action="pageTour.php" id="formulaire">
            <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
        </form>
        <button id="verifie" type="button" name="verifier" onclick="verifieChangement(<?php echo $nbEquipeParPoule . ', ' . $formuleImpaire; ?>);">Vérifier mes changement</button>
        <?php
        }
        else {
            echo "Erreur, la page n'a pas pu être chargé!<br>";
        }
        ?>
        <script src="js/dragAndDrop.js"></script>
    </body>
</html>