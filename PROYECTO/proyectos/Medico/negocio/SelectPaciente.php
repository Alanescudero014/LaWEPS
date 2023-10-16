<?php
namespace Negocio;
use Datos\Consulta;
// Incluir el archivo de la clase Consulta
include_once "../datos/consulta.php";

class SelectPaciente {
    private $consulta;

    public function __construct(Consulta $consulta) {
        $this->consulta = $consulta;
    }

    public function mostrarRegistrosP() {
        return $this->consulta->mostrarRegistrosP();
    }

    public function buscarPacientePorNombre($nombrePaciente) {
        // Obtener la instancia de la clase Consulta
        $consulta = $this->consulta;

        // Obtener el paciente por su nombre
        $paciente = $consulta->buscarPacientePorNombre($nombrePaciente);

        return $paciente;
    }
}

// Solo realizamos la búsqueda si se envió el formulario
if (isset($_POST['busqueda_paciente'])) {
    $nombrePaciente = $_POST['busqueda_paciente'];
    $consulta = new Consulta();
    $selectPaciente = new SelectPaciente($consulta);
    $paciente = $selectPaciente->buscarPacientePorNombre($nombrePaciente);
}
?>
