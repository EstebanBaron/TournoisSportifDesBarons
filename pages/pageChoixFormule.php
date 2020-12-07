<?php
session_start();

$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
}

function getNbEquipe($numTournois) {
    //récupère le nb équipe pour proposer des formules
    $nbEquipe = -1;
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
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }

    return $nbEquipe;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page choix formule</title>
  </head>
  <body>
    <h1>Choisissez une formules pour les poules :</h1>
    <form method="post">
        <input type="hidden" value=<?php echo $_POST["numtournois"]; ?>>
        <select name="choix">
    <?php
    echo $_POST['numtournois'];
    if ($numTournois !== NULL) {
        $nbEquipe = getNbEquipe($numTournois);

        if ($nbEquipe != -1) {
            //propose différentes formules
            if ($nbEquipe % 2 == 0) { //CAS PAIR
                //1 - formule par défault
                echo '<option value="' . ($nbEquipe/2) .'x2"> ' . ($nbEquipe/2) . 'x2 </option>';
            }
            else{   //CAS IMPAIR
                //1 - formule par défault
                echo '<option value="' . ($nbEquipe/2 - 1) . 'x2+1x3"> ' . ($nbEquipe/2 - 1) . 'x2+1x3 </option>';
            } 
        }
    }
    else {
        echo "Erreur, les données de la page n'ont pas pu être récupérées !<br>";
    }
    ?>
        </select>
        <br>
        <input type="submit" value="Valider">
    </form>
  </body>
</html>