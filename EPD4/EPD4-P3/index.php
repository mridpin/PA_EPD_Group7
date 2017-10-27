<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Primer Formulario</h1>
        <form action="segundoFormulario.php" id="form" method="POST">
            Por favor seleccione el m&eacute;s de medicion: 
            <input type="number" name="month_data" value="1" min="1" max="12"/>
            <br>
            Seleccione el n&uacute;mero de mediciones m&aacute;ximo que se podr&aacute;n tomar:
            <input type="number" name="n_data" value="1" min="1"/>
            <br>
            Indique el porcentaje de descuento que se le har&aacute;n a los precios:
            <input type="number" name="discount" value="0" min="0" max="100"/>
            <br>
            <input type="submit" value="Enviar" />
        </form>
    </body>
</html>
