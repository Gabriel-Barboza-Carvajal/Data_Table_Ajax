<?php
//
//    Nombre archivo: archivo_ajax.php
//
//    Autor:          Gabriel Barboza Carvajal 
//
//    Descripción:    Se encarga de enviar la respuesta utlizando funciones de apoyo.

include 'funciones_logica.php';

$respuesta = funciones_logica::enviar_respuesta();

echo json_encode($respuesta);