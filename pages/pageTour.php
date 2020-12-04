<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Tour</title>
    </head>
    <body>
        <?php 
        echo $_POST['numtour'];
        if(isset($_POST['numt'])) //erreur inconnue
        {
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
        <h1>Tournois : <?php echo '"' . $nomTournois . '"';  ?> <br> Tour n°: <?php echo '"' . $_POST["numtour"] . '"';?></h1>

        <?php 
        
        }
        else
        {
            echo 'Erreur pas de Tournois trouvé';
        }
        ?>
    </body>
</html>