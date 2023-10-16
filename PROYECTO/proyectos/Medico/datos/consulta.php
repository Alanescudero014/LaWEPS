<?php

namespace Datos;

use mysqli;

class Consulta
{
    private static $instancia;
    private $conexion;

    public function __construct()
    {

        // Datos de conexión a la base de datos
        $host = "localhost";       // Por ejemplo, "localhost"
        $usuario = "root"; // El nombre de usuario de la base de datos
        $contrasena = ""; // La contraseña del usuario

        // Crear una conexión temporal para crear la base de datos
        $conexionTemporal = new mysqli($host, $usuario, $contrasena);

        // Verificar si hubo un error al crear la conexión temporal
        if ($conexionTemporal->connect_error) {
            die("Error de conexión temporal: " . $conexionTemporal->connect_error);
        }

        // Nombre de la base de datos
        $base_datos = "alanbd";

        // Crear la base de datos si no existe
        $queryCrearBaseDatos = "CREATE DATABASE IF NOT EXISTS $base_datos";
        if ($conexionTemporal->query($queryCrearBaseDatos) === TRUE) {
            echo '<script>alert("Base de datos creada o ya existente");</script>';
        } else {
            echo '<script>alert("Error al crear la base de datos");</script>';
        }

        // Cerrar la conexión temporal
        $conexionTemporal->close();

        // Establecer la conexión con la base de datos
        $this->conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

        // Verificar si hubo un error al establecer la conexión con la base de datos
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }



        // Crear las tablas si no existen
        $this->crearTablaUsuarios();
        $this->crearTablaPacientes();
        $this->crearTablaCitas();

