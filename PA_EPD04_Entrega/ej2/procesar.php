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
        
        
        function processData($line){
            $maxMin;
            $companyName="";
            $result;
            for($j=0;$j<sizeof($line);$j++)
            {
                $raw_data=explode(";",$line[$j]); //Dividimos la linea en las mediciones, el nombre de la gasolinera y si queremos calcular el maximo o minimo
                
                for($i=0; $i<sizeof($raw_data);$i++){
                    if($i==0){
                        //Preparamos las fechas y los precios para trabajar con ellos
                        $aux2 = explode(" ", $raw_data[$i]);


                        $dates=processDates($aux2);

                        $prices=processPrices($aux2);

                    }
                    elseif($i==1){
                        //Este es el titulo de la gasolinera
                        $companyName=$raw_data[$i];
                    }
                    else{
                        if(trim($raw_data[$i])=="MAXIMO")
                        {
                            $maxMin=calculateSingleMaxPrice($dates,$prices);
                        }
                        else{
                            $maxMin=calculateSIngleMinPrice($dates,$prices);
                        }
                    }
                    }
                    $result[$j][0]=$maxMin;
                    $result[$j][1]=$companyName;                   
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
                
                
                if($_POST["typesort"]=="descend")
                {
                    $result=  array_reverse($result);
                }

                 
            printTable($result);;
                 
        }
        
        function sortDates($date1,$date2)
        {
            return strtotime($date1[0][0]) - strtotime($date2[0][0]);
        }
        
        function sortPrices($price1,$price2)
        {
            return doubleval($price1[0][1]) - doubleval($price2[0][1]);
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
            echo "</table> <br>";
            
            if(isset($_POST['av_checkbox']))
            {
                echo "Media de los precios: " . number_format(calculateAverage($data),2);
            }
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
        
        function calculateAverage($data)
        {
            $sum =0.00;
            foreach($data as $aux)
            {
                $sum+=doubleval($aux[0][1]);
            }
            return $sum/count($data);
        }
        
        if($_POST['mediciones']!="" && isset($_POST['sort']))
        {
            $raw_data = explode("\n",$_POST['mediciones']);
            processData($raw_data);
        }
        else
        {
            echo "ERROR: No se puede dejar campos vacios";
        }
        ?>
    </body>
</html>
