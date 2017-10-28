<?php
    $medicos = array();
    agregarMedico("Alfonso", $medicos);
    agregarMedico("Miguel", $medicos);
    mostrarAgenda("Alfonso", 2016, 3, 12, $medicos);

    function agregarMedico($nombreMedico, &$medicos) {
        #Vector años
        $medicos[$nombreMedico] = array();
        for ($años = 0, $añosR = 2016; $años <= 10; $años++, $añosR++) {
            $medicos[$nombreMedico][$años] = $añosR;

            #Vector meses
            $medicos[$nombreMedico][$años] = array();
            for ($meses = 0, $mesesR = 1; $meses <= 12; $meses++, $mesesR++) {
                $medicos[$nombreMedico][$años][$meses] = $mesesR;

                #Vector dias
                $medicos[$nombreMedico][$años][$meses] = array();
                for ($dias = 0, $diasR = 1; $dias <= 30; $dias++, $diasR++) {
                    $medicos[$nombreMedico][$años][$meses][$dias] = $diasR;

                    #Vector horas
                    $medicos[$nombreMedico][$años][$meses][$dias] = array();
                    for ($horas = 0, $horasR = 9; $horas <= 6; $horas++, $horasR++) {
                        $medicos[$nombreMedico][$años][$meses][$dias][$horas] = $horasR . ":00";
                    }
                }
            }
        }
    }

    function mostrarAgenda($medico, $año, $mes, $dia, &$medicos) {
        #Vector horas
        $nHoras = count($medicos[$medico][$año - 2016][$mes - 1][$dia - 1]);
        echo "Para el Dr." . $medico . " las citas disponibles para el " . $dia . "/" . $mes . "/" . $año . ":";
        for ($i = 0; $i < $nHoras; $i++) {
            echo $medicos[$medico][$año - 2016][$mes - 1][$dia - 1][$i] . "<br>";
        }
    }

?>
