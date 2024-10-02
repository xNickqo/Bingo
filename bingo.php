<HTML>
<HEAD><TITLE>Bingo</TITLE></HEAD>
<BODY>
<?php

/* Función comprobar si el numero del carton ha sido eliminado */
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

/* Comprobar que carton es el ganador */
function comprobarBingo(&$aciertosBingo, $numJugadores)
{
    $devueto = array();
    $hayBingo = false;
    
    foreach ($aciertosBingo as $jugador => &$carton) 
    {
        for ($i=0; $i < count($carton); $i++) { 
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

/* Funcion para mostrar las bolas */
function mostrarBolas($numerosEliminados)
{
    echo "<b  style=\"padding-left:31vw;\" >BOLAS QUE HAN SALIDO </b><br/>";
    echo "<div style=\"border: 1px solid black;float:right; border-radius: 2vw; width:55%;\">"; 
    foreach ($numerosEliminados as $num) {
        echo "<img src=\"images/".($num.".PNG") ."\" width=\"50\" heigth=\"42\" style=\"visibility:visible;padding:1vw;\" />";        
    }
    echo "</div>";
}



/* Función auxiliar para imprimir casillas con o sin estilo de fondo rojo */
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

/* Funcion para imprimir todos los cartones */ 
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