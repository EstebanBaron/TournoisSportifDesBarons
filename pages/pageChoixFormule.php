<?php
session_start();

$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page choix formule</title>
  </head>
  <body>
    <h1>Choisissez une formules pour les poules :</h1>
    <?php
    if ($numTournois !== NULL) {
        //récupère le nb équipe pour proposer des formules
        $nbEquipe = 0;
        try{
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $tournois = $dbh->query('SELECT t.numtournois, count(*) AS nbequipe FROM tournois t, equipe e WHERE e.numtournois = t.numtournois GROUP BY t.numtournois');
                
            if ($tournois) {
                foreach ($tournois as $row) {
                    if ($row['numtournois'] == $numTournois) {
                        $nbEquipe = $row['nbequipe'];
                    }
                }
            }
            else {
                echo "Erreur, les données de la base n'ont pas pu être récupérées !<br>"; 
            }
        } catch (PDOException $e) {
            print "Erreur ! : " . $e->getMessage() . "<br>";
        }

        //propose différentes formules
        echo $nbEquipe;
        //formule par défault
        if ($nbEquipe % 2 == 0) { //CAS PAIR
            echo ($nbEquipe/2) ."x2";
        }
        else{   //CAS IMPAIR
            echo ($nbEquipe/2 - 1) ."x2+1x3";
        } 
    }
    else {
        echo "Erreur, les données de la page n'ont pas pu être récupérées !<br>";
    }
    ?>
  </body>
</html>