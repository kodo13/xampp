<?php


$usuario = $_REQUEST['usuario_novo'];
$contrasinal = $_REQUEST['contrasinal_novo'];
$nome = $_REQUEST['nome_novo'];
$direccion = $_REQUEST['direccion_novo'];
$telefono = $_REQUEST['telefono_novo'];
$nifdni = $_REQUEST['nifdni_novo'];
$email = $_REQUEST['email_novo'];

#Creamos la conexión con la base de datos

$mysqli_link = mysqli_connect("localhost","root","","frota");

#Si hay algún error, se sale del programa

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %",
        mysqli_connect_error());
    exit;
}



#Hacemos las inserciones en la tabla novo_rexitro.






# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>