<?php

#Recogemos variables del  formulario de rexistro.

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
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}



#Comrobamos que todas las variables existan y no estén vacías.
if ((isset($usuario)) && (isset($contrasinal)) && (isset($nome)) && (isset($direccion)) && (isset($telefono)) && (isset($nifdni)) && (isset($email))) {

    
    #Hacemos las inserciones en la tabla novo_rexitro.
    $insert = "INSERT INTO novo_rexistro (usuario, contrasinal, nome, direccion, telefono, nifdni, email) VALUES ('$usuario','$contrasinal','$nome','$direccion','$telefono','$nifdni','$email')";

    $result = mysqli_query($mysqli_link, $insert);

    #Comprobamos mediante un if si se ha hecho o no el registro.

    if ($result) {
        echo "Se ha registrado correctamente! <br/>";
        echo "Redirigiendo a la página de inicio";
        header("refresh: 5; url = index.html");
    } else {
        echo "Error al hacer el registro...Volviendo al login";
        header("refresh: 5; url = index.html");
    }
    

}

else{
    echo "hola?";
    #Salta aquí si falta algún dato por introducir.
    echo "Faltan datos por introducir! Volviendo al registro";
    header("refresh: 3; url = rexistro.html");
}



# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>