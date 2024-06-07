<?php

if (isset($_POST['accion']) && $_POST['accion'] === 'Formulario') 
{
    include('C:\xampp\htdocs\Informes\View\Informes.php');
}
elseif(isset($_POST['accion']) && $_POST['accion'] === 'Element')
{
    include('C:\xampp\htdocs\Informes\Logica\Logica.php');
}