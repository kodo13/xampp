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


$insert= "INSERT INTO `novo_rexistro` VALUES ('$usuario','$contrasinal','$nome','$direccion','$telefono','$nifdni','$email')";

$result = mysqli_query($mysqli_link, $insert);

#Comprobamos mediante un if si se ha hecho o no el registro.

if ($result){
    echo "Se ha registrado correctamente! <br/>";
    echo "Redirigiendo a la página de inicio";
    header("refresh: 5; url = index.html");
}
else{
    echo "Error al hacer el registro...Volviendo al login";
    header("refresh: 5; url = index.html");
}


# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>