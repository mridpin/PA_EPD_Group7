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

        function isPrime($number) {
            $count = 2;
            $result = TRUE;
            if($number!=1)
            {
                while ($count <= $number / 2 && $result == TRUE) {
                    if ($number % $count == 0) {
                        $result = FALSE;
                    } else{
                        $count = $count + 1;
                    }
                }
            }
            else{
                $result=FALSE;
            }
            return $result;
        }

        function fibonacci($limite) {

            $j = 0;
            $i = 1;
            $aux=0;
            $pos=0;
            while($i + $j < $limite) {
                
                if(isPrime($i+$j)==True)
                {
                    $resultado[$pos] = $i + $j;
                    $i = $j;
                    $j = $resultado[$pos];
                    $pos++;
                }
                else
                {
                    $aux = $i + $j;
                    $i = $j;
                    $j = $aux;
                }
            }

            return $resultado;
        }

        function imprimir($numeros) {
            $resultado = "<table border =1>";

            foreach ($numeros as $i) {
                $resultado .= "<tr>";
                $resultado .= '<td>' . $i . '</td>';
                $resultado .= "</tr>";
            }
            $resultado .= "</table>";
            return $resultado;
        }

        $limite = 10000;

        $resultado = fibonacci($limite);
        echo "<h1>Prime Numbers in the Fibonacci sequence:</h1><br>";
        echo imprimir($resultado)
        ?>
    </body>
</html>
