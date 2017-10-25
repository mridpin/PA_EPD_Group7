<!DOCTYPE html>
<!--
    Grupo 07
-->
<?php
function table($matrix) {
    echo "<table>\n"; /* "" imprime literal lo que haya en las comillas. '' interpreta lo que hay como string */
    echo "<table border='1'>\n";
    /* Create table header */
    echo "<tr>\n";
    echo "<th colspan=\"2\">Rest</th>\n";
    echo "<th colspan=\"2\">Walking</th>\n";
    echo "<th colspan=\"2\">Running</th>\n";
    echo "</tr>";
    echo "<tr>\n";
    echo "<th>min.</th>\n";
    echo "<th>%</th>\n";
    echo "<th>min.</th>\n";
    echo "<th>%</th>\n";
    echo "<th>min.</th>\n";
    echo "<th>%</th>\n";
    echo "</tr>";
    /* EO table header */

    $totalRest = 0;
    $totalWalk = 0;
    $totalRun = 0;


    foreach ($matrix as $vec) {
        echo "<tr>\n"; /* Open a tr tag for each row. 1row=1vector */
        /* Get total time for percent calculation */
        $totalTime = array_sum($vec);
        $totalRest += $vec[0];
        $totalWalk += $vec[1];
        $totalRun += $vec[2];

        foreach ($vec as $data) {
            echo "<td>" . $data . "</td>";
            $percent = 100 * ($data / $totalTime);
            echo "<td>" . round($percent, 2) . "</td>";
        }
        echo "</tr>";
    }

    /* Last row with sum */
    $sum = "\u{2211}"; //Unicode for sum sign
    echo "<tr class=\"sumrow\" bgcolor=\"#c0c0c0\">"; /* Correct usage is to change the color with CSS instead */
    echo "<td>" .  $totalRest . "</td>";
    echo "<td>" . $sum . "</td>"; /* Empty cols to skip percent sum */
    echo "<td>" . $totalWalk . "</td>";
    echo "<td>" . $sum . "</td>";
    echo "<td>" . $totalRun . "</td>";
    echo "<td>" . $sum . "</td>";
    echo "</tr>";
    echo "</table>";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>
            EXERCISE TABLE:
        </h1>

        <?php
        $min = 5;
        $max = 30;
        $n = 10;
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $matrix[$i][$j] = rand($min, $max);
            }
        }
        table($matrix);
        ?>
    </body>
</html>
