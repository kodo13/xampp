<?php

#Recollida de datos

$contrasinal = $_REQUEST['contrasinal_novo'];
$nome = $_REQUEST['nome_novo'];
$direccion = $_REQUEST['direccion_novo'];
$telefono = $_REQUEST['telefono_novo'];
$nifdni = $_REQUEST['nifdni_novo'];
$email = $_REQUEST['email_novo'];


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
    
    if (isset($_REQUEST['modificar'])){
        
        #Generamos variable user para usarla en la consulta mysql.
        $usuario=$_SESSION["usuario"];
        #echo "usuario  ".$usuario;
        

        #Comprobamos se introduce novo contrasinal para cambialo...
        if (!empty($contrasinal)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET contrasinal='$contrasinal' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Contrasinal actualizado.</br>";
            
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
             
            }
        }

        #Comprobamos se introduce novo nome para cambialo...
        if (!empty($nome)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET nome='$nome' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Nome actualizado.</br>";
        
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
            
            }
        }

        #Comprobamos se introduce nova direccion para cambialo...
        if (!empty($direccion)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET direccion='$direccion' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Dirección actualizada.</br>";
             
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
            
            }
        }

        #Comprobamos se introduce novo telefono para cambialo...
        if (!empty($telefono)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET telefono='$telefono' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Telefono actualizado.</br>";
         
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
       
            }
        }

        #Comprobamos se introduce novo nifdni para cambialo...
        if (!empty($nifdni)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET nifdni='$nifdni' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Nifdni actualizado.</br>";
                
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
                
            }
        }

        #Comprobamos se introduce novo email para cambialo...
        if (!empty($email)) {

            #Ejecutamos update con los datos a cambiar
            $update= "UPDATE usuario SET email='$email' WHERE usuario= '$usuario'";
            $result = mysqli_query($mysqli_link, $update);
            #Se devuelve TRUE si se ejecutó la consulta correctamente.
        
            if( $result){ #Si verdadero, entonce registro echo correctamente.
                echo "Email actualizado.</br>";
                
            }
            else{
                echo "Error al modificar los datos!" . mysqli_error($mysqli_link);
                
            }
        }

        

        #Mostramos los datos modificados
        $select_u = "SELECT * from usuario where usuario= '$usuario'";
        
        $result_u = mysqli_query($mysqli_link, $select_u);
        $num_filas_u = $result_u->num_rows;

        echo "<br><b> Os novos datos actualizados son: </b><br>";
        

        while ($fila = mysqli_fetch_array($result_u, MYSQLI_ASSOC)) {
            echo "<br/>";
            echo "Usuario: " . $fila['usuario'] . "<br/>";
            echo "Contrasinal: " . $fila[''] . "<br/>";
            echo "Nome: " . $fila['nome'] . "<br/>";
            echo "Direcion: " . $fila['direccion'] . "<br/>";
            echo "Telefono: " . $fila['telefono'] . "<br/>";
            echo "Nifdni: " . $fila['nifdni'] . "<br/>";
            echo "email: " . $fila['email'] . "<br/>";
            echo "Tipo usuario: " . $fila['tipo_usuario'] . "<br/>";
            echo "<br/>";
        }
        
        #DEspois de mostrar os datos, volvemos ao menú de usuario
        echo "Volviendo al menú del usuario...";
        mysqli_close($mysqli_link);
        header("refresh: 7; url = menu_user_form.php");
        
        
    }

}


# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>