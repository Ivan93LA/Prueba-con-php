<?php
//2. SeatGeek
// Función para obtener el contenido HTML de una URL usando curl (igual que antes)
function obtener_contenido_url($url) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); // esta línea en stackOverFlow sugerían añadirla
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

// Función para analizar las entradas disponibles en SeatGeek
function analizar_seatgeek($url) {
    $html = obtener_contenido_url($url);

    if (!$html) {
        return;
    }

    // Mostrar el HTML para inspección (opcional)
   
    preg_match_all('/"section":"(.*?)"/', $html, $sectors);
    preg_match_all('/"row":"(.*?)"/', $html, $rows);
    preg_match_all('/"price":(\d+(\.\d+)?)/', $html, $prices);

    if (empty($sectors[1]) || empty($rows[1]) || empty($prices[1])) {
        echo "No se encontraron entradas disponibles.";
        return;
    }

    echo "<h2>Entradas Disponibles en SeatGeek:</h2>";
    echo "<table border='1'>
            <tr>
                <th>Sector</th>
                <th>Fila</th>
                <th>Precio</th>
            </tr>";

   
    for ($i = 0; $i < count($sectors[1]); $i++) {
        echo "<tr>
                <td>{$sectors[1][$i]}</td>
                <td>{$rows[1][$i]}</td>
                <td>\${$prices[1][$i]}</td>
              </tr>";
    }
    echo "</table>";
}

$url_evento_seatgeek = 'https://seatgeek.com/taylor-swift-tickets/toronto-canada-rogers-centre-2024-11-15-7-pm/concert/6109452';
analizar_seatgeek($url_evento_seatgeek);
?>
