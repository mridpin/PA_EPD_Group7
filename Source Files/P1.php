<!DOCTYPE html>
<html>
    <body>
        <?php
            $vec = numeroN(50);
            function numeroN($n){
                $n = 2*$n;
                for ($i=2;$i<$n;$i++) {
                    $j = 2;
                    while($j <= $i/2) {
                        if ($i % $j == 0) {
                            $vec[$i] = $i;
                        }
                        $j++;
                    }
                }
                return $vec;
            }
            print_r( $vec);
        ?>
    </body>
</html>