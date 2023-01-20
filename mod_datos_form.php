<?php

#iniciamos la sesión para mostrar la sesión del usuario.
session_start();

#Mostramos sesión del usuario.
echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div>";


?>


 

<?php


# Iniciamos conexión con el servicio MySQL
$mysqli_link = mysqli_connect("localhost", "root","", "frota");

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %",
        mysqli_connect_error());
    exit;
}

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
?>


<html>

<h1>Modificación de Datos</h1>

<h5> Cambia aquellos datos que quieras modificar</h5>

<form name="formulario" method="post" action="mod_datos.php" >
    <!-- No dejamos que modifique el nombre de usuario! -->
    <p>Usuario <input type="text" name="user" readonly value="<?php echo $usuario; ?>">>  </p>
    <p>Contrasinal <input type="password" name="contrasinal_novo" placeholder="Introduzca novo contrasinal" value="<?php echo $contrasinal; ?>"> </p>
    <p>Nome <input type="text" name="nome_novo" placeholder="Introduzca novo nome" value="<?php echo $nome; ?>"> </p>
    <p>Direccion <input type="text" name="direccion_novo" placeholder="Introduzca nova direccion" value="<?php echo $direccion; ?>"> </p>
    <p>Telefono <input type="text" name="telefono_novo" placeholder="Introduzca novo telefono" value="<?php echo $telefono; ?>"> </p>
    <p>Nifdni <input type="text" name="nifdni_novo" placeholder="Introduzca novo nifdni" value="<?php echo $nifdni; ?>"> </p>
    <p>Email <input type="text" name="email_novo" placeholder="Introduzca novo email" value="<?php echo $email; ?>"> </p>
    <!-- No dejamos que modifique el tipo de usuario! -->
    <p>Tipo usuario <input type="text" name="tipo_user" readonly value="<?php echo $tipo_usuario; ?>">>  </p>

    <button type="submit" name="modificar" >Modificar os meus datos</button>
    <br/>
    
</form>

</html>