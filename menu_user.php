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
    
    if (isset($_REQUEST['venta'])){

        #Ejecutamos la consulta para recoger los vehículos a la venta.
        $select_venta = "SELECT * FROM vehiculo_venda";
        $result_venta = mysqli_query($mysqli_link, $select_venta);
        $num_filas_venta = $result_venta->num_rows;

        #Mostramos los vehículos a la venta.
        echo "<br><b> Vehículos en venta</b><br>";
        
        #Mostramos los vehículos mediante un bucle while que va leyendo línea a línea y mostrando los resultados de cada vez.
        echo "<form action='comprar_alugar.php' method='post'>";

        while ($fila = mysqli_fetch_array($result_venta, MYSQLI_ASSOC)) {
            echo "<br/>";
            echo "Modelo: " . $fila['modelo'] . "<br/>";
            echo "Cantidade: " . $fila['cantidade'] . "<br/>";
            echo "Descrición: " . $fila['descricion'] . "<br/>";
            echo "Marca: " . $fila['marca'] . "<br/>";
            echo "Prezo: " . $fila['prezo'] . "<br/>";
            echo "Foto: <img src= ' ". $fila['foto'] . " '> <br/>";
            echo "<p> <input type='radio' name='comprar' value='comprar'> </p>";
            echo "<br/>";
        }
        echo "<p><input type='submit' name='comprar' value='Comprar'></p>
                </form>";

    }

    if(isset($_REQUEST['aluguer'])){
        #Realizamos consulta para recoger los vehiculos en aluguer.
        $select_aluguer = "SELECT * FROM vehiculo_aluguer where cantidade > '0'"; #Si existen vehículos sin existencias para alugar, 
        #entonces no se muestran en la lista. Solo mostramops los disponibles.

        $result_aluguer = mysqli_query($mysqli_link, $select_aluguer);
        $num_filas_aluguer=$result_aluguer->num_rows;

        echo "<br><b> Vehículos en aluguer</b><br>";

        #Mostramos los vehículos mediante un bucle while que va leyendo línea a línea y mostrando los resultados de cada vez.
        
        echo "<form action='comprar_alugar.php' method='post'>";
        while ($fila = mysqli_fetch_array($result_aluguer, MYSQLI_ASSOC)) {
            echo "<br/>";
            echo "Modelo: " . $fila['modelo'] . "<br/>";
            echo "Cantidade: " . $fila['cantidade'] . "<br/>";
            echo "Descrición: " . $fila['descricion'] . "<br/>";
            echo "Marca: " . $fila['marca'] . "<br/>";
            echo "Prezo: " . $fila['prezo'] . "<br/>";
            echo "Foto: <img src= ' ". $fila['foto'] . " '> <br/>";
            $modelo = $fila['modelo'];
            echo "<p><input type='radio' name='alugar' value='$modelo'></p>"; #Con value=$modelo, mandamos los datos del modelo para poder diferenciar que vehículo escogió el user

            echo "<br/>";
        }

        echo "<p><input type='submit' name='aluguer' value='Alugar'></p>  
                </form>";
    }
        #Con name="aluguer", hacemos distinción 

    

    #Si escolleu devolver un vehículo alugado...
    if (isset($_REQUEST['devolucion'])){

        #Facemos consulta para ver que vehículos ten alugado o usuario para mostralos
        $select_devolucion = "SELECT * FROM vehiculo_alugado where usuario='$user' and cantidade > 0";
        $result_devolucion = mysqli_query($mysqli_link, $select_devolucion);
        $num_filas_devolucion = $result_devolucion->num_rows;

        
        
        
        #Mostramos os vehículos alugados do usuario nun desplegable
        echo "<br><b> Vehículos alugados</b><br>";
        echo "<form action='devolucion.php' method='post'>";
        echo "<select name='modelo_devolver'>
                <option value='0'> Elixe vehiculo a devolver </option>";

                while ($fila3 = mysqli_fetch_array($result_devolucion, MYSQLI_ASSOC)) {
                    $modelo = $fila3['modelo'];
                    echo "<option value='$modelo'>$modelo</option>";
                }
        echo "</select>";
        echo "<p><input type='submit' name='devolucion' value='Devolución'></p>  
                </form>";
        
      

        

    }

    mysqli_close($mysqli_link);


}



?>
