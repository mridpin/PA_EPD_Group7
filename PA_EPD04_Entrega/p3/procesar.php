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
        
        
        function processData($dates,$prices){
            $result;
           
                //Filtramos las mediciones que no nos sirvan y lo introducimos en una estructura
                $result=filter($prices,$dates);
                
                
                //Aplicamos los descuentos
                
                if($_POST['discount']!="0")
                array_walk($result,'applyDiscount');
            
                
                //Despues de procesar los datos
                
                if($_POST['sort']=="Fecha")
                {
                    usort($result,"sortDates");
                }
                else
                {
                    usort($result,"sortPrices");
                }
              
                 
            printTable($result);
                 
        }
        
        function filter($prices,$dates)
        {
            $result;
            $count=0;
            $result[$count][0]="00/00/0000"; //Valores por defecto
            $result[$count][1]="0";
            for($i=0;$i<sizeof($prices);$i++)
            {
                $aux=explode("/",$dates[$i]);
                if($aux[1]==intval($_POST['month']))
                {
                    $result[$count][0]=$dates[$i];
                    $result[$count][1]=$prices[$i];
                    $count++;
                }
            }
            return $result;
        }
        
        function applyDiscount(&$data)
        {
            $data[1] = ($data[1] * (100-intval($_POST['discount'])))/100;  
        }
        
        function sortDates($date1,$date2)
        {
            return strtotime($date1[0]) - strtotime($date2[0]);
        }
        
        function sortPrices($price1,$price2)
        {
            return doubleval($price1[1]) - doubleval($price2[1]);
        }
        
        
        function printTable($data)
        {
            $discount=$_POST['discount'];
            $month=$_POST['month'];
            echo "<table border=1>";
            echo "<tr>";
            echo "<th>Fechas del mes $month</th>";
            echo "<th>Precios Con Descuento($discount %)</th>";
            echo "</tr>";
            
            
            for($j=0;$j<sizeof($data);$j++)
            {
                $maxMin = $data[$j];
                
                echo "<tr>";
                for($i=0;$i<sizeof($maxMin);$i++)
                {
                    echo "<td>$maxMin[$i]</td>";
                }

                echo"</tr>";
            }
            echo "</table> <br>";
        }
        
        if(count($_POST['dates']) == count($_POST['prices']) && count($_POST['dates']) == $_POST['number_inputs'])
        {
            processData($_POST['dates'],$_POST['prices']);
        }
        else
        {
            echo "ERROR: No se puede dejar campos vacios";
        }
        ?>
    </body>
</html>
