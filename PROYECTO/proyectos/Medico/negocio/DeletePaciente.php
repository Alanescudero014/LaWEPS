<?php
namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class DeletePaciente {
    private $consulta;

    public function __construct(Consulta $consulta) {
        $this->consulta = $consulta;
    }

    public function eliminarPaciente() {
        if (isset($_POST['id_paciente'])) {
            // Obtener el ID del paciente a eliminar
            $idPaciente = $_POST['id_paciente'];

            // Obtener la instancia de la clase Consulta
            $consulta = $this->consulta;

            // Llamar al método eliminarRegistroP() en Consulta.php para eliminar el paciente
            $resultado = $consulta->eliminarRegistroP($idPaciente);

            // Redireccionar a la página de origen o mostrar un mensaje de éxito o error (opcional)
            if ($resultado === true) {
                echo '<script>alert("Paciente eliminado correctamente."); window.location.href = "../presentacion/admin.php";</script>';
                exit();
            } else {
                echo "Error al eliminar el paciente: " . $resultado;
            }
        }
    }
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase DeletePaciente y llamar al método eliminarPaciente()
$deletePaciente = new DeletePaciente($consulta);
$deletePaciente->eliminarPaciente();
?>
