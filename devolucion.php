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

#Guardamos la sesión del usuario
$user= $_SESSION['usuario'];

#Hacemos la comprobación de si el usuario tiene la sesión iniciada, si no, redirige a que lo haga.

#Si lo está, mostramos vehículos a devolver.

if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión inciciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    mysqli_close($mysqli_link);
    header("refresh: 5; url = index.html");

} else {

    echo "<br><div align='right'><b>Usuario:</b> " . $_SESSION["usuario"] . "</div><br>";

    #Recogemos el modelo seleccionado por el usuario a devolver.
    $modelo = $_REQUEST['modelo_devolver'];


    #Se o usuario pulsa en devolver o vehículo
    if (isset($_REQUEST['devolucion'])) {
        
        #Restamos 1 á cantidade alugada do vehiculo que ten ese usuario e ese modelo.
 
        $update2 = "UPDATE vehiculo_alugado SET cantidade=cantidade -1 WHERE modelo='$modelo' and usuario='$user'";
        $result_update2 = mysqli_query($mysqli_link, $update2);

        #Ejecutamos consulta á táboa vehiculo_devolto para ver se o usuario xa devolveu ese modelo. 
        #Si ten o mesmo modelo devolto, sumamos un, se non ten, facemos inserción na táboa.

        $select_dev= "SELECT * from vehiculo_devolto where modelo='$modelo' and usuario='$user'";
        $result_dev = mysqli_query($mysqli_link, $select_dev);
        $num_filas_ss=$result_dev->num_rows; 
        
        #Comprobamos si la consulta devuelve algun resultado
        if ($num_filas_ss > 0 ){
            #Si entra aquí es que el usuario ya devolvió ese mismo modelo recientemente, aumentamos en 1 la cantidad devuelta
            $update_devolto = "UPDATE vehiculo_devolto SET cantidade=cantidade +1 WHERE modelo='$modelo' and usuario='$user'";
            $result_update_devolto = mysqli_query($mysqli_link, $update_devolto);

            echo "Vehículo devolto con éxito! </br>";
            echo "Volvendo ao menú do usuario... </br>";
            mysqli_close($mysqli_link);
            header("refresh: 5; url = menu_user_form.php");
            
        }
        else{
            #Si entra aquí, no existe ese modelo devuelto por el usuario
            $select_alugado = "SELECT * FROM vehiculo_alugado WHERE modelo='$modelo' and usuario='$user'";
            $result_alugado = mysqli_query($mysqli_link, $select_alugado);

            $fila = mysqli_fetch_array($result_alugado, MYSQLI_ASSOC);

            #Recollemos os datos do modelo que o usuario quere devolver.
        
            $cantidade = $fila['cantidade'];
            $descricion = $fila['descricion'];
            $marca = $fila['marca'];
            $foto = $fila['foto'];
            #Hacemos insert de los datos del vehicuo devolto con 1 cantidad.
            $insert = "INSERT INTO vehiculo_devolto (modelo, cantidade, descricion, marca, foto, usuario) 
                VALUES ('$modelo',1,'$descricion','$marca','$foto','$user')";

            $result_insert = mysqli_query($mysqli_link, $insert);

            if( $result_insert){ #Si verdadero, entonces update hecho correctamente.
                #Eliminamos os datos dos vehiculos dos que xa non quedan cantidades a devolver.
                $delete0 = "DELETE FROM vehiculo_alugado WHERE cantidade=0";
                $result_delete0 = mysqli_query($mysqli_link, $delete0);
                echo "Vehículo devolto con éxito! </br> ";
                echo "Volvendo ao menú do usuario... </br>";

                mysqli_close($mysqli_link);
                header("refresh: 5; url = menu_user_form.php");

            } else {
                echo "Oubo un erro fatal ao devolver o vehículo!!" . mysqli_error($mysqli_link);
                

            }   

                
        }


        

    }
    mysqli_close($mysqli_link);
}

?>