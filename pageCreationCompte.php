<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de creation compte</title>
  </head>
  <body>
    <form method="post">

    <label for="identifiant"> Identifiant :</label>
    <input type="text" name="identifiant" maxlength="20"><br>
    
    <label for="motdepasse"> Mot de passe :</label>
    <input type="password" name="motdepasse" maxlength="20"><br>
    
    <label for="confirmationMDP"> Confirmer votre mot de passe :</label>
    <input type="password" name="confirmationMDP" maxlength="20"><br>
    
    <label for="nom"> Nom : </label>
    <input type="text" name="nom" maxlength="20"><br>

    <label for="prenom"> Prenom :</label>
    <input type="text" name="prenom" maxlength="20"><br>

    <input type="submit" value="s'enregistrer" name="enregistrement">
    </form>
    <?php
    if (isset($_POST['identifiant']) && isset($_POST['motdepasse']) && isset($_POST['confirmationMDP']) && isset($_POST['enregistrement'])) {
        $identifiant = $_POST['identifiant'];
        $mdp = $_POST['motdepasse'];
        $confirmMDP = $_POST['confirmationMDP'];
        $nom = NULL;
        $prenom = NULL;
        if (isset($_POST['nom']))
            $nom = $_POST['nom'];
        if (isset($_POST['prenom']))
            $prenom = $_POST['prenom'];
        if ($mdp !== $confirmMDP) {
            echo "Erreur, les mots de passes sont incohérents !";
        }
        else {
            try {
                $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
                $organisateur = $dbh->query('SELECT * from organisateur');
                $dejaUtilise = false;
                $lastNumOrga = 0;
                foreach($organisateur as $row) {
                    foreach($row as $cle=>$value) {
                        $lastNumOrga = $row['numorganisateur'];
                        if($identifiant === $row['identifiant']) {
                            echo "Erreur, nom d'utilisateur déjà utilisé !";
                            $dejaUtilise = true;
                        }
                    }
                }
                if(!$dejaUtilise) {
                    $sql = "INSERT INTO organisateur (numorganisateur, identifiant, motdepasse, nom, prenom) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    //ajout utilisateur
                    if($stmt->execute([$lastNumOrga+1, $identifiant, md5($mdp), $nom, $prenom])) {
                        $_SESSION['login'] = $identifiant;
                        echo "Enregistrement réussi. Bienvenue " . $_SESSION['login'] . " !";
                        ?>
                        <br>
                        <h4>Redirection en cours...</h4>
                        <script type="text/javascript">
                            //permet d'attentre 3000ms (3s) avant d'aller sur pageAccueil.php
                            setTimeout(function() {window.location.href = "pageAccueil.php";}, 3000);
                        </script>
                        <?php
                    }
                    else {
                        echo "Erreur d'execution de la requête préparé !";
                    }
                }
                $dbh = null;
            } catch (PDOException $e) {
                print "Erreur ! : " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    ?>
  </body>
</html>