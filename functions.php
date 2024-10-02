<?php

function eliminarNumero(&$jugadores, $numeroAEliminar, &$aciertosBingo, $indice)
{
    $nombreJugador = "Jugador ";
    foreach ($jugadores as $jugador => &$cartones)
    {
        $indiceCartones = 0;
        foreach ($cartones as &$fila)
        {
            foreach ($fila as $key => $numero)
            {
                if ($numero == $numeroAEliminar)
                {
                    $fila[$key] = array('numero' => $numero, 'eliminado' => true);
                    $aciertosBingo[$jugador][$indiceCartones] += 1;
                }
            } 
            $indiceCartones += 1;
        }
    }
}

function comprobarBingo(&$aciertosBingo, $numJugadores)
{
    $devueto = array();
    $hayBingo = false;
    
    foreach ($aciertosBingo as $jugador => &$carton) 
    {
        for ($i=0; $i < count($carton); $i++)
        { 
            if (isset($carton[$i]) && $carton[$i] == 15)
            {
                $hayBingo = true;
                $devuelto[$jugador][$i]= true;
            }
        }
    }
    if($hayBingo)
        return $devuelto;
    else
        return -1;
}

function mostrarBolas($numerosEliminados)
{
    echo "<b  style=\"padding-left:31vw;\" >BOLAS QUE HAN SALIDO </b><br/>";
    echo "<div style=\"border: 1px solid black;float:right; border-radius: 2vw; width:55%;\">"; 
    foreach ($numerosEliminados as $num) {
        echo "<img src=\"images/".($num.".PNG") ."\" width=\"50\" heigth=\"42\" style=\"visibility:visible;padding:1vw;\" />";        
    }
    echo "</div>";
}

function imprimirCasilla($numero)
{
    $linea = "";

    // Comprueba que 'numero' sea un array, que dentro de ese array haya una key llamada 'eliminado' y comprueba que ese valor sea 'true'
    if (is_array($numero) && isset($numero['eliminado']) && $numero['eliminado'])
        $linea = "<p style='background-color:red'>" . $numero['numero'] . "</p>";
    else
        $linea = $numero;

    return $linea;
}

function mostrarCartones($numJugadores, $jug, $cartonesPorJugador)
{
    echo "<div style='float:left;padding-left:1vw;'>";
    foreach($jug as $jugador => $cartones)
    {
        echo "<h3>Jugador: $numJugadores</h3>";
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

function saberGanadores(&$ganadores, $cartonesPorJugador)
{
    print("<div style='padding-top:26vw;'></div>");
    foreach($ganadores as $jugadores => &$jugador)
    { 
        for ($i=0; $i < $cartonesPorJugador; $i++)
        { 
            if(isset($jugador[$i]) && $jugador[$i] == true)
                print("<h2 style='padding-top:1vw;'>¡El ganador es el " . ($jugadores) . " con el carton " . ($i + 1) . "!</h2>");
        }
    }
}
?>
