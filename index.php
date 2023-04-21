<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));

//Obtener Todos Los Registros
Flight::route('GET /alumnos', function () {
    
    $sentencia=Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);

});

//Obtener Solo Un Registro
Flight::route('GET /alumnos/@id', function ($id) {
    
    $sentencia=Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id=?");
    $sentencia->bindParam(1,$id);
    
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);

});

//Insertar Registros
Flight::route('POST /alumnos', function () {
    
    $nombre=(Flight::request()->data->nombre);
    $apellidos=(Flight::request()->data->apellidos);

    $sql="INSERT INTO alumnos (nombre, apellidos) VALUES(?,?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->execute();

    Flight::jsonp(["Alumno Agregado"]);

});

//Borrar Registros
Flight::route('DELETE /alumnos', function () {
    
    $id=(Flight::request()->data->id);

    $sql="DELETE FROM alumnos WHERE id=? ";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$id);
    $sentencia->execute();

    Flight::jsonp(["Alumno Borrado"]);
});

//Actualizar Registros
Flight::route('PUT /alumnos', function () {
    
    $id=(Flight::request()->data->id);
    $nombre=(Flight::request()->data->nombre);
    $apellidos=(Flight::request()->data->apellidos);

    $sql="UPDATE alumnos SET nombre=?, apellidos=? WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);

    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->bindParam(3,$id);

    $sentencia->execute();

    Flight::jsonp(["Alumno Actualizado"]);
});

Flight::start();
