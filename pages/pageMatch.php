<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de match</title>
    <link rel="stylesheet" href="css/styleFeuilleMatch.css" />
  </head>
  <body>
    <?php
    if (isset($_POST['numtournois'], $_POST['score'], $_POST['equipes'])) {
        $numTournois = $_POST['numtournois'];
        $score = $_POST['score'];
        $equipes = $_POST['equipes'];

        $equipes = explode('-', $equipes);
        $score = explode('-', $score);
        ?>
        <h1>Match qui oppose <?php echo '"' . $equipes[0] . '" et "' . $equipes[1] . '"' ?></h1>
        <table>
            <tr id="nomEquipes">
                <th id="equipe1"><?php echo $equipes[0]; ?></th>
                <th id="equipe2"><?php echo $equipes[1]; ?></th>
            </tr>
            <tr id="score">
                <div id="divJ1">
                    <th id="scoreJ1"><?php echo $score[0]; ?></th>
                </div>
                <div id="divJ2">
                    <th id="scoreJ2"><?php echo $score[1]; ?></th>
                </div>
            </tr>
            <tr id="boutons">
                <th id="boutonJ1"><button type="button" name="plusUnJ1" onclick="plusUnJ1($score[0]);">+1</button></th>
                <th id="boutonJ2"><button type="button" name="plusUnJ2" onclick="plusUnJ2($score[1]);">+1</button></th>
            </tr>
        </table>

        <form method="post" action="">
            <input type="hidden" name="numtournois" value=<?php echo $numTournois;?>>
            <input type="hidden" name="equipes" value=<?php echo $equipes[0] . '-' . $equipes[1];?>>
            <input type="hidden" name="score" value=<?php echo getScoreJ1() . '-' . getScoreJ2();?>>
        </form>
        <?php
    }
    else {
        echo "Erreur lors du chargement des données de la page ! <br>";
    } 
    ?>
    <script src="js/feuilleMatch.js"></script>
  </body>
</html>