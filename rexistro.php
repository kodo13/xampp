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
mysqli_set_charset($mysqli_link, "utf8");

#Si hay algún error, se sale del programa

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}



#Comrobamos que todas las variables existan y no estén vacías.
if(!empty($usuario) && !empty($contrasinal) && !empty($nome) && !empty($direccion) && !empty($telefono) && !empty($nifdni) && !empty($email)) {


    #Facemos comprobación de si existe un usuario con ese mesmo nome na táboa de usuario ou na de novo_rexitro

    $select_user= "SELECT usuario FROM usuario WHERE usuario = '$usuario' UNION SELECT usuario FROM novo_rexistro WHERE usuario = '$usuario'";
    $result_user = mysqli_query($mysqli_link, $select_user);

    $num_filas = $result_user->num_rows;
    #Si existe, avisamos de que non pode ter ese mismo nome de usuario
    if ($num_filas > 0){
        echo "Ya existe un usuario con ese mismo nombre. Prueba con otro diferente! </br> </br>" ;
        echo "Redirigiendo al proceso de rexistro";
        mysqli_close($mysqli_link);
        header("refresh: 5; url = rexistro.html");
    }

    else{

        #El usuario no existe y hacemos las inserciones en la tabla novo_rexitro.
        $insert = "INSERT INTO novo_rexistro (usuario, contrasinal, nome, direccion, telefono, nifdni, email) VALUES ('$usuario','$contrasinal','$nome','$direccion','$telefono','$nifdni','$email')";

        $result = mysqli_query($mysqli_link, $insert);

        #Comprobamos mediante un if si se ha hecho o no el registro.

        if ($result) {
            echo "Se ha registrado correctamente! <br/>";
            echo "Redirigiendo a la página de inicio";
            mysqli_close($mysqli_link);
            header("refresh: 5; url = index.html");
        } else {
            echo "Error al hacer el registro...Volviendo al login";
            mysqli_close($mysqli_link);
            header("refresh: 5; url = index.html");
        }

    }


    
    

}

else{
    
    #Salta aquí si falta algún dato por introducir.
    echo "Faltaron datos por introducir! Tes que cubrir todos os campos!</br> Volvendo ao rexistro...";
    mysqli_close($mysqli_link);
    header("refresh: 3; url = rexistro.html");
}



# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>