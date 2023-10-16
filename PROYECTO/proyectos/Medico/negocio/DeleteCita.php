<?php

namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class DeleteCita
{
    private $consulta;

    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    public function eliminarCita()
    {
        if (isset($_POST['id_cita'])) {
            $idCita = $_POST['id_cita'];

            $consulta = $this->consulta;
            $resultado = $consulta->eliminarCita($idCita);

            if ($resultado === true) {
                // Si la eliminación fue exitosa, redireccionar a la página deseada
                echo '<script>alert("Cita eliminada correctamente."); window.location.href = "../presentacion/admin.php";</script>';
                exit();
            } else {
                // Si ocurrió un error, mostrar mensaje de error o hacer cualquier otra acción
                echo "Error al eliminar la cita: " . $resultado;
            }
        }
    }
}

$consulta = new \Datos\Consulta();
$deleteCita = new \Negocio\DeleteCita($consulta);
$deleteCita->eliminarCita();