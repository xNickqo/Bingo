<HTML>
<HEAD><TITLE>Bingo</TITLE></HEAD>
<BODY>
<?php

// Función para eliminar un número de los cartones y marcarlo como eliminado
function eliminarNumero(&$jugadores, $numeroAEliminar, &$aciertosBingo)
{
    // Recorremos todos los jugadores y sus cartones
    foreach ($jugadores as $jugador => &$cartones)
    {
        $indiceCartones = 0;

        // Recorremos cada cartón del jugador
        foreach ($cartones as &$fila)
        {
            // Recorremos cada número del cartón
            foreach ($fila as $key => $numero)
            {
                // Si el número coincide con el que vamos a eliminar
                if ($numero == $numeroAEliminar)
                {
                    // Reemplazamos el número por un array indicando que ha sido eliminado
                    $fila[$key] = array('numero' => $numero, 'eliminado' => true);

                    // Incrementamos el contador de aciertos para este cartón
                    $aciertosBingo[$jugador][$indiceCartones] += 1;
                }
            } 
            $indiceCartones += 1;
        }
    }
}

// Función para comprobar si algún jugador ha ganado (ha completado un cartón)
function comprobarBingo(&$aciertosBingo, $numJugadores)
{
    $devueto = array();
    $hayBingo = false;
    
    // Recorremos los aciertos de cada jugador
    foreach ($aciertosBingo as $jugador => &$carton) 
    {
        // Recorremos cada cartón del jugador
        for ($i=0; $i < count($carton); $i++)
        {
            // Si un cartón tiene 15 aciertos, es bingo
            if (isset($carton[$i]) && $carton[$i] == 15)
            {
                $hayBingo = true;

                // Guardamos al ganador y su cartón
                $devuelto[$jugador][$i]= true;
            }
        }
    }

    // Si hay un ganador, lo devolvemos; de lo contrario, devolvemos -1
    if($hayBingo)
        return $devuelto;
    else
        return -1;
}

// Función para mostrar las bolas que han salido
function mostrarBolas($numerosEliminados)
{
    echo "<b  style=\"padding-left:31vw;\" >BOLAS QUE HAN SALIDO </b><br/>";
    echo "<div style=\"border: 1px solid black;float:right; border-radius: 2vw; width:55%;\">"; 
    foreach ($numerosEliminados as $num) {
        echo "<img src=\"images/".($num.".PNG") ."\" width=\"50\" heigth=\"42\" style=\"visibility:visible;padding:1vw;\" />";        
    }
    echo "</div>";
}

// Función para imprimir una casilla del cartón, indicando si está eliminada
function imprimirCasilla($numero)
{
    $linea = "";

    // Si el número está eliminado, lo mostramos en rojo, sino lo mostramos normal
    if (is_array($numero) && isset($numero['eliminado']) && $numero['eliminado'])
        $linea = "<p style='background-color:red'>" . $numero['numero'] . "</p>";
    else
        $linea = $numero;

    return $linea;
}

// Función para mostrar los cartones de cada jugador
function mostrarCartones($numJugadores, $jug, $cartonesPorJugador)
{
    echo "<div style='float:left;padding-left:1vw;'>";
    foreach($jug as $jugador => $cartones)
    {
        echo "<h3>Jugador: $numJugadores</h3>";

        // Recorremos los cartones del jugador
        for ($j = 0; $j < $cartonesPorJugador; $j++)
        {
            echo "CARTÓN " . ($j + 1);
            echo "<table border='1'>";
            
            // Primera fila del cartón
            echo "<tr>";
            echo "<th>" . imprimirCasilla($cartones[$j][0]) . "</th>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "<th>" . imprimirCasilla($cartones[$j][4]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][7]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][9]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][11]) . "</th>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "</tr>";

            // Segunda fila del cartón
            echo "<tr>";
            echo "<th>" . imprimirCasilla($cartones[$j][1]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][2]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][5]) . "</th>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "<th>" . imprimirCasilla($cartones[$j][12]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][14]) . "</th>";
            echo "</tr>";

            // Tercera fila del cartón
            echo "<tr>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "<th>" . imprimirCasilla($cartones[$j][3]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][6]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][8]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][10]) . "</th>";
            echo "<th>" . imprimirCasilla($cartones[$j][13]) . "</th>";
            echo "<th class='vacio' style='background-color:lightblue'></th>";
            echo "</tr>";

            echo "</table>";
            echo "<br><br>";
        }
    }
    echo "</div>";
}

// Función para anunciar al ganador del bingo
function saberGanadores(&$ganadores, $cartonesPorJugador)
{
    print("<div style='padding-top:26vw;'></div>");
    foreach($ganadores as $jugadores => &$jugador)
    {
        // Recorremos los cartones para identificar el ganador
        for ($i=0; $i < $cartonesPorJugador; $i++)
        {
            // Si el jugador ha ganado con un cartón específico
            if(isset($jugador[$i]) && $jugador[$i] == true)
                print("<h2 style='padding-top:1vw;'>¡El ganador es el " . ($jugadores) . " con el carton " . ($i + 1) . "!</h2>");
        }
    }
}

?>
</BODY>
</HTML>