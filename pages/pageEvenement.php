<?php 
session_start();

$numEvenement = NULL;
if (isset($_POST['numevenement'])) {
    $numEvenement = $_POST['numevenement'];
    $_SESSION['numevenement'] = $_POST['numevenement'];
}
else if (isset($_SESSION['numevenement'])) {
    $numEvenement = $_SESSION['numevenement'];
}

function estTermine($numTournois) {
    try{
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $tournois = $dbh->query('SELECT numtournois, classement FROM tournois');
            
        if ($tournois) {
            foreach ($tournois as $row) {
                if ($row['numtournois'] == $numTournois) {
                  return $row['classement'] !== NULL;
                }
            }
        }
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }

    return false;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Evenement</title>
        <link rel="stylesheet" href="css/barreTitre.css" />
    </head>
    <body>
    <div class="barreTitre">
        <a class="retour" href="pageAccueil.php" style="text-decoration: none;">retour</a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection" href="pageAuthentification.php">Déconnection</a>
      </div>
    </div>
    
    <?php 
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
                        $estTermine = estTermine($row["numtournois"]);
                        if (!$estTermine) {
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