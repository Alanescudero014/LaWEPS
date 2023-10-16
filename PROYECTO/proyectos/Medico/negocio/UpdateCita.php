<?php

namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class UpdateCita{
    private $consulta;

    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    public function ActualizarCita() {
        if(
            isset($_POST['id_cita']) &&
            isset($_POST['id_paciente']) &&
            isset($_POST['fecha']) &&
            isset($_POST['hora']) &&
            isset($_POST['motivo_consulta']) &&
            isset($_POST['observaciones'])
        ){
            $id_cita = $_POST['id_cita'];
            $id_paciente = $_POST['id_paciente'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo_consulta = $_POST['motivo_consulta'];
            $observaciones = $_POST['observaciones'];

            echo "Alan";
            $consulta = $this->consulta;

            $resultado = $consulta->actualizarCita($id_cita, $id_paciente, $fecha, $hora, $motivo_consulta, $observaciones);
        
            if ($resultado === true) {
                // La actualización fue exitosa, redirige a donde desees
                // Por ejemplo, puedes redirigir a la página de citas nuevamente
                echo '<script>alert("Cita actualizada correctamente."); window.location.href = "../presentacion/admin.php";</script>';
                exit();
            } else {
                // Hubo un error en la actualización, puedes mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
                echo "Error al actualizar la cita: " . $resultado;
            }
        }
    }
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase DeletePaciente y llamar al método eliminarPaciente()
$updateCita = new UpdateCita($consulta);
$updateCita->actualizarCita();