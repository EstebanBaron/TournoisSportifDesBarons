<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page d'authentification</title>
  </head>
  <body>
    <h1>Connexion : </h1>
    <form method="post">
        <!-- identifiant -->
        <label for="id"> Identifiant :</label>
        <input type="text" name="id" maxlength="20" required><br>
        <!-- mdp -->
        <label for="mdp"> Mot de passe :</label>
        <input type="password" name="mdp" maxlength="20" required><br>
        <!-- bouton authentification -->
        <input type="submit" value="s'identifier" name="authentification">
    </form>
    <?php
    if (isset($_POST['id']) && isset($_POST['mdp']) && isset($_POST['authentification'])) {
        try {
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            $organisateur = $dbh->query('SELECT * from organisateur');
            //on vérifie si les champs renseignés sont bien dans la base
            if ($organisateur) {
                $id = htmlspecialchars($_POST['id']);
                $mdp = htmlspecialchars($_POST['mdp']);
                $authentifie = false;
                foreach($organisateur as $row) {
                    if($id === $row['identifiant'] && md5($mdp) ===  $row['motdepasse']) {
                        //l'organisateur s'est bien authentifié
                        $authentifie = true;
                        $_SESSION['identifiant'] = $id;
                        echo "<h3>Authentifaction réussi. Bienvenue " . htmlspecialchars($_SESSION['identifiant']) . " !</h3>";
                        ?>
                        <br>
                        <h4>Redirection en cours...</h4>
                        <script type="text/javascript">
                            //permet d'attentre 3000ms (3s) avant d'aller sur pageAccueil.php
                            setTimeout(function() {window.location.href = "pageAccueil.php";}, 3000);
                        </script>
                        <?php
                    }
                }
                if(!$authentifie) {
                    echo "Erreur d'identifiant ou de mot de passe ! ";
                }
            }
            else {
                echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
            }
            $dbh = null;
        } catch (PDOException $e) {
            print "Erreur ! : " . $e->getMessage() . "<br>";
            die();
        }
    }
    ?>

    <!-- permet d'aller à pageCreationCompte.php -->
    <form action="pageCreationCompte.php">
        <input class="boutonAuthentification" type="submit" value="créer un compte">
    </form>
  </body>
</html>