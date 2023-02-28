<?php

#Recollida dos datos do formulario de mod_datos_veh

$modelo = $_REQUEST['modelo'];
$cantidade = $_REQUEST['cantidade_novo'];
$descricion = $_REQUEST['descricion_novo'];
$marca = $_REQUEST['marca_novo'];
$prezo = $_REQUEST['prezo_novo'];
$foto = $_REQUEST['foto_novo'];


# Iniciamos la sesión
session_start();

# Iniciamos conexión con el servicio MySQL

#Comprobación de la conexión con MySQL
$mysqli_link = mysqli_connect("localhost", "root","", "frota");
mysqli_set_charset($mysqli_link, "utf8");


if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}


#Hacemos la comprobación de si el usuario tiene la sesión iniciada, si no, redirige a que lo haga.

#Si lo está, hacemos los updates.


if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión iniciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    mysqli_close($mysqli_link);
    header("refresh: 5; url = index.html");
    
}else{
    
    echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";
    
    

    #Se escolleu a opción de modificar os datos de vehiculo_aluguer...
    if (isset($_REQUEST['mod_datos_aluguer'])){
        
        #Comprobamos que non haxan campos vacíos
        if (!empty($cantidade) && !empty($descricion) && !empty($marca) && !empty($prezo) && !empty($foto) ) {
        

            #Facemos update cos datos a modificar
            $update= "UPDATE vehiculo_aluguer SET cantidade='$cantidade',descricion='$descricion',marca='$marca',prezo='$prezo',foto='$foto' WHERE modelo= '$modelo'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
            
            if( $result){ #Si verdadero, entonces fíxose correctamente o update
                echo "Os datos do modelo $modelo foron modificados! Volvendo ao menú...";
                mysqli_close($mysqli_link);
                header("refresh: 5; url = menu_admin_form.php");
            }
            else{
                echo "Error ao modificar os datos!" . mysqli_error($mysqli_link);
                echo "Volvendo ao menú do admin...";
                mysqli_close($mysqli_link);
                header("refresh: 5; url = menu_admin_form.php");
            }
            
            

            #Mostramos os novos datos actualizados do modelo
            $select_u = "SELECT * from vehiculo_aluguer where modelo= '$modelo'";
            
            $result_u = mysqli_query($mysqli_link, $select_u);
            $num_filas_u = $result_u->num_rows;

            echo "<br><b> Os novos datos actualizados son: </b><br>";
            

            while ($fila = mysqli_fetch_array($result_u, MYSQLI_ASSOC)) {
                echo "<br/>";
                echo "Modelo: " . $fila['modelo'] . "<br/>";
                echo "Cantidade: " . $fila['cantidade'] . "<br/>";
                echo "Descricion: " . $fila['descricion'] . "<br/>";
                echo "Marca: " . $fila['marca'] . "<br/>";
                echo "Prezo: " . $fila['Prezo'] . "<br/>";
                echo "Foto: " . $fila['foto'] . "<br/>";
                echo "<br/>";
            }
            
            
            
        }
        else{
            echo "Faltaron datos por introducir! </br>";
            echo "Volvendo ao menú admin";
            mysqli_close($mysqli_link);
            header("refresh: 5; url = menu_admin_form.php");
        }
    }
    

    #Se se quere modificar os datos de vehiculo_venda
    if (isset($_REQUEST['mod_datos_venda'])){
        
        #Comprobamos que non haxan campos vacíos
        if (!empty($cantidade) && !empty($descricion) && !empty($marca) && !empty($prezo) && !empty($foto) ) {

            $update= "UPDATE vehiculo_venda SET cantidade='$cantidade',descricion='$descricion',marca='$marca',prezo='$prezo',foto='$foto' WHERE modelo= '$modelo'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
            
            if( $result){ #Si verdadero, entonces fíxose correctamente o update
                echo "Os datos do modelo $modelo foron modificados! Volvendo ao menú...";
                mysqli_close($mysqli_link);
                header("refresh: 5; url = menu_admin_form.php");
            }
            else{
                echo "Error ao modificar os datos!" . mysqli_error($mysqli_link);
                echo "Volvendo ao menú do admin...";
                mysqli_close($mysqli_link);
                header("refresh: 5; url = menu_admin_form.php");
            }
            
            

            #Mostramos os novos datos actualizados do modelo
            $select_u = "SELECT * from vehiculo_venda where modelo= '$modelo'";
            
            $result_u = mysqli_query($mysqli_link, $select_u);
            $num_filas_u = $result_u->num_rows;

            echo "<br><b> Os novos datos actualizados son: </b><br>";
            

            while ($fila = mysqli_fetch_array($result_u, MYSQLI_ASSOC)) {
                echo "<br/>";
                echo "Modelo: " . $fila['modelo'] . "<br/>";
                echo "Cantidade: " . $fila['cantidade'] . "<br/>";
                echo "Descricion: " . $fila['descricion'] . "<br/>";
                echo "Marca: " . $fila['marca'] . "<br/>";
                echo "Prezo: " . $fila['Prezo'] . "<br/>";
                echo "Foto: " . $fila['foto'] . "<br/>";
                echo "<br/>";
            }
            
        }
        else{
            echo "Faltaron datos por introducir! </br>";
            echo "Volvendo ao menú admin";
            mysqli_close($mysqli_link);
            header("refresh: 5; url = menu_admin_form.php");
        }  
            
    }

}


# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>