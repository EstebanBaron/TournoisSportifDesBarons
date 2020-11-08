<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page d'authentification</title>
  </head>
  <body>
    <form method="post">
    <h1>Veuillez vous identifier ou créer un compte</h1>
    <input class="boutonAuthentification" type="submit" value="connexion" name="connexion">
    <input class="boutonAuthentification" type="submit" value="créer un compte" name="creerCompte">
    </form>
    <?php
    if(isset($_POST['connexion']) || $page === "connexion") {
        echo '<script src="clear.js" type="text/javascript"></script>';
        echo '<form method="post">';
        //identifiant
        echo '<label for="id"> Nom utilisateur :</label>';
        echo '<input type="text" name="id" maxlength="20"><br>';
        //mdp
        echo '<label for="mdp"> Mot de passe :</label>';
        echo '<input type="password" name="mdp" maxlength="20"><br>';
        //bouton
        echo '<input type="submit" value="s\'identifier" name="authentification">';
        echo '</form>';

        if (isset($_POST['id']) && isset($_POST['mdp']) && isset($_POST['authentification'])) {
            try {
                $dbh = new PDO("pgsql:dbname=$dbname;host=$host;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
                $organisateur = $dbh->query('SELECT * from organisateur');
                echo ' <script type=text/javascript> alert("JavaScript Alert Box by PHP")</script>';

                $id = $_POST['id'];
                $mdp = $_POST['mdp'];
                $authentifie = false;
                foreach($utilisateur as $row) {
                    if($id === $row['identifiant'] && md5($mdp) ===  $row['motdepasse']) {
                        $authentifie = true;
                        $_SESSION['login'] = $id;
                        echo "Authentifaction réussi. Bienvenue " . $_SESSION['login'] . " !";
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
    }
    else if (isset($_POST['creerCompte']) || $page === "creerCompte") {
    ?>
        <!-- echo '<script src="clear.js" type="text/javascript"></script>';
        echo '<form method="post">';
        //identifiant
        echo '<label for="identifiant"> Identifiant :</label>';
        echo '<input type="text" name="identifiant" maxlength="20"><br>';
        //mdp
        echo '<label for="motdepasse"> Mot de passe :</label>';
        echo '<input type="password" name="motdepasse" maxlength="20"><br>';
        //confirmation mdp
        echo '<label for="confirmationMDP"> Confirmer votre mot de passe :</label>';
        echo '<input type="password" name="confirmationMDP" maxlength="20"><br>';
        //nom organisateur
        echo '<label for="nom"> Nom : </label>';
        echo '<input type="text" name="nom" maxlength="20"><br>';

        echo '<label for="prenom"> Prenom :</label>';
        echo '<input type="text" name="prenom" maxlength="20"><br>';

        echo '<input type="submit" value="s\'identifier" name="authentification">';
        echo '</form>'; -->
        <script src="clear.js" type="text/javascript"></script>
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
                    $dbh = new PDO("pgsql:dbname=$dbname;host=$host;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
                    $organisateur = $dbh->query('SELECT * from organisateur');
                    $identifiant = $_POST['identifiant'];
                    $mdp = $_POST['motdepasse'];
                    $dejaUtilise = false;
                    $lastId = 0;
                    foreach($organisateur as $row) {
                        foreach($row as $cle=>$value) {
                            $lastId = $row['numOrganisateur'];
                            if($identifiant === $row['identifiant']) {
                                echo 'Erreur, nom d\'utilisateur déjà utilisé !';
                                $dejaUtilise = true;
                            }
                        }
                    }
                    if(!$dejaUtilise) {
                        $sql = "INSERT INTO organisateur (numOrganisateur, identifiant, motdepasse, nom, prenom) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $dbh->prepare($sql);
                        //ajout utilisateur
                        $stmt->execute([$lastId+1, $identifiant, md5($mdp), $nom, $prenom]);
                        echo '<script src="clear.js" type="text/javascript"></script>';
                        $_SESSION['login'] = $identifiant;
                        echo "Enregistrement réussi. Bienvenue " . $_SESSION['login'] . " !";
                    }
                    $dbh = null;
                } catch (PDOException $e) {
                    print "Erreur ! : " . $e->getMessage() . "<br>";
                    die();
                }
            }
        }
    }
    ?>
  </body>
</html>