<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de match</title>
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
        <h1>Match qui oppose <?php echo $equipes[0] . " vs " . $equipes[1]; ?></h1>
        <table>
            <tr id="nomEquipes">
                <th><?php echo $equipes[0]; ?></th>
                <th><?php echo $equipes[1]; ?></th>
            </tr>
            <tr id="score">
                <th id="scoreJ1"><?php echo $score[0]; ?></th>
                <th id="scoreJ2"><?php echo $score[1]; ?></th>
            </tr>
            <tr id="boutons">
                <th><button type="button" name="plusUnJ1" value="+1" onclick="plusUnJ1($score[0]);"></th>
                <th><button type="button" name="plusUnJ2" value="+1" onclick="plusUnJ2($score[1]);"></th>
            </tr>
        </table>
        <?php
    }
    else {
        echo "Erreur lors du chargement des données de la page ! <br>";
    } 
    ?>
    <script src="feuilleMatch.js"></script>
  </body>
</html>