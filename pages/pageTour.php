<?php
session_start();

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





?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Tour</title>
    </head>
    <body>
        <?php 
        if(isset($_POST['numtournois']) && isset($_POST['numtour']))
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
                    if($row['numtournois'] == $_POST['numtournois'])
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
        <h1>Tournois : <?php echo $nomTournois;  ?> <br> Tour n°: <?php echo  $_POST["numtour"];?></h1>

            <!-- bouton qui mène a la page modifPoule -->
        <form method ="post" action="pageModifierPoules.php">
            <input type="hidden" name="numtournois" value=<?php echo $_POST['numtournois']; ?>>
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