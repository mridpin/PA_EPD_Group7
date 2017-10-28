<!DOCTYPE html>
<html>
    <body>
        <?php

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
        print_r($sol[2]);
        ?>
    </body>
</html>
