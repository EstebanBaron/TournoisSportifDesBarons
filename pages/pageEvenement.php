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
        <link rel="stylesheet" href="css/styleEvenement.css" />
    </head>
    <body>
    <div class="barreTitre">
        <a class="retour" href="pageAccueil.php" style="text-decoration: none;">Retour</a>

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
        <div id="divNomEvenement">
            <p id="evenement">Evenement : <?php echo '<p id="nomEvent">' . $nomEvenement . '</p>';  ?></p>
        </div>

        <div id="tournois">
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
                        echo '<div class="formulaires">';
                        if (!$estTermine) {
                            echo '<form class="form" method="post" action="pageConfigTournois.php">';
                            echo '<input type="hidden" name="numtournois" value="' . $row["numtournois"] . '" />';
                            echo '<input class="button" type="submit" value="Tournois ' . $row['nom'] . '" />'; 
                            echo '</form>';
                        }
                        else {
                            echo '<p class="form">' . $row['nom'] . '</p>';
                        }

                        echo '<form class="form" method="post" action="pageClassement.php">';
                        echo '<input type="hidden" name="numtournois" value="' . $row["numtournois"] . '" />';
                        echo '<input class="button" type="submit" value="classement '. $row['nom'] . '" /><br>'; 
                        echo '</form>';
                        echo '</div>';
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
    </div>
    </body>
</html>