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
        //Hidden fields to keep the previous values from form in index.php
        $form="";
        if(isset($_POST['month_data']) && isset($_POST['n_data']) && isset($_POST['discount']))
        {
            if($_POST['month_data']>0 && $_POST['month_data']<=12 && $_POST['n_data']>0 && $_POST['discount']>=0 && $_POST['discount']<=100)
            {
                $selected_month=$_POST['month_data'];
                $number_inputs=$_POST['n_data'];
                $discount=abs($_POST['discount']);
                $form="<h1>Segundo Formulario</h1>"
                        . "<br>"
                        . "<form action='procesar.php' id='form2' method='POST'>"
                        . "<table border='1'>"
                        . "<tr>"
                            . "<th>Fecha(dd/mm/yyyy)</th>"
                            . "<th>Medici&oacuten(x.xx)</th>"
                        . "</tr>";

                for($i=0;$i<$number_inputs;$i++)
                {
                    $form.="<tr>"
                            ."<td><input type='text' name='dates[]'/></td>"
                            ."<td><input type='text' name='prices[]'/></td>"
                            ."</tr>";
                }

                    $form.="</table>"
                    . "<input type='hidden' name='month' value='$selected_month'/>" //This is so that we know in the next page which is the selelected month
                    . "<input type='hidden' name='number_inputs' value='$number_inputs'/>"
                    . "<input type='hidden' name='discount' value='$discount'/>"
                    . "<br>"
                    . "Ordenar por:"
                    . "<br>"
                    . "<br>"
                    . "<input type='submit' name='sort' value='Fecha' />"
                    . "&nbsp&nbsp&nbsp&nbsp"
                    . "<input type='submit' name='sort' value='Precio' />"
                ."</form>";
            }
            else
                $form="ERROR: Introduzca valores validos para los campos";
        }
        else
        {
            $form="ERROR: No se pueden dejar campos vacios ";
        }
        echo "$form";
        ?>
    </body>
</html>
