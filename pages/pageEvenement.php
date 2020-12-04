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
    $numEvenement = NULL;
    if (isset($_POST['numevenement'])) {
        $numEvenement = $_POST['numevenement'];
    }
    else if (isset($_SESSION['numevenement'])) {
        $numEvenement = $_SESSION['numevenement'];
    }
    $estTermine = isset($_POST['estTermine']) ? $_POST['estTermine'] : "non";
    if ($numEvenement !== NULL) {
        try{
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $evenement = $dbh->query('SELECT * FROM evenement');
            $nomEvenement = NULL; // la table de levenement selectionné
            if($evenement)
            {
                foreach($evenement as $row)
                {
                    if($row['numevenement'] == $numEvenement)
                    {
                        $nomEvenement = $row['nom'];
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
        <h1>Evenement : <?php echo '"' . $nomEvenement . '"';  ?></h1>
        <h2>Les Tournois : </h2>
        <?php 
        try{
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $tournois = $dbh->query('SELECT * FROM tournois');
            if($tournois)
            {
                foreach ($tournois as $row)
                {
                    if($row['numevenement'] == $numEvenement)
                    {
                        if ($estTermine == "non") {
                            echo '<form method="post" action="pageConfigTournois.php">';
                            echo '<input type="hidden" name="numtournois" value="' . $row["numtournois"] . '" />';
                            echo '<input type="submit" value="Tournois ' . $row['nom'] . '" />'; 
                            echo '</form>';
                        }
                        else {
                            echo $row['nom'];
                        }

                        echo '<form method="post" action="pageClassement.php">';
                        echo '<input type="hidden" name="numtournois" value="' . $row["numtournois"] . '" />';
                        echo '<input type="submit" value="classement '. $row['nom'] . '" /><br>'; 
                        echo '</form>';
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
    }
    else
    {
        echo 'Erreur pas d\'événement trouvé ou l\'envoi d\'une donnée a échouée!';
    }
    ?>
    </body>
</html>