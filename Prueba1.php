<?php
//1. VividSeats
// Función para obtener el contenido HTML de una URL
function obtener_contenido_url($url) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $contenido = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    }

    curl_close($ch);

    return $contenido;
}

// Función para analizar las entradas disponibles en "VividSeats"
function analizar_vividseats($url) {
    $html = obtener_contenido_url($url);

    if (!$html) {
        return;
    }

    // Mostrar el HTML (para depuración)
    
    // Expresiones regulares para buscar sectores, filas y precios
    preg_match_all('/"section":"(.*?)"/', $html, $sectors);
    preg_match_all('/"row":"(.*?)"/', $html, $rows);
    preg_match_all('/"price":(\d+(\.\d+)?)/', $html, $prices);

    if (empty($sectors[1]) || empty($rows[1]) || empty($prices[1])) {
        echo "No se encontraron entradas disponibles.";
        return;
    }

    echo "<h2>Entradas Disponibles:</h2>";
    echo "<table border='1'>
            <tr>
                <th>Sector</th>
                <th>Fila</th>
                <th>Precio</th>
            </tr>";

    // Iterar y mostrar las entradas
    for ($i = 0; $i < count($sectors[1]); $i++) {
        echo "<tr>
                <td>{$sectors[1][$i]}</td>
                <td>{$rows[1][$i]}</td>
                <td>\${$prices[1][$i]}</td>
              </tr>";
    }

    echo "</table>";
}

// URL del ejemplo del evento de VividSeats
$url_evento = 'https://www.vividseats.com/real-madrid-tickets-estadio-santiago-bernabeu-12-22-2024--sports-soccer/production/5045935';

// Llamar a la función para analizar el evento
analizar_vividseats($url_evento);

?>
