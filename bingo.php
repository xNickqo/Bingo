<HTML>
<HEAD><TITLE>Bingo</TITLE></HEAD>
<BODY>
<?php

include 'functions.php'

$numJugadores = 1;
$cartonesPorJugador = 1;

/* Creación de la estructura de datos de los jugadores*/
$nombreJugador = "j";

for($i=1 ; $i<=$numJugadores ; $i++)
{
    ${$nombreJugador.$i} = array(("Jugador ".$i) => array(array(), array())); 
}

$aciertosBingo = array();
for ($i=1; $i <= $numJugadores; $i++)
{ 
    $aciertosBingo["Jugador " . $i] = array();
    for ($j=0; $j < $cartonesPorJugador; $j++) { 
        array_push($aciertosBingo["Jugador " . $i],0);
    }
}

/* Creación de los cartones de cada jugador */
for ($z=1; $z <= $numJugadores ; $z++)
{ 
    $jugadorActual = &${$nombreJugador.$z};

    foreach($jugadorActual as $jugador => &$cartones)
    {
        for ($fila=0; $fila < $cartonesPorJugador; $fila++)
        {
            // Rellena el array con 60 posiciones en false
            $numerosRepetidos = array_fill(0, 60, false);

            $control1 = 1;
            $control2 = 9;

            for ($numero=0; $numero < 15; $numero++)
            { 
                $repetir = false;
                
                do {
                    $num = rand($control1,$control2);
                    if ($numerosRepetidos[$num-1] == false)
                    {
                        $cartones[$fila][$numero] = $num;
                        $numerosRepetidos[$num-1] = true;
                        $repetir = false;
                    }
                    else
                        $repetir = true;
                } while ($repetir);

                // Filtro control numeros cartones
                if ($numero == 1) {
                    $control1 = 10;$control2 = 19;
                }
                elseif ($numero == 3) {
                    $control1 = 20;$control2 = 29;
                }
                elseif ($numero == 6) {
                    $control1 = 30;$control2 = 39;
                }
                elseif ($numero == 8) {
                    $control1 = 40;$control2 = 49;
                }
                elseif ($numero == 10){
                    $control1 = 50;$control2 = 59;
                }
                elseif($numero == 13){
                    $control1 = 60;$control2 = 60;
                }
            }

            // Ordena el array de menor a mayor
            sort($cartones[$fila]);
        }
    }
}


/* -------------------------------------------------------------------------------------------------------- */

/* COMIENZO DEL JUEGO */

$seguir = true;
$ganador = -1;
$arrayImpresionBolas = array();

$numerosEliminados = range(1, 60);
shuffle($numerosEliminados);
while ($seguir)
{
    for ($j = 1; $j <= $numJugadores; $j++)
        eliminarNumero(${$nombreJugador.$j}, $numerosEliminados[0], $aciertosBingo, $j);
    array_push($arrayImpresionBolas, $numerosEliminados[0] );
    array_shift($numerosEliminados);
    $ganador = comprobarBingo($aciertosBingo, $numJugadores);
    if(is_array($ganador))
        $seguir = false;
}

for ($i=1; $i <= $numJugadores; $i++) { 
    mostrarCartones($i, ${$nombreJugador.$i}, $cartonesPorJugador );
}

mostrarBolas($arrayImpresionBolas);
saberGanadores($ganador, $cartonesPorJugador);

?>
</BODY>
</HTML>