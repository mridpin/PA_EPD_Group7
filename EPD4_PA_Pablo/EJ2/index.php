<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1252">
        <title>Ejercicio 1 - EPD4 </title>
        <meta charset=UTF-8" />
    </head>
    <body>
        <h1> Introduce datos </h1>
        <form method="post" action="form.php">
            <span>Ordenar por: </span>
            <input type="radio" name="cols" checked value="fecha">fecha</input>
            <input type="radio" name="cols" value="precio">precio</input>
            
            <select name="select">
                <option value="menorMayor">menor a mayor</option>
                <option value="mayorMenor"> mayor a menor</option>
            </select>
            <textarea name="info" id="info" style="height: 200px; width: 500px;">01/10/2016-1,01 02/10/2016-1,03 3/10/2016-1,10;REPSOL;MAXIMO
08/09/2016-1,11 16/09/2016-1,14 23/09/2016-1,12;CEPSA;MINIMO</textarea>
            <input type="checkbox" name="media">
            <span>Obtener la media de precios de las tomas</span>
            <input class="clear" type="submit" name="envio" value="Enviar" />
            <input type="reset" name="rest" value="Restaurar" />
        </form>

    </body>
</html>
