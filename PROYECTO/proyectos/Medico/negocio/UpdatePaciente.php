<?php

namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class UpdatePaciente
{
    private $consulta;

    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    public function actualizarPaciente()
    {
        if (
            isset($_POST['id_paciente']) &&
            isset($_POST['nombre']) &&
            isset($_POST['fecha_nacimiento']) &&
            isset($_POST['sexo']) &&
            isset($_POST['curp']) &&
            isset($_POST['telefono']) &&
            isset($_POST['correo']) &&
            isset($_POST['enfermedades_previas'])
        ) {
            echo "Alan";
            $idPaciente = $_POST['id_paciente'];
            $nombre = $_POST['nombre'];
            $fechaNacimiento = $_POST['fecha_nacimiento'];
            $sexo = $_POST['sexo'];
            $curp = $_POST['curp'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $enfermedadesPrevias = $_POST['enfermedades_previas'];

            // Realiza la validación de los datos aquí (puedes utilizar funciones como filter_var(), ctype, etc.)

            $consulta = $this->consulta;

            $resultado = $consulta->actualizarPaciente($idPaciente, $nombre, $fechaNacimiento, $sexo, $curp, $telefono, $correo, $enfermedadesPrevias);

            if ($resultado === true) {
                // La actualización fue exitosa, redireccionar al administrador
                echo '<script>alert("Paciente actualizado correctamente."); window.location.href = "../presentacion/admin.php";</script>';
                exit();
            } else {
                // Hubo un error en la actualización, mostrar mensaje de error
                echo '<script>alert("Error al actualizar el paciente: ' . $resultado . '"); window.location.href = "../presentacion/admin.php";</script>';
            }
        }
    }
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase DeletePaciente y llamar al método eliminarPaciente()
$updatePaciente = new UpdatePaciente($consulta);
$updatePaciente->actualizarPaciente();