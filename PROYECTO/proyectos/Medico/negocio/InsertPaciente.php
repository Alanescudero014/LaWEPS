<?php
namespace Negocio;

use Datos\Consulta;

require_once __DIR__ . '/../Datos/Consulta.php';

class InsertPaciente {
    private $consulta;

    public function __construct(Consulta $consulta) {
        $this->consulta = $consulta;
    }

    public function insertarRegistroP() {
        if (isset($_POST['nombre_cliente']) &&
            isset($_POST['fecha_nacimiento_cliente']) &&
            isset($_POST['sexo_cliente']) &&
            isset($_POST['curp_cliente']) &&
            isset($_POST['telefono_cliente'])) {
            
            // Obtener los datos del formulario
            $nombreCliente = $_POST['nombre_cliente'];
            $fechaNacimientoCliente = $_POST['fecha_nacimiento_cliente'];
            $sexoCliente = $_POST['sexo_cliente'];
            $curpCliente = $_POST['curp_cliente'];
            $telefonoCliente = $_POST['telefono_cliente'];
            $correoCliente = isset($_POST['correo_cliente']) ? $_POST['correo_cliente'] : '';
            $enfermedadesPreviasCliente = isset($_POST['enfermedades_previas_cliente']) ? $_POST['enfermedades_previas_cliente'] : '';

            // Obtener la instancia de la clase Consulta
            $consulta = $this->consulta;

            // Llamar al método insertarRegistroP() en Consulta.php para guardar el cliente
            $resultado = $consulta->insertarRegistroP($nombreCliente, $fechaNacimientoCliente, $sexoCliente, $curpCliente, $telefonoCliente, $correoCliente, $enfermedadesPreviasCliente);

            // Redireccionar a la página de origen o mostrar un mensaje de éxito o error (opcional)
            if ($resultado === true) {
                header('Location: ../presentacion/admin.php');
                exit();
            } else {
                echo '<script>alert("Paciente registrado correctamente."); window.location.href = "../presentacion/admin.php";</script>';

            }
        }
    }
}

// Crear una instancia de la clase Consulta
$consulta = new Consulta();

// Crear una instancia de la clase InsertPaciente y llamar al método insertarRegistroP()
$insertPaciente = new InsertPaciente($consulta);
$insertPaciente->insertarRegistroP();
?>
