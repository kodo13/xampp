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

$user= $_SESSION['usuario'];

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
        
        echo $user;
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

        #Recollemos os datos do modelo escollido.
        
        $cantidade = $fila['cantidade'];
        $descricion = $fila['descricion'];
        $marca = $fila['marca'];
        $foto = $fila['foto'];
        #$prezo = $fila['prezo']; #Non fai falta saber o prezo cando esté alugado.
        


        if ($cantidade > 0){
            $cantidade = ($cantidade - 1); 
            
            #Hacemos update para quitar una unidad disponible del vehículo.
            
            $update= "UPDATE vehiculo_aluguer SET cantidade='$cantidade' WHERE modelo= '$modelo'";

            $result_update = mysqli_query($mysqli_link, $update);


            #Se devuelve TRUE si se ejecutó la consulta correctamente.
            #Comprobamos si se hizo el update correctamente.
            /*
            if( $result_update){ #Si verdadero, entonces update hecho correctamente.
                echo "Update hecho!";
            } else {
                echo "Error!!" . mysqli_error($mysqli_link);


            }
            */

            #Comprobamos si el usuario tiene otra unidad del vehículo que quiere alugar.
            
            $select_alugado = "SELECT * FROM vehiculo_alugado where modelo='$modelo' and usuario='$user'"; 
            $result_alugado = mysqli_query($mysqli_link, $select_alugado);
            $num_filas_alugado=$result_alugado->num_rows; #Comprobamos si la consulta devuelve algun resultado

            $fila2 = mysqli_fetch_array($result_alugado, MYSQLI_ASSOC);
            $cant = $fila2['cantidade'];
            

        
            if ($num_filas_alugado > 0 ){
    
                $update2 = "UPDATE vehiculo_alugado SET cantidade=cantidade +1 WHERE modelo='$modelo' and usuario='$user'";
                $result_update2 = mysqli_query($mysqli_link, $update2);

                echo "Vehículoo alugado! </br> Nova cantidade alugada do modelo "." $modelo </br>";
                echo "Volvendo ao menú do usuario... </br>";
                header("refresh: 5; url = menu_user_form.php");
                
            }
            
            else{
            #Si no existe ningún usuario que tenga ese vehículo alugado, entonces hacemos insert del vehiculo a la tabla vehiculo_alugado.

                $insert = "INSERT INTO vehiculo_alugado(modelo, cantidade, descricion, marca, foto, usuario) 
                VALUES ('$modelo','$cantidade','$descricion','$marca','$foto','$user')";

                $result_insert = mysqli_query($mysqli_link, $insert);

                echo "<br><b> Enhoraboa $user!! Desfruta do teu novo vehículo alugado, modelo $modelo!! </b>< ";
                echo "Volvendo ao menú do usuario... </br>";
                header("refresh: 5; url = menu_user_form.php");
            }
            

        
            
        }
        else{
            echo "meeeh, error";
            echo "Volvendo ao menú do usuario... </br>";
            header("refresh: 5; url = menu_user_form.php");
        }
    
    }
 

    mysqli_close($mysqli_link);


}



?>
