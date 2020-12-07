<?php
session_start();

$numTournois = NULL;
$numTour = NULL;
if (isset($_POST['numtournois'], $_POST['numtour'])) {
    $numTournois = $_POST['numtournois'];
    $numTour = $_POST['numtour'];
    $_SESSION['numtournois'] = $numTournois;
    $_SESSION['numtour'] = $numTour;
}
else if (isset($_SESSION['numtournois'], $_SESSION['numtour'])) {
    $numTournois = $_SESSION['numtournois'];
    $numTour = $_SESSION['numtour'];
}

//fonction utile aux test
function afficheArray($liste)
{
    echo '( ';
    for($i=0; $i<count($liste); $i++)
    {
        if(gettype($liste[$i]) == "array")
        {
            afficheArray($liste[$i]);
        }
        else
        {
            echo $liste[$i] . ', ';
        }
    }
    echo ' ) ';
}

function nbJoueurParEquipe($numTournois) {
    try {
      $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
      $tournois = $dbh->query('SELECT numtournois, typejeu FROM tournois');
      if ($tournois) {
        $nbJoueurEquipe = 0;
        foreach ($tournois as $row) {
          if ($row['numtournois'] == $numTournois) {
            $nbJoueurEquipe = $row['typejeu'];
          }
        }
        return $nbJoueurEquipe;
      }
      else {
        echo "Erreur lors de la recuperation du type de jeu!";
        return -1;
      }
    } catch (PDOException $e) {
      print "Erreur ! : " . $e->getMessage() . "<br>";
      die();
    }
  }


function getNiveauEquipe($listeEquipe)
{
    $tableauEquipesNiveaux=array();
    try{
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $joueurs = $dbh->query('SELECT * FROM joueur J, equipe E WHERE j.nomequipe = E.nom');
        if($joueurs)
        {
            foreach($joueurs as $row)
            {
                if($row['numtournois'] == $_POST['numtournois'])
                {
                    if(array_key_exists($row['nomequipe'],$tableauEquipesNiveaux))
                    {
                        $tableauEquipesNiveaux[$row['nomequipe']] += $row['niveau'];
                    }
                    else{
                        array_push($tableauEquipesNiveaux, $row['nomequipe']);
                        $tableauEquipesNiveaux[$row['nomequipe']] = $row['niveau'];
                    }
                    
                }
            }
            $nbJoueurs = nbJoueurParEquipe($_POST['numtournois']);
            foreach($tableauEquipesNiveaux as $cle => $valeur)
            {
                if (!is_int($cle)) {
                    $tableauEquipesNiveaux[$cle] = ($valeur/$nbJoueurs); 
                }
                else
                {
                    unset($tableauEquipesNiveaux[$cle]);
                }
            }


            return $tableauEquipesNiveaux;
        }
        else 
        {
            echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
            return array();
        }
        } catch (PDOException $e)
        {
            print "Erreur ! : " . $e->getMessage() . "<br>";
        }
        
}

//INUTILE JE PENSE
//renvoie le niveaux le plus élevé de la liste passé en parametre
// function PGNiveaux($tableauEquipesNiveaux)
// {
//     $pgn = 0;
//     foreach($tableauEquipesNiveaux as $cle => $valeur)
//     {
//         if(!is_int($cle) && $valeur > $pgn)
//         {
//             $pgn=$valeur;
//         }
//     }
//     return $pgn;
// }


