<?php

namespace Negocio;

use Datos\Consulta;


// Incluir el archivo de la clase Consulta
include_once "../datos/consulta.php";


class SelectCita
{
    private $consulta;

    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    public function mostrarRegistrosC()
    {
        return $this->consulta->mostrarRegistrosC();
    }

    public function buscarCitaPorNombre($nombrePaciente) {
        // Obtener la instancia de la clase Consulta
        $consulta = $this->consulta;

        // Obtener el paciente por su nombre
        $citas = $consulta->buscarCitaPorNombre($nombrePaciente);

        return $citas;
    }
}

// Solo realizamos la búsqueda si se envió el formulario
if (isset($_POST['busqueda_cita'])) {
    $nombrePaciente = $_POST['busqueda_cita'];
    $consulta = new Consulta();
    $selectPaciente = new SelectCita($consulta);
    $cita = $selectPaciente->buscarCitaPorNombre($nombrePaciente);
}
