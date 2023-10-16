<?php
namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class InsertCita {
    private $consulta;

    public function __construct(Consulta $consulta) {
        $this->consulta = $consulta;
    }

    public function insertarRegistroC() {
        if (isset($_POST['guardar_cita'])) {
            if (
                isset($_POST['busqueda_paciente']) &&
                isset($_POST['fecha_cita']) &&
                isset($_POST['hora_cita']) &&
                isset($_POST['motivo_consulta'])
            ) {
                $nombrePaciente = $_POST['busqueda_paciente'];

                // Obtener la instancia de la clase Consulta
                $consulta = $this->consulta;

                // Buscar el ID del paciente por su nombre utilizando la función en Consulta.php
                $idPaciente = $consulta->buscarIdPacientePorNombre($nombrePaciente);

                if ($idPaciente) {
                    // Si se encontró el ID del paciente, obtener los otros datos del formulario
                    $fechaCita = $_POST['fecha_cita'];
                    $horaCita = $_POST['hora_cita'];
                    $motivoConsulta = $_POST['motivo_consulta'];
                    $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

                    // Llamar al método insertarRegistroC() en Consulta.php para guardar la cita
                    $consulta->insertarRegistroC($idPaciente, $fechaCita, $horaCita, $motivoConsulta, $observaciones);

                    // Redireccionar a admin.php o mostrar un mensaje de éxito (opcional)
                    echo '<script>alert("Cita registrada correctamente."); window.location.href = "../presentacion/admin.php";</script>';
                    exit();
                } else {
                    // Si no se encontró el ID del paciente, mostrar un mensaje de error (opcional)
                    echo '<script>alert("No se encontró el paciente con ese nombre en la base de datos."); window.location.href = "../presentacion/admin.php";</script>';

                }
            }
        }
    }
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase InsertCita y llamar al método insertarRegistroC()
$insertCita = new InsertCita($consulta);
$insertCita->insertarRegistroC();
?>
