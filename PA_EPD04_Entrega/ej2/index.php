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
        <form action="procesar.php" id="form" method="POST">
            <p>
                Por favor, introduzca las mediciones de precios del producto DIESEL: <br>
                <textarea name="mediciones" form="form" rows="4" cols="55"></textarea> <br>
                Indique como desea la ordenaci&oacute;n de los datos:<br>
                Seg&uacute;n el precio <input type="radio" name = "sort" value="price" />
                <br>
                Seg&uacute;n la fecha <input type="radio" name = "sort" value="date" />
                <br>
                Indique como desea el sentido de la ordenaci&oacute;n de los datos:<br>
                <select name="typesort">
                    
                    <option value="ascend">Ascendente</option>
                    <option value="descend">Descendente</option>
                    
                </select>
                <br>
                ¿Desea obtener la media de los precios de las tomas?: 
                <input type="checkbox" name="av_checkbox" value="True">
                <br>
                <input type="submit" value="Send" />
            </p>
        </form>    
        
    </body>
</html>
