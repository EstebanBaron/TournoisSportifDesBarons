<?php 
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Page Evenement</title>
    </head>
    <body>
    <?php 
    if(isset($_POST['numevenement']))
    {
        try{
            $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
            $evenement = $dbh->query('SELECT * FROM evenement ');
            $infoEvenement; // la table de levenement selectionné
            if($evenement)
            {
                foreach($evenement as $row)
                {
                    if($row['numEvenement']=== $_POST['numevenment'])
                    {
                        $infoEvenement = $row;
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
    }
    else
    {
        echo 'erreur pas d\'evenement trouvé';
    }
    
    ?>
    <h1>Evenement <?php $infoEvenement['nom'] ?></h1>
    <h2>Les Tournois : </h2>
    <?php 
    try{
        $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
        $tournois = $dbh->query('SELECT * FROM tournois');
        if($tournois)
        {
            foreach ($tournois as $row)
            {
                if($row['numEvenenment'] === $infoEvenement['numEvenement'])
                {
                    echo 'Tournois 1 : ' . $row['nom'] . ' <br>'; 
                }
            }
        }
        else 
        {
            echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
        }

    }catch (PDOException $e)
    {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }
    ?>
    </body>


</html>