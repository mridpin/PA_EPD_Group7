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
                            $maxMin=calculateSingleMaxPrice($dates,$prices);
                        }
                        else{
                            //echo "Voy a calcular el minimo";
                            $maxMin=calculateSIngleMinPrice($dates,$prices);
                        }
                    }
                    }
                    //print_r(array_values($maxMin));
                    $result[$j][0]=$maxMin;                
                }
                
                //Despues de procesar los datos del area de texto
                
                if($_POST['sort']=="date")
                {
                    usort($result,"sortDates");
                }
                else
                {
                    usort($result,"sortPrices");
                }
              
                //print_r($result);
                 
            printTable($result);;
                 
        }
        
        function sortDates($date1,$date2)
        {
           /* print_r($date1[0][0]);
            print_r($date2[0][0]);*/
            return strtotime($date1[0][0]) - strtotime($date2[0][0]);
        }
        
        function sortPrices($price1,$price2)
        {
           /* print_r($price1[0][1]);
            print_r($price2[0][1]);*/
            return doubleval($price1[0][1]) - doubleval($price2[0][1]);
        }
        
        
        function printTable($data)
        {
            echo "<table border=1>";
            echo "<tr>";
            echo "<th>Fecha</th>";
            echo "<th>Precio Con Descuento</th>";
            echo "</tr>";
            
            
            for($j=0;$j<sizeof($data);$j++)
            {
                $maxMin = $data[$j][0];
                
                echo "<tr>";
                for($i=0;$i<sizeof($maxMin);$i++)
                {
                    echo "<td>$maxMin[$i]</td>";
                }

                echo"</tr>";
            }
            echo "</table> <br>";
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
        
        function calculateSingleMaxPrice($dates,$prices){
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
        
        function calculateSIngleMinPrice($dates,$prices)
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
        
        if(count($_POST['dates']) == count($_POST['prices']) && count($_POST['dates']) == $_POST['number_inputs'])
        {
            $raw_data = explode("\n",$_POST['mediciones']);
            //print_r(array_values($raw_data));
            processData($raw_data);
        }
        else
        {
            echo "ERROR: No se puede dejar campos vacios";
        }
        ?>
    </body>
</html>
