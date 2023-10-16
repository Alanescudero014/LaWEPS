<?php

namespace Presentacion;

use Datos\Consulta;


include_once "../datos/consulta.php";
include_once "../negocio/SelectPaciente.php";
include_once "../negocio/InsertPaciente.php";
include_once "../negocio/UpdatePaciente.php";
include_once "../negocio/DeletePaciente.php";
include_once "../negocio/SelectCita.php";
include_once "../negocio/InsertCita.php";
include_once "../negocio/UpdateCita.php";
include_once "../negocio/DeleteCita.php";


session_start();

$nombre = $_SESSION['nombre'];

if ($nombre == 'secrealan') {
    header('Location: secre.php');
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase SelectPaciente
$selectPaciente = new \Negocio\SelectPaciente($consulta);

// Llamar a la función mostrarRegistrosP() para obtener los pacientes
$pacientes = $selectPaciente->mostrarRegistrosP();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <title>Médico</title>
    <style>
        .content-container {
            max-width: 800px;
            /* Ancho máximo deseado para el contenido */
            margin: 0 auto;
            /* Centrar el contenido horizontalmente */
            padding: 20px;
            /* Espaciado interno para el contenido */
        }

        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            display: none;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 100%;
            height: 80%;
            border-radius: 30px;
        }

        .form-container2 {
            display: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Convertir el contenedor en un contenedor flexible */
            justify-content: center;
            text-align: center;
            /* Espaciado entre las dos columnas */
            margin: 0 auto;
        }

        .form-container2>div {
            flex: 1;
            /* Que cada columna ocupe la mitad del espacio disponible */
            padding: 10px;
            /* Espaciado interno opcional para separar los elementos */
            box-sizing: border-box;
            /* Incluir el padding en el tamaño total del elemento */
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container select {
            /* Estilos para los inputs de tipo texto, email y select */
            display: block;
            width: auto;
            margin: auto;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container input[type="submit"] {
            /* Estilos para el botón de tipo submit */
            background-color: #4CAF50;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            /* Estilos al pasar el cursor sobre el botón */
            background-color: #45a049;
        }


        h1,
        h2,
        label {
            margin: 20px 0;
            color: white;
        }

        a {
            color: white;
        }

        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .black {
            background-color: #212121;
            color: white;
            border: none;
        }

        .menu a {
            display: block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            background-color: #000;
        }

        .menu a:hover {
            color: black;
            background-color: white;
        }


        .submenu {
            display: none;
            flex-direction: column;
            gap: 10px;
            padding-left: 40px;
        }

        .menu-item:hover .submenu {
            display: flex;
        }

        .parent {
            max-width: 1000px;
            /* Ancho máximo deseado para el contenido */
            margin: 0 auto;
            /* Centrar el contenido horizontalmente */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            /* Espaciado superior entre las tablas */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        textarea {
            height: 85px;
            width: 100%;
            border: none;
            outline: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        select {
            border: none;
            outline: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        option {
            background-color: black;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Obtener la lista de pacientes para el autocompletado
            var pacientes = <?php echo json_encode($pacientes); ?>;
            var pacientesAutocompletado = {};

            pacientes.forEach(function(paciente) {
                pacientesAutocompletado[paciente.nombre] = paciente.id_paciente;
            });

            // Configurar el autocompletado para el primer campo de búsqueda de pacientes
            $("#busqueda_paciente_1").autocomplete({
                source: Object.keys(pacientesAutocompletado),
                select: function(event, ui) {
                    // Cuando se selecciona un paciente, establecer su ID en el campo oculto
                    $("#id_paciente_1").val(pacientesAutocompletado[ui.item.value]);
                }
            });

            // Configurar el autocompletado para el segundo campo de búsqueda de pacientes
            $("#busqueda_paciente_2").autocomplete({
                source: Object.keys(pacientesAutocompletado),
                select: function(event, ui) {
                    // Cuando se selecciona un paciente, establecer su ID en el campo oculto
                    $("#id_paciente_2").val(pacientesAutocompletado[ui.item.value]);
                }
            });

            // Configurar el autocompletado para el tercer campo de búsqueda de pacientes
            $("#busqueda_paciente_3").autocomplete({
                source: Object.keys(pacientesAutocompletado),
                select: function(event, ui) {
                    // Cuando se selecciona un paciente, establecer su ID en el campo oculto
                    $("#id_paciente_3").val(pacientesAutocompletado[ui.item.value]);
                }
            });

            // Configurar el autocompletado para el segundo campo de búsqueda de pacientes
            $("#busqueda_paciente_4").autocomplete({
                source: Object.keys(pacientesAutocompletado),
                select: function(event, ui) {
                    // Cuando se selecciona un paciente, establecer su ID en el campo oculto
                    $("#id_paciente_4").val(pacientesAutocompletado[ui.item.value]);
                }
            });

            // Configurar el autocompletado para el tercer campo de búsqueda de pacientes
            $("#busqueda_paciente_5").autocomplete({
                source: Object.keys(pacientesAutocompletado),
                select: function(event, ui) {
                    // Cuando se selecciona un paciente, establecer su ID en el campo oculto
                    $("#id_paciente_5").val(pacientesAutocompletado[ui.item.value]);
                }
            });
        });
    </script>
</head>

<body>
    <h1>
        <center>MÉDICO</center>
    </h1>


    <div class="menu">
        <div class="menu-item">
            <a href="admin.php">Pacientes</a>
            <div class="submenu">
                <a href="#" onclick="mostrarForm('MostrarCliente'); ocultarTabla();">Buscar</a>
                <a href="#" onclick="mostrarForm('AltaCliente'); ocultarTabla();">Alta</a>
                <a href="#" onclick="mostrarForm('BajaCliente'); ocultarTabla();">Baja</a>
                <a href="#" onclick="mostrarForm('ActualizarCliente'); ocultarTabla();">Actualizar</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="admin.php">Citas</a>
            <div class="submenu">
                <a href="#" onclick="mostrarForm('MostrarCita'); ocultarTabla();">Buscar</a>
                <a href="#" onclick="mostrarForm('AltaCita'); ocultarTabla();">Alta</a>
                <a href="#" onclick="mostrarForm('BajaCita'); ocultarTabla();">Baja</a>
                <a href="#" onclick="mostrarForm('ActualizarCita'); ocultarTabla();">Actualizar</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="salir.php">Salir</a>
        </div>
    </div>

    <!-- Formularios para cada opción -->
    <div class="parent">

        <div class="form-container" id="formMostrarCliente">
            <h2>Pacientes</h2>

            <tbody>
                <?php
                // Llamar a la clase selectPaciente para obtener los datos de los pacientes
                include_once "../negocio/SelectPaciente.php";
                // Crear una instancia de la clase Consulta
                // Crear una instancia de la clase SelectPaciente
                $selectPaciente = new \Negocio\SelectPaciente(new \Datos\Consulta());


                // Llamar a la función mostrarRegistrosP() para obtener los pacientes
                $pacientes = $selectPaciente->mostrarRegistrosP();

                // Mostrar los pacientes en una tabla
                echo '<table class="table table-bordered table-dark">';
                echo '<tr><th>ID</th><th>Nombre</th><th>Fecha de Nacimiento</th><th>Sexo</th><th>CURP</th><th>Teléfono</th><th>Correo</th><th>Enfermedades Previas</th></tr>';
                foreach ($pacientes as $paciente) {
                    echo '<tr>';
                    echo '<td>' . $paciente['id_paciente'] . '</td>';
                    echo '<td>' . $paciente['nombre'] . '</td>';
                    echo '<td>' . $paciente['fecha_nacimiento'] . '</td>';
                    echo '<td>' . $paciente['sexo'] . '</td>';
                    echo '<td>' . $paciente['curp'] . '</td>';
                    echo '<td>' . $paciente['telefono'] . '</td>';
                    echo '<td>' . $paciente['correo'] . '</td>';
                    echo '<td>' . $paciente['enfermedades_previas'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

                // Cerrar la conexión después de usarla
                $consulta->cerrarConexion();
                ?>
            </tbody>
        </div>
        <div>
            <form class="form-container2" id="formAltaCliente" style="display: none;" action="../negocio/InsertPaciente.php" method="POST">
                <h2>Alta de Paciente</h2>
                <div class="input-field">
                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="input" placeholder="Nombre" required>
                </div>
                <div class="input-field">
                    <label for="fecha_nacimiento_cliente">Fecha de Nacimiento:</label>
                    <input type="date" style="color: #fff;" class="input" id="fecha_nacimiento_cliente" name="fecha_nacimiento_cliente" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="input-field">
                    <select name="sexo_cliente" id="sexo_cliente">
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="input-field">
                    <input class="input" placeholder="Curp" type="text" id="curp_cliente" name="curp_cliente" required>
                </div>
                <div class="input-field">
                    <input type="text" class="input" placeholder="Teléfono" id="telefono_cliente" name="telefono_cliente" required>
                </div>
                <div class="input-field">
                    <input type="email" class="input" placeholder="Correo" id="correo_cliente" name="correo_cliente">
                </div>
                <div class="input-field">
                    <textarea class="textarea" placeholder="Enfermedades Previas" id="enfermedades_previas_cliente" name="enfermedades_previas_cliente" required></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>
            </form>
        </div>



        <!-- Formulario para búsqueda de paciente -->
        <form class="form-container" id="formBajaCliente" action="#tablaResultados" method="POST">
            <h2>Eliminar Paciente</h2>
            <!-- Formulario para búsqueda de paciente -->
            <label for="busqueda_paciente_1">Buscar Paciente:</label>
            <input type="text" id="busqueda_paciente_1" name="busqueda_paciente" autocomplete="off">
            <button type="submit" name="buscar_paciente" class="btn btn-outline-light">Buscar</button>
            <hr>
        </form>

        <?php
        // Verificar si se ha enviado el formulario de búsqueda
        if (isset($_POST['buscar_paciente'])) {
            $nombrePaciente = $_POST['busqueda_paciente'];
            $consulta = new \Datos\Consulta();
            $selectPaciente = new \Negocio\SelectPaciente($consulta);

            // Llamamos a la función para buscar pacientes por nombre
            $pacientesJson = $selectPaciente->buscarPacientePorNombre($nombrePaciente);
            // Decodificamos el JSON para obtener los pacientes
            $pacientes = json_decode($pacientesJson, true);

            // Mostrar los resultados en la tabla
            if ($pacientes) {
                echo '<div id="tablaCitasPacienteContainer">';
                echo '<h2>Eliminar Paciente</h2>';
                echo '<table id="tablaResultados" class="table table-bordered table-dark">';
                echo '<tr><th>ID</th><th>Nombre</th><th>Fecha de Nacimiento</th><th>Sexo</th><th>CURP</th><th>Teléfono</th><th>Correo</th><th>Enfermedades Previas</th><th>Acción</th></tr>';
                foreach ($pacientes as $paciente) {
                    echo '<tr>';
                    echo '<td>' . $paciente['id_paciente'] . '</td>';
                    echo '<td>' . $paciente['nombre'] . '</td>';
                    echo '<td>' . $paciente['fecha_nacimiento'] . '</td>';
                    echo '<td>' . $paciente['sexo'] . '</td>';
                    echo '<td>' . $paciente['curp'] . '</td>';
                    echo '<td>' . $paciente['telefono'] . '</td>';
                    echo '<td>' . $paciente['correo'] . '</td>';
                    echo '<td>' . $paciente['enfermedades_previas'] . '</td>';
                    echo '<td><form action="../negocio/DeletePaciente.php" method="POST">';
                    echo '<input type="hidden" name="id_paciente" value="' . $paciente['id_paciente'] . '">';
                    echo '<button type="submit" class="btn btn-outline-danger">Eliminar</button>';
                    echo '</form></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p>No se encontraron pacientes con ese nombre.</p>';
            }
        }
        ?>
        <script>
            function ocultarTabla() {
                document.getElementById('tablaCitasPacienteContainer').style.display = 'none';
            }
        </script>



        <form class="form-container" id="formActualizarCliente" action="#tablaResultados" method="POST">
            <h2>Actualizar Paciente</h2>
            <!-- Formulario para búsqueda de paciente -->
            <label for="busqueda_paciente_4">Buscar Paciente:</label>
            <input type="text" id="busqueda_paciente_4" name="busqueda_paciente_4" autocomplete="off">
            <button type="submit" name="buscar_paciente4" class="btn btn-outline-light">Buscar</button>
            <hr>
        </form>
        <!-- Mostrar resultados de la búsqueda en una tabla -->
        <?php
        // Verificar si se ha enviado el formulario de búsqueda
        if (isset($_POST['buscar_paciente4'])) {
            $nombrePaciente = $_POST['busqueda_paciente_4'];
            $consulta = new \Datos\Consulta();
            $selectPaciente = new \Negocio\SelectPaciente($consulta);

            // Llamamos a la función para buscar pacientes por nombre
            $pacientesJson = $selectPaciente->buscarPacientePorNombre($nombrePaciente);
            // Decodificamos el JSON para obtener los pacientes
            $pacientes = json_decode($pacientesJson, true);

            // Mostrar los resultados en la tabla
            if ($pacientes) {
                echo '<div style="width: 1300px; justify-content: center;" id="tablaCitasPacienteContainer">';
                echo '<h2>Actualizar Paciente</h2>';
                echo '<table id="tablaResultados" class="table table-bordered table-dark">';
                echo '<tr><th>ID</th><th>Nombre</th><th>Fecha de Nacimiento</th><th>Sexo</th><th>CURP</th><th>Teléfono</th><th>Correo</th><th>Enfermedades Previas</th><th>Acción</th></tr>';
                foreach ($pacientes as $paciente) {
                    echo '<form action="../negocio/UpdatePaciente.php" method="POST">';
                    echo '<tr>';
                    echo '<td><input class="black" type="text" name="id_paciente" value="' . $paciente['id_paciente'] . '" size="1" readonly></td>';
                    echo '<td><input class="black" type="text" name="nombre" value="' . $paciente['nombre'] . '" size="10" required></td>';
                    echo '<td><input class="black" type="date" name="fecha_nacimiento" value="' . $paciente['fecha_nacimiento'] . '" size="5" required></td>';
                    echo '<td><input class="black" type="text" name="sexo" value="' . $paciente['sexo'] . '" size="1" required></td>';
                    echo '<td><input class="black" type="text" name="curp" value="' . $paciente['curp'] . '" size="18" required></td>';
                    echo '<td><input class="black" type="text" name="telefono" value="' . $paciente['telefono'] . '" size="9" required></td>';
                    echo '<td><input class="black" type="mail" name="correo" value="' . $paciente['correo'] . '" size="12" required></td>';
                    echo '<td><input class="black" type="text" name="enfermedades_previas" value="' . $paciente['enfermedades_previas'] . '" size="10" required></td>';
                    echo '<td><button type="submit" class="btn btn-outline-primary">Actualizar</button>';
                    echo '</form></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p>No se encontraron pacientes con ese nombre.</p>';
            }
        }
        ?>



        <div class="form-container" id="formMostrarCita">
            <h2>Citas</h2>

            <tbody>
                <?php
                // Llamar a la clase selectPaciente para obtener los datos de los pacientes
                include_once "../negocio/SelectCita.php";
                // Crear una instancia de la clase Consulta
                // Crear una instancia de la clase SelectPaciente
                $selectCita = new \Negocio\SelectCita(new \Datos\Consulta());


                // Llamar a la función mostrarRegistrosP() para obtener los pacientes
                $citas = $selectCita->mostrarRegistrosC();

                // Mostrar los pacientes en una tabla
                echo '<table class="table table-bordered table-dark">';
                echo '<tr><th>ID</th><th>ID Paciente</th><th>Fecha</th><th>Hora</th><th>Motivo</th><th>Observaciones</th></tr>';
                foreach ($citas as $cita) {
                    echo '<tr>';
                    echo '<td>' . $cita['id_cita'] . '</td>';
                    echo '<td>' . $cita['id_paciente'] . '</td>';
                    echo '<td>' . $cita['fecha'] . '</td>';
                    echo '<td>' . $cita['hora'] . '</td>';
                    echo '<td>' . $cita['motivo_consulta'] . '</td>';
                    echo '<td>' . $cita['observaciones'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';


                ?>
            </tbody>
        </div>

        <form class="form-container2" id="formAltaCita" style="display: none;" action="../negocio/InsertCita.php" method="POST">
            <h2>Alta de Cita</h2>
            <div class="input-field">
                <input class="input" placeholder="Nombre" type="text" id="busqueda_paciente_2" name="busqueda_paciente" autocomplete="off" required>
                <input type="hidden" id="id_paciente" name="id_paciente" required>
            </div>
            <div class="input-field">
                <label for="fecha_cita">Fecha de la Cita:</label>
                <input class="input" style="color: white;" type="date" id="fecha_cita" name="fecha_cita" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="input-field"><label for="hora_cita">Hora de la Cita:</label>
                <select id="hora_cita" name="hora_cita" required>
                    <option value="10:00:00">10:00</option>
                    <option value="10:00:00">11:00</option>
                    <option value="10:00:00">12:00</option>
                    <option value="10:00:00">13:00</option>
                    <option value="10:00:00">14:00</option>
                    <option value="10:00:00">15:00</option>
                    <option value="10:00:00">16:00</option>
                    <option value="10:00:00">17:00</option>
                </select>
            </div>



            <div class="input-field">
                <textarea id="motivo_consulta" placeholder="Motivo de la Consulta" name="motivo_consulta" required></textarea>
            </div>
            <div class="input-field">
                <textarea id="observaciones" placeholder="Observaciones" name="observaciones"></textarea>
            </div>
            <div>
                <button type="submit" name="guardar_cita" class="btn btn-outline-light">Guardar</button>
            </div>
        </form>



        <!-- Formulario para eliminar cita -->
        <div id="formBajaCita" class="form-container">
            <h2>Eliminar Cita</h2>
            <form action="#tablaResultados" method="POST">
                <label for="busqueda_paciente_3">Buscar Cita:</label>
                <input type="text" name="nombre_paciente" id="busqueda_paciente_3" autocomplete="off">
                <button type="submit" name="buscar_cita" class="btn btn-outline-light">Buscar</button>
            </form>
        </div>

        <?php
        // Verificar si se ha recibido el nombre del paciente en el formulario
        if (isset($_POST['buscar_cita'])) {
            $nombrePaciente = $_POST['nombre_paciente'];


            // Crear instancias de las clases
            $consulta = new \Datos\Consulta();
            $selectCita = new \Negocio\SelectCita($consulta);

            // Llamar al método buscarCitaPorNombre en la clase SelectCita
            $jsonCitas = $selectCita->buscarCitaPorNombre($nombrePaciente);

            // Decodificar el JSON para obtener el arreglo de citas
            $citas = json_decode($jsonCitas, true);

            if ($citas) {
                echo '<div id="tablaCitasPacienteContainer">';
                echo '<h2>Eliminar Cita</h2>';
                echo '<table id="tablaResultados" class="table table-bordered table-dark">';
                echo '<tr><th>ID Cita</th><th>ID Paciente</th><th>Fecha de Cita</th><th>Hora de Cita</th><th>Motivo de Consulta</th><th>Acción</th></tr>';
                foreach ($citas as $cita) {
                    echo '<tr>';
                    echo '<td>' . $cita['id_cita'] . '</td>';
                    echo '<td>' . $cita['id_paciente'] . '</td>';
                    echo '<td>' . $cita['fecha'] . '</td>';
                    echo '<td>' . $cita['hora'] . '</td>';
                    echo '<td>' . $cita['motivo_consulta'] . '</td>';
                    echo '<td><form action="../negocio/DeleteCita.php" method="POST">';
                    echo '<input type="hidden" name="id_cita" value="' . $cita['id_cita'] . '">';
                    echo '<button type="submit" class="btn btn-outline-danger">Eliminar</button>';
                    echo '</form></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                // Si no se encontraron citas, mostrar un mensaje o hacer cualquier otra acción
                echo '<p>No se encontraron citas para el paciente.</p>';
            }
        }
        ?>


        <div class="form-container" id="formActualizarCita">
            <h2>Actualizar Cita</h2>
            <form action="#tablaResultados2" method="POST">
                <label for="busqueda_paciente_5">Nombre del paciente:</label>
                <input type="text" id="busqueda_paciente_5" name="busqueda_paciente_5" autocomplete="off">
                <button type="submit" name="buscar_cita5" class="btn btn-outline-light">Buscar Cita</button>
                <hr>
            </form>
        </div>

        <?php
        // Verificar si se ha enviado el formulario de búsqueda
        if (isset($_POST['buscar_cita5'])) {
            $nombrePaciente = $_POST['busqueda_paciente_5'];
            $consulta = new \Datos\Consulta();
            $selectCita = new \Negocio\SelectCita($consulta);

            // Llamamos a la función para buscar citas por nombre de paciente
            $citasJson = $selectCita->buscarCitaPorNombre($nombrePaciente);
            // Decodificamos el JSON para obtener las citas
            $citas = json_decode($citasJson, true);

            // Mostrar los resultados en la tabla
            if ($citas) {
                echo '<div id="tablaCitasPacienteContainer">';
                echo '<h2>Actualizar Cita</h2>';
                echo '<table id="tablaResultados" class="table table-bordered table-dark">';
                echo '<tr><th>ID Cita</th><th>ID Paciente</th><th>Fecha de Cita</th><th>Hora de Cita</th><th>Motivo de Consulta</th><th>Observaciones</th><th>Acción</th></tr>';
                foreach ($citas as $cita) {
                    echo '<form action="../negocio/UpdateCita.php" method="POST">';
                    echo '<tr>';
                    echo '<td><input class="black" type="text" name="id_cita" value="' . $cita['id_cita'] . '" size="1" readonly></td>';
                    echo '<td><input class="black" type="text" name="id_paciente" value="' . $cita['id_paciente'] . '" size="1" readonly></td>';
                    echo '<td><input class="black" type="date" name="fecha" value="' . $cita['fecha'] . '" required></td>';
                    echo '<td><select class="black" type="time" name="hora" required>
                    <option value="' . $cita['hora'] . '">' . $cita['hora'] . '</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                    </select></td>';
                    echo '<td><input class="black" type="text" name="motivo_consulta" value="' . $cita['motivo_consulta'] . '" size="15" required></td>';
                    echo '<td><input class="black" type="text" name="observaciones" value="' . $cita['observaciones'] . '" size="15" required></td>';
                    echo '<td><button type="submit" class="btn btn-outline-primary">Actualizar</button>';
                    echo '</form></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p>No se encontraron citas para el paciente.</p>';
            }
        }
        ?>


    </div>


    <script>
        // Función para mostrar el formulario correspondiente según la opción seleccionada
        function mostrarForm(opcion) {
            // Ocultar todos los formularios con las clases "form-container" y "form-container2"
            document.querySelectorAll('.form-container, .form-container2').forEach(form => form.style.display = 'none');

            // Mostrar el formulario correspondiente a la opción seleccionada
            const form = document.getElementById('form' + opcion.charAt(0).toUpperCase() + opcion.slice(1));
            if (form) {
                form.style.display = 'block';
            }
        }
    </script>


</body>

</html>