<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        
        function processData($line){
            $maxMin;
            $companyName="";
            $result;
            for($j=0;$j<sizeof($line);$j++)
            {
                $raw_data=explode(";",$line[$j]); //Dividimos la linea en las mediciones, el nombre de la gasolinera y si queremos calcular el maximo o minimo

                //print_r(array_values($raw_data));

                
                for($i=0; $i<sizeof($raw_data);$i++){
                    if($i==0){
                        //Preparamos las fechas y los precios para trabajar con ellos
                        $aux2 = explode(" ", $raw_data[$i]);

                        //print_r(array_values($aux2));

                        $dates=processDates($aux2);

                        //print_r(array_values($dates));

                        $prices=processPrices($aux2);

                        //print_r(array_values($prices));
                    }
                    elseif($i==1){
                        //Este es el titulo de la gasolinera
                        $companyName=$raw_data[$i];
                    }
                    else{
                        //echo "$raw_data[$i]";
                        if(trim($raw_data[$i])=="MAXIMO")
                        {
                            //echo "Voy a calcular el maximo";
                            $maxMin=calculateMax($dates,$prices);
                        }
                        else{
                            //echo "Voy a calcular el minimo";
                            $maxMin=calculateMin($dates,$prices);
                        }
                    }
                    }
                    //print_r(array_values($maxMin));
                    $result[$j][0]=$maxMin;
                    $result[$j][1]=$companyName;                   
                }
                 
            printTable($result);
                 
        }
        
        function printTable($data)
        {
            echo "<table border=1>";
            echo "<tr>";
            echo "<th>Fecha</th>";
            echo "<th>Precio</th>";
            echo "<th>Maximo/Minimo</th>";
            echo "<th>Gasolinera</th>";
            echo "</tr>";
            
            
            for($j=0;$j<sizeof($data);$j++)
            {
                $maxMin = $data[$j][0];
                $companyName = $data[$j][1];
                
                echo "<tr>";
                for($i=0;$i<sizeof($maxMin);$i++)
                {
                    echo "<td>$maxMin[$i]</td>";
                }

                echo "<td>$companyName</td>";

                echo"</tr>";
            }
            
            
            echo "</table>";
        }
        
        function processDates($line){
            $result=[];
            $i=0;
            for($i=0;$i<sizeof($line);$i++)
            {
                $aux=explode("-",$line[$i]);
                array_push($result, $aux[0]);
            }
            
            return $result;
        }
        
        function processPrices($line){
            $result=[];
            $i=0;
            for($i=0;$i<sizeof($line);$i++)
            {
                $aux=explode("-",$line[$i]);
                array_push($result, $aux[1]);
            }
            
            return $result;
        }
        
        function calculateMax($dates,$prices){
            $maxDate= $dates[0];
            $maxPrice=$prices[0];
            $i=0;
            foreach($prices as $aux)
            {
                if($aux > $maxPrice)
                {
                    $maxPrice=$aux;
                    $maxDate=$dates[$i];
                }
                $i++;
            }
            return array($maxDate,$maxPrice,"MAXIMO");
        }
        
        function calculateMin($dates,$prices)
        {
            $minDate= $dates[0];
            $minPrice=$prices[0];
            $i=0;
            foreach($prices as $aux)
            {
                if($aux < $minPrice)
                {
                    $minPrice=$aux;
                    $minDate=$dates[$i];
                }
                $i++;
            }
            return array($minDate,$minPrice,"MINIMO"); 
        }

        $raw_data = explode("\n",$_POST['mediciones']);
        //print_r(array_values($raw_data));
        processData($raw_data);
        ?>
    </body>
</html>
