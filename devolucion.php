<?php  

#Archivo para devolucion de los vehículos alugados

# Iniciamos la sesión
session_start();

# Iniciamos conexión con el servicio MySQL
$mysqli_link = mysqli_connect("localhost", "root","", "frota");
mysqli_set_charset($mysqli_link, "utf8");


if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %",
        mysqli_connect_error());
    exit;
}

$user= $_SESSION['usuario'];

#Hacemos la comprobación de si el usuario tiene la sesión iniciada, si no, redirige a que lo haga.

#Si lo está, saltamos al menú de vehículos.

if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión inciciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    header("refresh: 5; url = index.html");

} else {

    echo "<br><div align='right'><b>Usuario:</b> " . $_SESSION["usuario"] . "</div><br>";
    #Recogemos el modelo seleccionado por el usuario a devolver.

    $modelo = $_REQUEST['modelo_devolver'];


    
    if (isset($_REQUEST['devolucion'])) {

        $update2 = "UPDATE vehiculo_alugado SET cantidade=cantidade -1 WHERE modelo='$modelo' and usuario='$user'";
        $result_update2 = mysqli_query($mysqli_link, $update2);

        echo "Vehículo devolto con éxito!!</br>";
        echo "Volvendo ao menú do usuario... ";
        header("refresh: 5; url = menu_user_form.php");

    }
}