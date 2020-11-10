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
        <label for="id"> Nom utilisateur :</label>
        <input type="text" name="id" maxlength="20" required><br>
        <!-- mdp -->
        <label for="mdp"> Mot de passe :</label>
        <input type="password" name="mdp" maxlength="20" required><br>
        <!-- bouton -->
        <input type="submit" value="s'identifier" name="authentification">
    </form>
    <?php
    if (isset($_POST['id']) && isset($_POST['mdp']) && isset($_POST['authentification'])) {
        try {
            $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
            $organisateur = $dbh->query('SELECT * from organisateur');

            $id = $_POST['id'];
            $mdp = $_POST['mdp'];
            $authentifie = false;
            foreach($organisateur as $row) {
                if($id === $row['identifiant'] && md5($mdp) ===  $row['motdepasse']) {
                    $authentifie = true;
                    $_SESSION['login'] = $id;
                    echo "<h3>Authentifaction réussi. Bienvenue " . $_SESSION['login'] . " !</h3>";
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
            if(!$authentifie) 
                echo "Erreur d'identifiant ou de mot de passe ! ";
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