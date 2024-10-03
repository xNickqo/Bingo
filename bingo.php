<HTML>
<HEAD><TITLE>Bingo</TITLE></HEAD>
<BODY>
<?php

include 'bingo_functions.php';

// Definimos el número de jugadores y cartones por jugador
$numJugadores = 3;
$cartonesPorJugador = 2;

// Creación de la estructura de datos de los jugadores
$nombreJugador = "j";
for($i=1 ; $i<=$numJugadores ; $i++) {
    ${$nombreJugador.$i} = array(("Jugador ".$i) => array(array(), array())); 
}

// Inicialización de aciertos
$aciertosBingo = array();
for ($i = 1; $i <= $numJugadores; $i++) {
    $aciertosBingo["Jugador $i"] = array_fill(0, $cartonesPorJugador, 0);
}

// Creación de los cartones de cada jugador 
for ($j = 1; $j <= $numJugadores ; $j++)
{ 
    $jugadorActual = &${$nombreJugador.$j};

    foreach($jugadorActual as $jugador => &$cartones)
    {
        for ($fila=0; $fila < $cartonesPorJugador; $fila++)
        {
            // Rellena el array con 60 posiciones en false
            $numerosRepetidos = array_fill(0, 60, false);

            $control1 = 1;
            $control2 = 9;

            // Generación de 15 números aleatorios para cada cartón
            for ($numero=0; $numero < 15; $numero++)
            { 
                $repetir = false;
                
                do {
                    // Generamos un número aleatorio en el rango correspondiente
                    $num = rand($control1, $control2);

                    // Si no se ha repetido, lo agregamos al cartón
                    if ($numerosRepetidos[$num-1] == false)
                    {
                        $cartones[$fila][$numero] = $num;

                        // Marcamos el número como utilizado
                        $numerosRepetidos[$num-1] = true;

                        $repetir = false;
                    }
                    else
                    {
                        // Si se repite, repetimos la operación
                        $repetir = true;
                    }
                } while ($repetir);

                // Filtro
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

/* Comienzo del juego */

$hayBingo = false;
$ganador = -1;
$arrayImpresionBolas = array();

$numerosEliminados = range(1, 60);
shuffle($numerosEliminados);

while ($hayBingo == false)
{
    // Eliminamos el número de los cartones
    for ($j = 1; $j <= $numJugadores; $j++) {
        eliminarNumero(${$nombreJugador.$j}, $numerosEliminados[0], $aciertosBingo);
    }
    array_push($arrayImpresionBolas, $numerosEliminados[0]);
    array_shift($numerosEliminados);

    // Comprobamos si hay Bingo
    $ganador = comprobarBingo($aciertosBingo, $numJugadores);
    if(is_array($ganador))
        $hayBingo = true;
}

// Mostramos todos los cartones de los jugadores
for ($i=1; $i <= $numJugadores; $i++) { 
    mostrarCartones($i, ${$nombreJugador.$i}, $cartonesPorJugador );
}

// Mostramos las bolas que han salido en orden
mostrarBolas($arrayImpresionBolas);

// Anunciamos a los ganadores
saberGanadores($ganador, $cartonesPorJugador);

?>
</BODY>
</HTML>
