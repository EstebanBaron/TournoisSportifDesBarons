<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Tour</title>
        <link rel="stylesheet" href="stylePageModifierPoules.css" />
    </head>
    <body>
        <?php
        if (isset($_SESSION[''])) {
        ?>
        <h1>Poules actuelles : </h1>
        <div id="poules">
            
        </div>
        <?php
        }
        ?>
    </body>
</html>