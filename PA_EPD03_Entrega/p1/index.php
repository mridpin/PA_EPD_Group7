<!DOCTYPE html>
<!--
    Grupo 07
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        function displayArray($array) {
            echo"(";
            foreach ($array as $i => $number) {
                echo $number . " ";
            }
            echo")";
        }

        function isPrime($number) {
            $count = 2;
            $result = TRUE;
            if ($number != 1) {
                while ($count <= $number / 2 && $result == TRUE) {
                    if ($number % $count == 0) {
                        $result = FALSE;
                    } else
                        $count = $count + 1;
                }
            }
            else {
                $result = FALSE;
            }
            return $result;
        }

        function calculaNumerosCompuestos($limite) {
            $result = [];

            for ($i = 2; $i <= $limite * 2; $i++) {
                if (isPrime($i) == FALSE) {
                    $result[] = $i;
                }
            }

            return $result;
        }

        $limite = 23;

        echo "<h1> Lista de los numeros compuestos hasta " . $limite * 2 . "</h1>";
        echo "<br>";

        $primeNumbers = calculaNumerosCompuestos($limite);
        displayArray($primeNumbers);
        ?>
    </body>
</html>
