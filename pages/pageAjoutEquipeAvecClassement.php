<?php
session_start();

$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
    $_SESSION['numtournois'] = $numTournois;
}
else if ($_SESSION['numtournois']) {
    $numTournois = $_SESSION['numtournois'];
}

function getTournoisFini($numTournois) {
    $tabTournoisFini = array(); //ex : tab = {'nomTournois' => classement, ...}
    try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        foreach ($dbh->query('SELECT * FROM tournois') as $row) {
            if (isset( $_SESSION['numevenement']) && $row['numevenement'] == $_SESSION['numevenement'] && $row['classement'] !== NULL) {
                $tabTournoisFini[$row['nom']] = $row['classement'];
            }
        }
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
        die();
    }

    return $tabTournoisFini;
}

function envoiDesEquipesDansLaBase($equipesString, $numTournois) {
    try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $sql = "INSERT INTO equipe (nom, club, numtournois) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($sql);

        $nomsEquipes = explode(", ", $equipesString);

        $bienPasse = true;
        $index = 0;
        while ($index < count($nomsEquipes) && $bienPasse) {
            if (strlen($nomsEquipes[$index] . "numTournois" . $numTournois) <= 30)
                $nomEquipe = $nomsEquipes[$index] . "numTournois" . $numTournois;
            else if(strlen($nomsEquipes[$index] . "tournois" . $numTournois) <= 30)
                $nomEquipe = $nomsEquipes[$index] . "tournois" . $numTournois;
            else 
                $nomEquipe = "equipe" . $index . "numTournois" . $numTournois;
            //verification des contraintes
            if(strlen($nomEquipe) <= 30) {
                if (!$stmt->execute([$nomEquipe, NULL, $numTournois])) { //ici on aurait pu aller chercher les clubs dans la base mais ce n'est pas nécessaire
                    $bienPasse = false;
                }
            }
            else {
                echo "Le nom d'équipe est trop grand ! vous ne pourrez pas utiliser ce tournois pour remplir vos équipes ! <br>";
            }
            $index++;
        }
        if ($bienPasse) {
            echo "Les données ont bien étaient envoyées à la base !<br>";
            ?>
            <br>
            <h4>Redirection en cours...</h4>
            <script type="text/javascript">
                setTimeout(function() {window.location.href = "pageConfigTournois.php";}, 3000);
            </script>
            <?php
        }
        else {
            echo "Erreur lors de l'envoi d'une requête !<br>";
        }
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
        die();
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page ajout équipe avec classement</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <div class="barreTitre">
        <a href="pageConfigTournois.php" style="text-decoration: none;">retour</a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection"></a>
      </div>
    </div>
    <?php 
    if ($numTournois !== NULL) {
        $tabTournoisFini = getTournoisFini($numTournois);
        if (!empty($tabTournoisFini)) {
            echo '<h1>Remplissez les équipes de votre tournois avec le classement d\'un tournois passé :</h1>';
            echo '<p>Cliquez sur un tournois pour afficher son classement :<p>';
            foreach ($tabTournoisFini as $nomTournois => $classement) {
                echo '<button type="button" onclick="afficheClassement(\'' . $classement . '\');">' . $nomTournois . '</button>';
            }
            ?>
            <div id="divClassement"></div>

            <div id="divEquipesSelectionnees"></div>

            <br><br>
            
            <form id="ajoutEquipes" method="post">
            </form>
            <?php
            if (isset($_POST['boutonEnvoi'], $_POST['equipesSelectionnees'])) {
                envoiDesEquipesDansLaBase($_POST['equipesSelectionnees'], $numTournois);
            }
        }
        else {
            echo "<h3>Aucun tournois n'est fini pour le moment !</h3><br>";
        }
    }
    ?>
    <script src="js/scriptPageAjoutEquipeAvecClassement.js"></script>
  </body>
</html>