<?php
session_start();

function getNiveauEquipe($listeEquipe)
{
    $listeNiveaux=array();
    try{
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $joueurs = $dbh->query('SELECT * FROM joueur J, equipe E WHERE j.nomEquipe = E.nom');
        if($joueurs)
        {
            for($i=0; $i<count($listeEquipe); $i++)
            {
                
                $sommeNiveaux = 0;
                $nbJoueurs = 0;
                foreach($joueurs as $row)
                {
                    //echo (($row['nomequipe'] == $listeEquipe[$i] && $row['numtournois'] == $_POST['numtournois'])? "oui" : "non" )." ";
                    if($row['nomequipe'] == $listeEquipe[$i] && $row['numtournois'] == $_POST['numtournois'])
                    {
                        
                        $sommeNiveaux += $row['niveau'];
                        //echo $row['niveau'] .' ';
                        $nbJoueurs++;
                        //echo $nbJoueurs . '<br>';
                    }
                }
                array_push($listeNiveaux,$sommeNiveaux/$nbJoueurs);
                echo $row;
                unset($row);
                echo $row;
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
        return $listeNiveaux;
}

//renvoie le niveaux le plus élevé de la liste passé en parametre
function PGNiveaux($listeNiveaux)
{
    $pgn = 1;
    for($i = 0 ; $i< count($listeNiveaux); $i++)
    {
        if($listeNiveaux[$i] > $pgn)
        {
            $pgn=$listeNiveaux[$i];
        }
    }
    return $pgn;
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
//CHANGER POUR REVOYER UN STRING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//cree une liste de liste remplit de façon aléatoire ex:((eq1,eq3)(eq4,eq5)(eq6,eq7))
function creePouleRandom($listeEquipe, $listeNiveaux, $nbPoules)
{
    $pouleRandom = array();
    for($k=0; $k<$nbPoules; $k++)
    {
        array_push($pouleRandom,array());
    }

    $pgn = PGNiveaux($listeNiveaux);
    
    $listeN = $listeNiveaux;
    $i=0;
    while($i < count($listeEquipe))
    {
        for($j=0; $j<count($listeEquipe); $j++)
        {
            if($listeN[$j] == $pgn)
            {
                array_push($pouleRandom[$i>=$nbPoules ? ($i-$nbPoules) : $i],$listeEquipe[$j]);
                $listeN[$j] = null;
                $i++;
            }
            else if($j+1==count($listeEquipe) && $pgn != 1)
            {
                $pgn--;
            }
        }
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
        if(isset($_POST['numtournois']) && isset($_POST['numtour']) && isset($_POST['listeEquipe']))
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
        <form method ="post" action="pageModifPoules.php">
        <input type="submit" name="modifPoules" value="modifier les Poules">
        </form>
            <!-- bouton qui mène a la page Poules -->
        <form method ="post" action="pagePoule.php">
        <input type="submit" name="CommencerPoules" value="Commencer les Poules">
        </form>
        <?php 
            $listeEquipe=explode(',',$_POST["listeEquipe"]);
            afficheArray($listeEquipe);
            $listeNiveauxDesEquipes=getNiveauEquipe($listeEquipe);
            afficheArray($listeNiveauxDesEquipes);
        //    afficheArray(creePouleRandom(array("eq1","eq2","eq3","eq4","eq5","eq6"),array(1,2,1,3,2,1),3)); test de la fonction 
        }
        else
        {
            echo 'Erreur pas de Tournois trouvé';
        }
        ?>
    </body>
</html>