//CHANGER POUR REVOYER UN STRING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//cree une liste de liste remplit de façon aléatoire ex:((eq1,eq3)(eq4,eq5)(eq6,eq7)) eq1-eq2,eq3-eq4,eq5-eq6
function creePouleRandom($tableauEquipesNiveaux)
{
    //print_r($tableauEquipesNiveaux);
    $nbPoules = 0;
    //$nbJoueurParPoule = 0;
    //$estImpair = false;
    $pouleRandom = array();
    $formule = $_SESSION['formule'.$_POST['numtournois']];
    if(strpos($formule,'+'))
    {
        //exemple : "3x2+1x3"
        $parties = explode('+',$formule);
        $partieG = explode('x',$parties[0]);
        $partieD = explode('x',$parties[1]);
        $nbPoules = $partieD[0]+$partieG[0];
        //$nbJoueurParPoule = $partieG[1];
        
        //$estImpair = true;
    }
    else
    {
        //exemple : "3x2"
        $partie = explode('x',$formule);
        $nbPoules = $partie[0];
        //$nbJoueurParPoule = $partie[1];
    }

    for($k=0; $k<$nbPoules; $k++)
    {
        array_push($pouleRandom,array());
    }

    $copieTableau = $tableauEquipesNiveaux;
    // print_r($copieTableau);
    arsort($copieTableau);
    $i=0;
    $j=1;
    foreach($copieTableau as $cle => $valeur)//a modifier
    {
        array_push($pouleRandom[$i>=($nbPoules*$j) ? ($i-($nbPoules*$j)) : $i] ,$cle);
        if($i>=($nbPoules*$j))
        {
            $j++;
        }
        $i++;
        
    }
    
    return $pouleRandom;
}

function affichePoules($poules) {
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
        echo '<div class="poules">';
        $indexToNbEquipe = 0;
        while ($equipes[$indexToNbEquipe]) { //pour chaque équipe de la poule
            echo '<div style="border : 1px solid black;" id="equipe' . ($indexToNbEquipe+1) . 'Poule' . ($indexToNbPoules+1) . '">'; //ex : equipe1Poule1
            echo $equipes[$indexToNbEquipe];
            echo '</div>';
            $indexToNbEquipe++;
        }
        echo '</div>';
        $indexToNbPoules++;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Tour</title>
        <link rel="stylesheet" href="stylePoules.css" />
    </head>
    <body>
        <?php 
        if($numTournois !== NULL && $numTour !== NULL)
        {
            //try pour avoir le nom du tournois actuel
            try{
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $tournois = $dbh->query('SELECT * FROM tournois');
            $nomTournois = NULL; // la table de tournois selectionné
            if($tournois)
            {
                foreach($tournois as $row)
                {
                    if($row['numtournois'] == $numTournois)
                    {
                        $nomTournois = $row['nom'];
                    }
                }
            }
            else 
            {
                echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
            }
            } catch (PDOException $e)
            {
                print "Erreur ! : " . $e->getMessage() . "<br>";
            }
            ?>
            <h1>Tournois : <?php echo $nomTournois;  ?> <br> Tour n°: <?php echo  $numTour;?></h1>
            
            <?php
            //get poules
            $poules = "eq1-eq4,eq2-eq3,eq5-eq6"; //ici changer par la mise sous forme de string de la fonction pouleRandom
            if (isset($_POST['poules'])) {
                $poules = $_POST['poules'];
                $_SESSION['poules'] = $_POST['poules'];
            } 
            else if (isset($_SESSION['poules'])) {
                $poules = $_SESSION['poules'];
            } 
            ?>
            <!-- affichage des poules -->
            <div id="ContentantDesPoules">
            <?php
            affichePoules($poules);
            ?>
            </div>
            <br><br>
                <!-- bouton qui mène a la page modifPoule -->
            <form method="post" action="pageModifierPoules.php">
                <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
                <input type="hidden" name="poules" value=<?php echo $poules;?>>
                <input type="submit" name="modifPoules" value="modifier les Poules">
            </form>
                <!-- bouton qui mène a la page Poules -->
            <form method ="post" action="pagePoule.php">
            <input type="submit" name="CommencerPoules" value="Commencer les Poules">
            </form>
            <?php 

                //met les équipe dans une array
                $listeEquipe=explode(',',$_SESSION["classementTour"]);
                //afficheArray($listeEquipe);
                //avoir la liste des niveaux moyens de chaque équipe
                $listeNiveauxDesEquipes=getNiveauEquipe($listeEquipe);
                //print_r($listeNiveauxDesEquipes);
            
            afficheArray(creePouleRandom($listeNiveauxDesEquipes)); 
        }
        else
        {
            echo 'Erreur pas de Tournois trouvé';
        }
        ?>
    </body>
</html>