        // Crear los usuarios predeterminados si no existen
        $this->crearUsuariosPredeterminados();
    }

    public static function obtenerInstancia()
    {
        if (!isset(self::$instancia)) {
            self::$instancia = new Consulta();
        }

        return self::$instancia;
    }


    private function crearUsuariosPredeterminados()
    {
        $usuariosExistentes = $this->verificarUsuariosExistentes();

        if (!$usuariosExistentes) {
            // Crear los usuarios predeterminados
            $usuariosPredeterminados = array(
                array('adminalan', '123'),
                array('secrealan', '123')
            );

            $query = "INSERT INTO usuario (nombre, contrasena) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($query);

            foreach ($usuariosPredeterminados as $usuario) {
                $stmt->bind_param("ss", $usuario[0], $usuario[1]);
                $stmt->execute();
            }

            $stmt->close();
        }
    }

    private function verificarUsuariosExistentes()
    {
        $query = "SELECT COUNT(*) AS total FROM usuario";
        $result = $this->conexion->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            $totalUsuarios = $row['total'];
            return ($totalUsuarios > 0);
        }

        return false;
    }

    public function validar($u, $c)
    {
        $query = "SELECT * FROM usuario WHERE nombre = ? AND contrasena = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ss", $u, $c);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_object();
        $stmt->close();

        return $usuario;
    }

    private function ejecutarQuery($query)
    {
        if ($this->conexion->query($query) === TRUE) {
            echo '<script>console.log("Tabla creada correctamente.")</script>';
        } else {
            $error_message = $this->conexion->error;
            echo '<script>console.log("Error al crear la tabla: ' . $error_message . '")</script>';
        }
    }


    private function crearTablaUsuarios()
    {
        $query = "CREATE TABLE IF NOT EXISTS usuario (
            id_usuario INT PRIMARY KEY AUTO_INCREMENT,
            nombre VARCHAR(50) NOT NULL,
            contrasena VARCHAR(50) NOT NULL
        )";

        $this->ejecutarQuery($query);
    }

    private function crearTablaPacientes()
    {
        $query = "CREATE TABLE IF NOT EXISTS paciente (
            id_paciente INT PRIMARY KEY AUTO_INCREMENT,
            nombre VARCHAR(100) NOT NULL,
            fecha_nacimiento DATE NOT NULL,
            sexo VARCHAR(10) NOT NULL,
            curp VARCHAR(18) NOT NULL,
            telefono VARCHAR(15) NOT NULL,
            correo VARCHAR(100),
            enfermedades_previas TEXT
        )";

        $this->ejecutarQuery($query);
    }

    private function crearTablaCitas()
    {
        $query = "CREATE TABLE IF NOT EXISTS cita (
            id_cita INT PRIMARY KEY AUTO_INCREMENT,
            id_paciente INT NOT NULL,
            fecha DATE NOT NULL,
            hora TIME NOT NULL,
            motivo_consulta TEXT,
            observaciones TEXT,
            UNIQUE KEY unique_fecha_hora (fecha, hora),  -- Agregar restricción UNIQUE para evitar duplicados de fecha y hora
            FOREIGN KEY (id_paciente) REFERENCES paciente(id_paciente) ON DELETE CASCADE
        )";

        $this->ejecutarQuery($query);
    }

    // Dentro de la clase Consulta, agrega esta función
    public function obtenerCitasReservadas()
    {
        $query = "SELECT fecha, hora FROM cita";
        $result = $this->conexion->query($query);

        $citasReservadas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fechaHora = $row['fecha'] . ' ' . $row['hora'];
                $citasReservadas[] = $fechaHora;
            }
        }

        return $citasReservadas;
    }



    public function cerrarConexion()
    {
        $this->conexion->close();
    }


    public function mostrarRegistrosP()
    {
        $query = "SELECT * FROM paciente";
        $result = $this->conexion->query($query);

        if ($result) {
            $pacientes = array();
            while ($row = $result->fetch_assoc()) {
                $pacientes[] = $row;
            }
            return $pacientes;
        } else {
            return false;
        }
    }

    public function mostrarRegistrosC()
    {
        $query = "SELECT * FROM cita";
        $result = $this->conexion->query($query);

        if ($result) {
            $pacientes = array();
            while ($row = $result->fetch_assoc()) {
                $pacientes[] = $row;
            }
            return $pacientes;
        } else {
            return false;
        }
    }

    public function insertarRegistroP($nombre, $fechaNacimiento, $sexo, $curp, $telefono, $correo, $enfermedadesPrevias)
    {
        $sql = "INSERT INTO paciente (nombre, fecha_nacimiento, sexo, curp, telefono, correo, enfermedades_previas) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $fechaNacimiento, $sexo, $curp, $telefono, $correo, $enfermedadesPrevias);

        if ($stmt->execute()) {
            // Inserción exitosa
            $stmt->close();
            return "Registro insertado correctamente.";
        } else {
            // Error en la inserción
            echo "Error al insertar el registro: " . $stmt->error;
        }

        $stmt->close();
    }

    public function insertarRegistroC($idPaciente, $fechaCita, $horaCita, $motivoConsulta, $observaciones)
    {

        // Insertar la cita en la base de datos
        $sql = "INSERT INTO cita (id_paciente, fecha, hora, motivo_consulta, observaciones) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("issss", $idPaciente, $fechaCita, $horaCita, $motivoConsulta, $observaciones);

        if ($stmt->execute()) {
            // Inserción exitosa
            $stmt->close();
            echo '<script>alert("Cita registrada correctamente."); window.location.href = "../presentacion/admin.php";</script>';
        } else {
            // Error en la inserción
            echo "Error al insertar la cita: " . $stmt->error;
        }

        $stmt->close();
    }

    public function buscarIdPacientePorNombre($nombrePaciente)
    {
        // Preparar la consulta SQL para obtener el ID del paciente a partir del nombre
        $query = "SELECT id_paciente FROM paciente WHERE nombre LIKE ?";

        // Agregar comodines '%' al nombre para hacer la consulta más flexible
        $nombreBusqueda = '%' . $nombrePaciente . '%';

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar el parámetro de búsqueda al marcador de posición en la consulta
        $stmt->bind_param("s", $nombreBusqueda);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener el ID del paciente
        $idPaciente = null;
        if ($row = $result->fetch_assoc()) {
            $idPaciente = $row['id_paciente'];
        }

        // Retornar el ID del paciente encontrado o null si no se encontró
        return $idPaciente;
    }


    public function buscarCitaPorNombre($nombre)
    {
        // Preparar la consulta SQL con una subconsulta para obtener el id_paciente a partir del nombre
        $query = "SELECT * FROM cita WHERE id_paciente IN (SELECT id_paciente FROM paciente WHERE nombre LIKE ?)";

        // Agregar comodines '%' al nombre para hacer la consulta más flexible
        $nombreBusqueda = '%' . $nombre . '%';

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Asociar el parámetro de búsqueda al marcador de posición en la consulta
        $stmt->bind_param("s", $nombreBusqueda);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Crear un arreglo para almacenar las citas encontradas
        $citas = array();

        // Recorrer los resultados y agregarlos al arreglo de citas
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }

        // Cerrar la sentencia
        $stmt->close();

        // Devolver los datos en formato JSON
        return json_encode($citas);
    }

    public function obtenerPacientePorId($idPaciente)
    {
        // Preparar la consulta SQL para obtener los datos del paciente por su ID
        $query = "SELECT * FROM paciente WHERE id_paciente = ?";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar el parámetro del ID del paciente al marcador de posición en la consulta
        $stmt->bind_param("i", $idPaciente);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener los datos del paciente
        $paciente = null;
        if ($row = $result->fetch_assoc()) {
            $paciente = $row;
        }

        return $paciente;
    }

    public function buscarPacientePorNombre($nombrePaciente)
    {
        // Preparar la consulta SQL con una subconsulta para obtener el id_paciente a partir del nombre
        $query = "SELECT * FROM paciente WHERE nombre LIKE ?";

        // Agregar comodines '%' al nombre para hacer la consulta más flexible
        $nombreBusqueda = '%' . $nombrePaciente . '%';

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Asociar el parámetro de búsqueda al marcador de posición en la consulta
        $stmt->bind_param("s", $nombreBusqueda);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Crear un arreglo para almacenar los pacientes encontrados
        $pacientes = array();

        // Recorrer los resultados y agregarlos al arreglo de pacientes
        while ($row = $result->fetch_assoc()) {
            $pacientes[] = $row;
        }

        // Cerrar la sentencia
        $stmt->close();

        // Devolver los datos en formato JSON
        return json_encode($pacientes);
    }


    public function eliminarRegistroP($idPaciente)
    {
        // Preparar la consulta SQL para eliminar el paciente con el ID proporcionado
        $query = "DELETE FROM paciente WHERE id_paciente = ?";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar el parámetro de ID del paciente al marcador de posición en la consulta
        $stmt->bind_param("i", $idPaciente);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, retornar true para indicar éxito
            return true;
        } else {
            // Si ocurre algún error durante la ejecución de la consulta, retornar el mensaje de error
            return "Error al eliminar el paciente: " . $stmt->error;
        }
    }

    public function actualizarPaciente($idPaciente, $nombre, $fechaNacimiento, $sexo, $curp, $telefono, $correo, $enfermedadesPrevias)
    {
        // Preparar la consulta SQL para actualizar el paciente con el ID proporcionado
        $query = "UPDATE paciente SET nombre = ?, fecha_nacimiento = ?, sexo = ?, curp = ?, telefono = ?, correo = ?, enfermedades_previas = ? WHERE id_paciente = ?";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar los parámetros de actualización al marcador de posición en la consulta
        $stmt->bind_param("sssssssi", $nombre, $fechaNacimiento, $sexo, $curp, $telefono, $correo, $enfermedadesPrevias, $idPaciente);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, retornar true para indicar éxito
            return true;
        } else {
            // Si ocurre algún error durante la ejecución de la consulta, retornar el mensaje de error
            return "Error al actualizar el paciente: " . $stmt->error;
        }
    }

    public function eliminarCita($idCita)
    {
        // Preparar la consulta SQL para eliminar la cita con el ID proporcionado
        $query = "DELETE FROM cita WHERE id_cita = ?";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar el parámetro de ID de la cita al marcador de posición en la consulta
        $stmt->bind_param("i", $idCita);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, retornar true para indicar éxito
            return true;
        } else {
            // Si ocurre algún error durante la ejecución de la consulta, retornar el mensaje de error
            return "Error al eliminar la cita: " . $stmt->error;
        }
    }

    public function actualizarCita($id_cita, $id_paciente, $fecha, $hora, $motivoConsulta, $observaciones)
    {
        // Preparar la consulta SQL para actualizar la cita con el ID proporcionado
        $query = "UPDATE cita SET id_paciente = ?, fecha = ?, hora = ?, motivo_consulta = ?, observaciones = ? WHERE id_cita = ?";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        // Asociar los parámetros de actualización al marcador de posición en la consulta
        $stmt->bind_param("issssi", $id_paciente, $fecha, $hora, $motivoConsulta, $observaciones, $id_cita);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, retornar true para indicar éxito
            return true;
        } else {
            // Si ocurre algún error durante la ejecución de la consulta, retornar el mensaje de error
            return "Error al actualizar la cita: " . $stmt->error;
        }
    }
}
