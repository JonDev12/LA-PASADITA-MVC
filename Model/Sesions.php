<?php

require_once('../Model/Connection.php');

class Sesions{
    private $model_sesion;
    
    public function __construct() {
        $this->model_sesion = new Connection();
    }
    
    public function GetUsers(){
        $con = $this->model_sesion->getConnection();
        // Aquí puedes utilizar la conexión $con para realizar consultas
        //Consulta de todos los usuarios
        $sql = "SELECT IdUsuarios, Nombre, ApellidoP, ApellidoM, Tipo_usuario, Fecha_alta FROM usuarios";
        $result = $con->query($sql);
    
        // Verificar si la consulta fue exitosa
        if ($result === false) {
            // Manejar el error aquí, por ejemplo:
            echo "Error en la consulta: " . $con->error;
            // Puedes manejar el error de otra manera, como lanzar una excepción
            // y manejarla donde llames a esta función.
        } else {
            // Creamos una variable para almacenar el HTML de la tabla
            $html = '';
    
            // Iteramos sobre los resultados
            while ($row = $result->fetch_assoc()) {
                // Agregamos una fila a la tabla por cada resultado
                $html .= "<tr>";
                $html .= "<th scope='row' class='text-center'>{$row['IdUsuarios']}</th>";
                $html .= "<td class='text-center'>{$row['Nombre']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoP']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoM']}</td>";
                $html .= "<td class='text-center'>{$row['Tipo_usuario']}</td>";
                $html .= "<td class='text-center'>{$row['Fecha_alta']}</td>";
                $html .= "</tr>";                
            }
    
            // Cerrar la conexión después de usarla
            $con->close();
    
            // Devolvemos el HTML generado
            return $html;
        }
    }
        
}