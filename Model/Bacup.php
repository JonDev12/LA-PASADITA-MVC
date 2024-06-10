<?php
// Configuración de la base de datos
$hostname = 'localhost';
$username = 'root'; // Usuario de la base de datos
$password = ''; // Contraseña de la base de datos
$database = 'db_pasadita';

// Nombre del archivo de respaldo
$backup_file = 'backup.sql';

// Comando para generar el respaldo utilizando mysqldump
$command = "mysqldump --user={$username} --password={$password} --host={$hostname} {$database} > {$backup_file}";

// Ejecutar el comando
exec($command, $output, $return_var);

// Verificar si el respaldo fue exitoso
if ($return_var === 0) {
    echo "Backup de la base de datos generado exitosamente.";
} else {
    echo "Error al generar el backup de la base de datos.";
}
?>
