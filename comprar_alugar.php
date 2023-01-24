<?php  

#Archivo para gestionar el alquiler o compra de los vehículos

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

#Hacemos la comprobación de si el usuario tiene la sesión iniciada, si no, redirige a que lo haga.

#Si lo está, saltamos al menú de vehículos.

if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión inciciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    header("refresh: 5; url = index.html");

}else{

    echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";
    #Comprobamos si el usuario quiere comprar o alugar vehículo.

    
    if (isset($_REQUEST['comprar'])){
        
        echo "Compra";

    }



    
    #Recollemos modelo escollido polo usuario
    $modelo= $_REQUEST['alugar'];
    #echo $modelo;
    #Si escolleu a opción de alugar vehículo...
    if(isset($_REQUEST['aluguer'])){

        $select_aluguer = "SELECT * FROM vehiculo_aluguer WHERE modelo='$modelo'";
        $result_aluguer = mysqli_query($mysqli_link, $select_aluguer);
        
        $fila = mysqli_fetch_array($result_aluguer, MYSQLI_ASSOC);
        
        $cantidade= $fila['cantidade'];
        
        
        echo "Vehículo alugado!";
    
    }
 

    mysqli_close($mysqli_link);


}



?>
