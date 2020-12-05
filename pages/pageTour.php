<?php
session_start();

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

function creePouleRandom($listeEquipe, $listeNiveaux, $nbPoules)
{
    $pouleRandom = array(array());// faire une fonction qui créé un tableau de tableau bisous
    $pgn = PGNiveaux($listeNiveaux);
    $listeN = $listeNiveaux;
    for($i=0; $i<count($listeEquipe); $i++)
    {
        for($j=0; $j<count($listeEquipe); $j++)
        {
            if($listeN[$i] = $pgn)
            {
                array_push($pouleRandom[$i>$nbPoules ? ($i-$nbPoules) : $i],$listeEquipe[$i]);
                $listeN[$i] = null;
            }
            else if($j++==count($listeEquipe))
            {
                $pgn--;
            }
        }
        $pgn--;//pas sur
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
        if(isset($_POST['numt']) && isset($_POST['numtour']))
        {
            try{
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $tournois = $dbh->query('SELECT * FROM tournois');
            $nomTournois = NULL; // la table de tournois selectionné
            if($tournois)
            {
                foreach($tournois as $row)
                {
                    if($row['numtournois'] == $_POST['numt'])
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


        <form method ="post" action="pageModifPoules.php">
        <input type="submit" name="modifPoules" value="modifier les Poules">
        </form>

        <form method ="post" action="pagePoule.php">
        <input type="submit" name="CommencerPoules" value="Commencer les Poules">
        </form>
        <?php 
            print_r(creePouleRandom(array("eq1","eq2","eq3","eq4","eq5","eq6"),array(1,2,1,3,2,1),3));
        }
        else
        {
            echo 'Erreur pas de Tournois trouvé';
        }
        ?>
    </body>
</html>