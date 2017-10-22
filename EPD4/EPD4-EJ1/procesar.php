<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        
        function processData($line){
            $raw_data = explode(";",$line); //Dividimos la linea en las mediciones, el nombre de la gasolinera y si queremos calcular el maximo o minimo
            for($i=0; $i<sizeof($raw_data);$i++){
                if($i==0){
                    $aux2 = explode(" ", $line);
                    $dates=processDates($aux2);
                    $prices=processPrices($aux2);
                }
                elseif($i==1){
                    //Este es el titulo de la gasolinera
                    $companyName=$line[$i];
                }
                else{
                    if($i=="MAXIMO"){
                        max($dates,$prices); //Pasar los datos
                    }
                    else{
                        min($dates,$prices);//Pasar los datos
                    }
                }
            }
        }
        
        function printTable($data,$companyName)
        {
            
        }
        
        function processDates($line){
            $result=array();
            $i=0;
            foreach($line as $aux)
            {
                $aux2=explode("-",$aux);
                array_push($result, $aux2[$i]);
                $i=$i=2;
            }
            
            return $result;
        }
        
        function processPrices($line){
            $result=array();
            $i=1;
            foreach($line as $aux)
            {
                $aux2=explode("-",$aux);
                array_push($result, $aux2[$i]);
                $i=$i=2;
            }
            
            return $result;
        }
        
        function max($dates,$prices){
            
        }
        
        function min($dates,$prices){
            
        }




        $raw_data = explode("\n",$_POST['mediciones']);
        print_r(array_values($data));
        ?>
    </body>
</html>
