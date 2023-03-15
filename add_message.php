<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectarDB();

extract($_POST);
$_query = "INSERT INTO contacto (id,nombre,apellido,telefono,email,mensaje) VALUES ('','$_POST[nombre]','$_POST[apellido]','$_POST[telefono]','$_POST[email]','$_POST[mensaje]')";//query de SQL
$result = $con->query($_query); //objeto nuevo
if(!$result){
    die("Hubo un error al insertar los datos: ".$mysqli->error);
}
echo "Formulario Enviado!!!";
echo "<br>En 3 segundos volver&aacutes;s a la p&aacutes;gina anterior.";
header( "refresh:3;url=contact.php" );

?>