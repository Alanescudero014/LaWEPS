<!DOCTYPE html>
<html>
<head>
    <title>Cifrado César</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="estilos.css" rel="stylesheet">
    <script>
        function limpiarCampos() {
            document.getElementById('mensaje').value = '';
            document.getElementById('desplazamiento').value = '';
            document.getElementById('resultado').innerHTML = '';
        }
    </script>
    <style>
        .uno{
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            text-align: center;
            width: 50%;
            height: 80%;
            border-radius: 30px;
            background:rgba(0, 0, 0, 0.45);
            color: #fff;
        }
        body{
            background-image: url('cesar.jpg');
            background-size: 100% 100%;
            background-repeat:no-repeat;
            background-size: cover;
        }
        h1{
            color: white;
            padding: 2rem;
        }
        input{
            background:rgba(0, 0, 0, 0.45);
            color: white;
            border: none;
            border-radius: 40px;
        }
    </style>
</head>
<body>
    <h1><center>CIFRADO DE CÉSAR</center></h1>
    <div class="uno">

        <form method="post">
            <label for="mensaje"><b>Mensaje:</b></label><br>
            <input type="text" name="mensaje" id="mensaje" style="width: 70%" required><br><br>
            <label for="desplazamiento"><b>Desplazamiento:</b></label><br>
            <input type="number" name="desplazamiento" id="desplazamiento" min="1" required><br><br>
            <button type="submit" name="cifrar" class="glow-on-hover">Cifrar</button>
            <button type="submit" name="descifrar" class="glow-on-hover">Descifrar</button>
            <button type="button" onclick="limpiarCampos()" class="glow-on-hover">Borrar campos</button>
        </form>

        <br>

        <div id="resultado">
        <?php
// Función para cifrar o descifrar el mensaje
function cifrarMensaje($mensaje, $desplazamiento) {
    $resultado = ""; // Variable para almacenar el resultado cifrado o descifrado
    $mensaje = mb_strtoupper($mensaje, 'UTF-8'); // Convertir el mensaje a mayúsculas
    $alfabeto = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ'; // Alfabeto utilizado para el cifrado o descifrado

    // Recorrer cada carácter del mensaje
    for ($i = 0; $i < mb_strlen($mensaje, 'UTF-8'); $i++) {
        $caracter = mb_substr($mensaje, $i, 1, 'UTF-8'); // Obtener el carácter actual del mensaje

        // Verificar si el carácter está en el alfabeto
        if (mb_strpos($alfabeto, $caracter, 0, 'UTF-8') !== false) {
            $indice = mb_strpos($alfabeto, $caracter, 0, 'UTF-8'); // Obtener el índice del carácter en el alfabeto
            $nuevoIndice = ($indice + $desplazamiento) % mb_strlen($alfabeto, 'UTF-8'); // Calcular el nuevo índice aplicando el desplazamiento

            $caracterCifrado = mb_substr($alfabeto, $nuevoIndice, 1, 'UTF-8'); // Obtener el carácter cifrado o descifrado
            $resultado .= $caracterCifrado; // Agregar el carácter al resultado
        } else {
            $resultado .= $caracter; // Mantener el carácter original si no está en el alfabeto
        }
    }

    return $resultado; // Devolver el mensaje cifrado o descifrado
}

// Verificar si se envió el formulario para cifrar
if (isset($_POST['cifrar'])) {
    $mensaje = $_POST['mensaje'];
    $desplazamiento = $_POST['desplazamiento'];

    // Cifrar el mensaje con el desplazamiento especificado
    $mensajeCifrado = cifrarMensaje($mensaje, $desplazamiento);

    echo "Mensaje cifrado: " . $mensajeCifrado;
} 
// Verificar si se envió el formulario para descifrar
elseif (isset($_POST['descifrar'])) {
    $mensaje = $_POST['mensaje'];
    $desplazamiento = $_POST['desplazamiento'];

    // Descifrar el mensaje con el desplazamiento especificado
    $mensajeDescifrado = cifrarMensaje($mensaje, -$desplazamiento);

    echo "Mensaje descifrado: " . $mensajeDescifrado;
}
?>



        </div>
    </div>
    
</body>
</html>
