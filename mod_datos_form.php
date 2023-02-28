<?php

#iniciamos la sesión para mostrar la sesión del usuario.
session_start();

if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión inciciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    mysqli_close($mysqli_link);
    header("refresh: 5; url = index.html");

}else{

    echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";

}
?>


 

<?php


# Iniciamos conexión con el servicio MySQL
$mysqli_link = mysqli_connect("localhost", "root","", "frota");
mysqli_set_charset($mysqli_link, "utf8");

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %",
        mysqli_connect_error());
    exit;
}

#Si escolle pechar a sesión, entra no if e o devolve á páxina principal para iniciar sesión de novo se quere.
if (isset($_REQUEST['cerrar'])){

    session_destroy();
    echo "Sesión pechada! </br>";
    echo "Volvendo á páxina de inicio de sesión...";
    mysqli_close($mysqli_link);
    header("refresh: 3; url = index.html");


}

#Se quere modificar os seus datos
if (isset($_REQUEST['modificar'])){

    $usuario=$_SESSION["usuario"];

    
    $select_u = "SELECT * from usuario where usuario= '$usuario'";

    $result_u = mysqli_query($mysqli_link, $select_u);




    while ($fila = mysqli_fetch_array($result_u, MYSQLI_ASSOC)) {
        echo "<br/>";
        $usuario = $fila['usuario'];
        $nome = $fila['nome'];
        $contrasinal = $fila['contrasinal'];
        $direccion = $fila['direccion'];
        $telefono = $fila['telefono'];
        $nifdni = $fila['nifdni'];
        $email = $fila['email'];
        $tipo_usuario = $fila['tipo_usuario'];

    }
    #Pechamos a conexión.

    mysqli_close($mysqli_link);  


    #Creamos formulario para la modificación de datos.

    echo "
    <html>

    <h1>Modificación de Datos</h1>

    <h5> Cambia aquellos datos que quieras modificar</h5>

    <form name='formulario' method='post' action='mod_datos.php' >
        <!-- No dejamos que modifique el nombre de usuario! -->
        <p>Usuario <input type='text' name='user' readonly value='$usuario'>>  </p>
        <p>Contrasinal <input type='password' name='contrasinal_novo' placeholder='Introduzca novo contrasinal' value='$contrasinal'> </p>
        <p>Nome <input type='text' name='nome_novo' placeholder='Introduzca novo nome' value='$nome'> </p>
        <p>Direccion <input type='text' name='direccion_novo' placeholder='Introduzca nova direccion' value='$direccion'> </p>
        <p>Telefono <input type='text' name='telefono_novo' placeholder='Introduzca novo telefono' value='$telefono'> </p>
        <p>Nifdni <input type='text' name='nifdni_novo' placeholder='Introduzca novo nifdni' value='$nifdni'> </p>
        <p>Email <input type='text' name='email_novo' placeholder='Introduzca novo email' value='$email'> </p>
        <!-- No dejamos que modifique el tipo de usuario! -->
        <p>Tipo usuario <input type='text' name='tipo_user' readonly value='$tipo_usuario'>>  </p>

        <button type='submit' name='modificar' >Modificar os meus datos</button>
        <br/>
        
    </form>

    </html>";
}

?>