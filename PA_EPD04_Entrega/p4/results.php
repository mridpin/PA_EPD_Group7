<!DOCTYPE html>
<!--
    Grupo 07: EPD_04_P4
-->
<?php

function matrixOperation1($matrix, $n) {
    $size = isValidMatrix($matrix, $n);
    if ($size == false) {
        return false;
    } else {
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($j < $i) {
                    $matrix[$i][$j] = $n;
                }
            }
        }
        return $matrix;
    }
}

function matrixOperation2($matrix, $n) {
    $size = count($matrix);
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($j == $i) {
                $res[$i] = $matrix[$i][$j] * $n;
            }
        }
    }
    return $res;
}

/* Returns false if sum(elements)<n or if matrix is non square. 
 * Returns size of matrix otherwise */

function isValidMatrix($matrix, $n) {
    $size = count($matrix);
    $totalValue = 0;
    foreach ($matrix as $row) {
        if ($size != count($row)) {
            /* Discards non square matrices */
            return false;
        }
        foreach ($row as $data) {
            $totalValue += $data;
        }
    }
    if ($n > $totalValue) {
        return false;
    } else {
        return $size;
    }
}

function printMatrix($matrix) {
    echo "<table>";
    foreach ($matrix as $row) {
        echo "<tr>\n";
        foreach ($row as $data) {
            echo "<td>" . sprintf("%02s", $data) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function printVector($vec) {
    echo "<table>";
    echo "<tr>\n";
    foreach ($vec as $data) {
        echo "<td>" . sprintf("%02s", $data) . "</td>";
    }
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
            PA EPD04 P4: OPERATIONS WITH MATRICES:
        </h1>
        <?php
        $n = 9;
        $min = 1;
        $max = 10;
        $m = 4;
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $matrix[$i][$j] = rand($min, $max);
            }
        }
        printMatrix($matrix);
        ?>
        <h2>
            ORIGINAL NUMBER:
        </h2>
        <?php
        echo "<p>" . $n . "</p>";
        ?>
        <h2>
            FIRST OP MATRIX:
        </h2>
        <?php
        $resMatrix1 = matrixOperation1($matrix, $n);
        if ($resMatrix1 == false) {
            echo "ERROR IN MATRIX: MATRIX MUST BE SQUARE AND COMPLY WITH sum(elements)<n";
        } else {
            printMatrix($resMatrix1);
        }
        ?>
        <h2>
            SECOND OP MATRIX:
        </h2>
        <?php
        $resVec2 = matrixOperation2($matrix, $n);
        printVector($resVec2);
        ?>
    </body>
</html>
