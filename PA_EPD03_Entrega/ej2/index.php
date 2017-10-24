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
        
        
            function isDate($day,$month,$year,$monthDays){
                    $result=FALSE;
                    if($day>0 && $month>0 && $year>0 && $day<=$monthDays[$month-1] && $month<=12){
                        $result=TRUE;
                    }
                    
                    return $result;
            }
            
            function isLeap($year)
            {
                $result=FALSE;
                
                if((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)))
                {
                    $result=TRUE;
                }
                return $result;
            }
        
            function addDays($rawdate,$daystoadd,$monthDays)
                    {
                $date= explode("-", $rawdate);
                $year = (int) $date[0];
                $month = (int) $date[1];
                $day = (int) $date[2];
                $result=FALSE;
                
                if(isDate($day, $month, $year, $monthDays)==TRUE)
                {
                   $result="";
                   
                   if(isLeap($year)==TRUE)
                   {
                       $monthDays[1]=29;
                   }
                   
                  for($i=0;$i<$daystoadd;$i++)
                  {
                        $day++;
                        if($day>$monthDays[$month-1])
                        {
                                $day=1;
                                $month++;
                                if($month==13)
                                {
                                    $month=1;
                                    $year++;
                                }
                        }
                    }
                    $result="$year-$month-$day";
                }
                
                return $result;
                
            }
            
            
                echo '<h1> Fechas </h1>';
                $date1="1997-9-10";
                $date2="2016-2-28";
                $date3="2005-9-30";
                $date4="2011-11-11";
                $date5="2018-11-45";
                
                $daystoadd=2;
                $monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                
                $dates= array($date1,$date2,$date3,$date4,$date5);
                
                foreach($dates as $i){
                echo "Fecha antes del cambio: ".$i." ";
                 $finaldate= addDays($i, $daystoadd,$monthDays);
                 if($finaldate==FALSE)
                 {
                     echo "ERROR: FECHA INCORRECTA";
                 }
                 else
                 {
                    echo "Fecha despu&eacutes del cambio: ".$finaldate;
                 }
                 echo "<br>";
                } 
                
                
        ?>
    </body>
</html>
