<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1252">
        <title>Problema 3 - EPD4</title>
        <meta charset=UTF-8" />
    </head>
    <body>
        <h1> Introduce datos </h1>
        <?php
            echo "<table><form method='post' action='form.php'>"
            . "<tr>"
                        . "<td>Fecha</td>"
                        . "<td>Medicion</td>"
            . "</tr>";
            
            for($i=0;$i<$_POST['mediciones'];$i++){
                echo "<tr>"
                        . "<td><input type='date' name='fecha$i'></td>"
                        . "<td><input type='number' name='precio$i'></td>"
            . "</tr>";
            }
            echo "<span>Ordenar por: </span>
            <input type='radio' name='cols' checked value='fecha'>fecha</input>
            <input type='radio' name='cols' value='precio'>precio</input>
            
            <select name='select'>
                <option value='menorMayor'>menor a mayor</option>
                <option value='mayorMenor'> mayor a menor</option>
            </select>
            <input type='hidden' name='mediciones' value=' " . $_POST['mediciones'] ."'/>
            <input type='hidden' name='mes' value=' " . $_POST['mes'] ."'/>
            <input type='hidden' name='descuento' value=' " . $_POST['descuento'] ."'/>
            <input type='reset' name='rest' value='Restaurar' />
            
            <input type='submit' name='envio' value='Enviar' />
            "
                
            . "</form></table>";
        ?>
    </body>
</html>
