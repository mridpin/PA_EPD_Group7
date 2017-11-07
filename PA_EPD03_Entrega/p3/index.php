<!DOCTYPE html>
<!--
    Grupo 07
-->
<html>
    <body>
        <?php
        function printVector($vec) {
            echo "<table>";
            echo "<tr>\n";
            foreach ($vec as $data) {
                echo "<td>" . sprintf("%02s", $data) . "</td>";
            }
            echo "</tr>";
            echo "</table>";
        }
        function sumatorioN($n){
            $vec=[];
            if ($n%2==0) {
              $sum=0;
              $k=0;
              $v=[];
              for ($i=2; $i<=$n ; $i+=2) {
                $sum=$sum+$i;
                $v[$k]=$i;
                $k++;
              }
              $vec[0]=$n;
              $vec[1]=$sum;
              $vec[2]=$v;
            }
            return $vec;
        }
      
        $sol=sumatorioN(200);
        echo "Sumatorio de $sol[0]. ''<br>''";
        echo "Suma = $sol[1] ''<br>''";
        echo "Sumandos: ";
        printVector($sol[2]); 
        ?>
    </body>
</html>
