<?php  

#Menú donde se listan los coches los coches de aluguer o venta.

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

$user=$_SESSION["usuario"];
if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión inciciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    header("refresh: 5; url = index.html");

}else{

    echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";
    #Comprobamos que quiere ver el usuario.
    #Si quiere ver los vehículos a la venta, se los mostramos, si no se cumple la condición, saltamos al siguiente if.
    
    if (isset($_REQUEST['lista_venda'])){

        #Ejecutamos la consulta para recoger los vehículos a la venta.
        $select_venta = "SELECT * FROM vehiculo_venda";
        $result_venta = mysqli_query($mysqli_link, $select_venta);
        $num_filas_venta = $result_venta->num_rows;

        #Mostramos los vehículos a la venta.
        echo "<br><b> Vehículos en venta</b><br>";
        
        #Mostramos los vehículos mediante un bucle while que va leyendo línea a línea y mostrando los resultados de cada vez.
        

        while ($fila = mysqli_fetch_array($result_venta, MYSQLI_ASSOC)) {
            echo "<br/>";
            echo "Modelo: " . $fila['modelo'] . "<br/>";
            echo "Cantidade: " . $fila['cantidade'] . "<br/>";
            echo "Descrición: " . $fila['descricion'] . "<br/>";
            echo "Marca: " . $fila['marca'] . "<br/>";
            echo "Prezo: " . $fila['prezo'] . "<br/>";
            echo "Foto: <img src= ' ". $fila['foto'] ." ' width='350' height='250'> <br/>";
            echo "<br/>";
        }
        #Creamos botón para volver ao menú principal
        echo "
        <form name='formulario' method='post' action='menu_user_form.php'>
            <button type='submit' name='volver' ><b>Volver menú principal</b></button>

        </form>        
        ";
       
                

    }

    if(isset($_REQUEST['lista_aluguer'])){
        #Realizamos consulta para recoger los vehiculos en aluguer.
        $select_aluguer = "SELECT * FROM vehiculo_aluguer where cantidade > '0'"; #Si existen vehículos sin existencias para alugar, 
        #entonces no se muestran en la lista. Solo mostramops los disponibles.

        $result_aluguer = mysqli_query($mysqli_link, $select_aluguer);
        $num_filas_aluguer=$result_aluguer->num_rows;

        echo "<br><b> Vehículos en aluguer</b><br>";

        #Mostramos los vehículos mediante un bucle while que va leyendo línea a línea y mostrando los resultados de cada vez.
        
        
        while ($fila = mysqli_fetch_array($result_aluguer, MYSQLI_ASSOC)) {
            echo "<br/>";
            echo "Modelo: " . $fila['modelo'] . "<br/>";
            echo "Cantidade: " . $fila['cantidade'] . "<br/>";
            echo "Descrición: " . $fila['descricion'] . "<br/>";
            echo "Marca: " . $fila['marca'] . "<br/>";
            echo "Prezo: " . $fila['prezo'] . "<br/>";
            echo "Foto: <img src= ' ". $fila['foto'] . " ' width='350' height='250'> <br/>";
            echo "<br/></br>";
        }
        
        #Creamos botón para volver ao menú principal
        echo "
        <form name='formulario' method='post' action='menu_user_form.php'>
            <button type='submit' name='volver' ><b>Volver menú principal</b></button>

        </form>        
        ";
        


        
    }
}

?>