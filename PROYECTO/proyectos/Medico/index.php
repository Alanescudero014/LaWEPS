<?php

use Datos\Consulta;
// Incluye el archivo consulta.php para poder utilizar la clase Consulta
require_once 'datos/consulta.php';

// Crea una instancia de la clase Consulta para crear la base de datos y las tablas
$consulta = new Consulta();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/alan.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/seis.css">
    <title>Consultorio</title>
</head>
<style>
    .parent {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), url('img/fondo4.jpg');
        background-repeat: no-repeat;
        background-size: 100%;

    }

    p,
    hr,
    h1 {
        color: white;
    }

    p {
        font-family: NewsCycle, Karla, Arial, Helvetica, sans-serif;
    }

    h1 {
        font-family: Karla, Arial, Helvetica, sans-serif;
    }
</style>

<body>
    <div class="parent">
        <div style="padding-top: 4rem; padding-bottom: auto; ">
            <div class="container">
                <h1>
                    <center>BIENVENIDO</center>
                </h1>
                <hr>
                <div>
                    <p>Este programa de consultorio médico fue creado por Alan Jesset Escudero Alvarez, estudiante <br>
                        de la Universidad Tecnológica de Tecámac. A continuación se presentan el contacto del creador <br>
                        y las herramientas que se ocuparon para realizar este programa.</p>
                </div><br>
            </div><br>

            <div class="icons">
                <a href="" class="icon icon--instagram">
                    <i class="ri-instagram-line"></i>
                </a>
                <a href="" class="icon icon--visual">
                    <li class="icon" style="background-image: url('img/visual2.png'); background-position: center; background-size: 40%; background-repeat: no-repeat;"></li>
                </a>
                <a href="" class="icon icon--chrome">
                    <i class="ri-chrome-line"></i>
                </a>
                <a href="" class="icon icon--git">
                    <i class="ri-github-fill"></i>
                </a>
            </div><br>

        </div>
    </div>
    <div style="text-align:center;">
        <button class="boton seis" onclick="redireccionar()">
            <span>ENTRAR</span>
            <svg>
                <rect x="0" y="0" fill="none"></rect>
            </svg>
        </button>
    </div>
    <script>
        function redireccionar() {
            // Cambia "otra_pagina.html" por la URL o ruta de la página a la que deseas redireccionar
            window.location.href = "presentacion/alan.php";
        }
    </script>
</body>

</html>