<?php
session_start();

$numTournois = NULL;
$numTour = NULL;
$poules = NULL;
if (isset($_POST['numtournois'], $_POST['numtour'], $_POST['poules'])) {
    $numTournois = $_POST['numtournois'];
    $numTour = $_POST['numtour'];
    $poules = $_POST['poules'];
    $_SESSION['numtournois'] = $numTournois;
    $_SESSION['numtour'] = $numTour;
}
else if (isset($_SESSION['numtournois'], $_SESSION['numtour'])) {
    $numTournois = $_SESSION['numtournois'];
    $numTour = $_SESSION['numtour'];
}

function convertiTableauEnString($tableau) {
  $TabString = "";

  foreach($tableau as $cle => $value) {
      $TabString .= $cle . "_" . $value . ",";
  }
  $TabString = substr($TabString, 0, -1);   //enlève la dernière virgule
  
  return $TabString;
}

function toArray($poule)
{
  $oui = explode(',',$poule);
  $arraypoule = array();
  for($i=0; $i<count($oui); $i++)
  {
    $non = explode('-',$oui[$i]);
    array_push($arraypoule,$non);
  }
  return $arraypoule;
}

function composeMatchs($poule)
{
  $matchs = array();
  for($i=0; $i<count($poule); $i++)
  {
    for($j=($i+1); $j<count($poule); $j++)
    {
      array_push($matchs, $poule[$i]."-".$poule[$j]);
    }
  }
  return array_unique($matchs);
}


function creeMatchsArray($poule)
{
  $matchsArray = array();
  for($i=0; $i<count($poule); $i++)
  {
    if(gettype($poule[$i]) == "array")
    {
      array_push($matchsArray,creeMatchsArray($poule[$i]));
    }
    else
    {
      return composeMatchs($poule);
    }
  }
  return $matchsArray;
}

function initialisationTableauScore($arraymatch)
{
  $Tableauscore = array();
  for($i=0; $i<count($arraymatch); $i++)
  {
    for($j=0; $j<count($arraymatch[$i]); $j++)
    {
      if(array_key_exists($arraymatch[$i][$j],$Tableauscore))
      {
        $Tableauscore[$arraymatch[$i][$j]] = NULL;
      }
      else{
        array_push($Tableauscore, $arraymatch[$i][$j]);
        $Tableauscore[$arraymatch[$i][$j]] = NULL;
      }
    }
  }
  foreach($Tableauscore as $cle => $valeur)
  {
    if (is_int($cle)) {
      unset($Tableauscore[$cle]);
    } 
  }
  return $Tableauscore;
}

$arrayPoules = toArray("eq1-eq2-eq3,eq4-eq5-eq6-eq7,eq8-eq9-eq10");
//$arrayPoules = toArray($poules);
$arrayMatchs = creeMatchsArray($arrayPoules);



if(isset($_SESSION['TableauScore']))
{
  $tableauscore = $_SESSION['TableauScore'];
  $nameScore = explode('_',$_POST['score']);
  $tableauscore[$nameScore[0]] = $nameScore[1];
  $_SESSION['TableauScore'] = $tableauscore;
}
else
{
  $_SESSION['TableauScore'] = initialisationTableauScore($arrayMatchs);
}


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Page Poules</title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
  <h1>Les Matchs du Tour <?php echo '"' . $numtour . '"';  ?> </h1>
  <?php

    for($numPoule=0; $numPoule<count($arrayMatchs); $numPoule++)
    {
      echo "<h3>Poule n°".($numPoule+1)." :</h3>";
      for($matchs=0; $matchs<count($arrayMatchs[$numPoule]); $matchs++)
      {
        echo '<form method="post" action="pageMatch.php">';
        echo '<input type="hidden" name="numtournois" value='.$numTournois.'>';
        echo '<input type="hidden" name="score" value=' . ($tableauscore[$arrayMatchs[$numPoule][$matchs]]===NULL ? "0-0" : $tableauscore[$arrayMatchs[$numPoule][$matchs]]).'>';//score = "4-6"
        echo '<input type="hidden" name="equipes" value=' . $arrayMatchs[$numPoule][$matchs] . '>';
        echo '<input type="submit" name="match" value=' .  $arrayMatchs[$numPoule][$matchs] .'>';
        if($tableauscore[$arrayMatchs[$numPoule][$matchs]]!=NULL)
          echo $tableauscore[$arrayMatchs[$numPoule][$matchs]];
        else
          echo 'pas joué';
        echo '</form>';

      }
    }

    print_r($tableauscore);
    //Rajouter modifier $_SESSION['classement'] et verif que tout les matchs sont fini
    ?>
    <br><br>
    <form id="validerTour" method ="post" action="pageTournois.php">
    <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
    <input type="hidden" name="numtour" value=<?php echo $numTour ?>>
    </form>
    <button type="button" onclick=<?php echo 'validerTour("' . convertiTableauEnString($tableauscore) . '",' . '"' . $poules . '");'?> >Valider Tour</button>
    <script src="js/scriptPageMatchsPoules.js"></script>
  </body>
</html>