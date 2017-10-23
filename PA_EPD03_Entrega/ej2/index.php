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
        
        
            function isDate($date){
                    $result=FALSE;
                    list($year,$month,$day)= explode("-", $date);
                    if(checkdate($month,$day,$year)){
                        $result=TRUE;
                    }
                    return $result;
            }
        
            function addDays($date,$daystoadd){
                if(isDate($date)==FALSE){ //We check to see if the date is valid
                    $finaldate=FALSE;
                }
                else
                {
                    $finaldate = new DateTime($date);
                    $stringdaystoadd='P'.$daystoadd.'D';
                    $finaldate->add(new DateInterval($stringdaystoadd));
                }
                return $finaldate;
            }
            
            
            
            
            
                echo '<h1> Fechas </h1>';
                $date1="1997-09-10";
                $date2="2016-02-28";
                $date3="2005-09-30";
                $date4="2011-11-11";
                $date5="2018-11-45";
                $daystoadd=2;
                
                $dates= array($date1,$date2,$date3,$date4,$date5);
                
                foreach($dates as $i){
                echo "Fecha antes del cambio: ".$i." ";
                 $finaldate= addDays($i, $daystoadd);
                 if($finaldate==FALSE)
                 {
                     echo "ERROR: FECHA INCORRECTA";
                 }
                 else
                 {
                    echo "Fecha despu&eacutes del cambio: ".$finaldate->format('Y-m-d');
                 }
                 echo "<br>";
                }
                
                
        ?>
    </body>
</html>
