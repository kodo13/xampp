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
    
    #Comprobamos que quere facer o admin
    
    #Proceso de admisión de novos usuarios.
    if (isset($_REQUEST['novos_users'])){

        $select_u = "SELECT * from novo_rexistro";
        $result_u = mysqli_query($mysqli_link, $select_u);

        $num_filas = $result_u->num_rows;
        if ($num_filas>0){
            while ($fila = mysqli_fetch_array($result_u, MYSQLI_ASSOC)) {
            
                $usuario = $fila['usuario'];
                $contrasinal = $fila['contrasinal'];
                $nome = $fila['nome'];
                $direccion = $fila['direccion'];
                $telefono = $fila['telefono'];
                $nifdni = $fila['nifdni'];
                $email = $fila['email'];
                $tipo_usuario = 'u';
            

                $insert = "INSERT INTO usuario (usuario, contrasinal, nome, direccion, telefono, nifdni, email, tipo_usuario) VALUES ('$usuario','$contrasinal','$nome','$direccion','$telefono','$nifdni','$email','$tipo_usuario')";
    
                $result = mysqli_query($mysqli_link, $insert);
    
                echo "Usuario <b>$usuario</b> admitido correctamente! </br></br>";
            }
    
            #Eliminamos todos los datos de la tabla novo_rexistro que ya pasamos a usuarios
            
            $query = "TRUNCATE table novo_rexistro";
    
            if (mysqli_query($mysqli_link, $query)) {
                echo "Datos borrados da táboa novo_rexistro! </br></br>";
                echo "Volvendo ao menú admin... </br>";
                header("refresh: 7; url = menu_admin_form.php");
            } else {
                echo "Error:" . mysqli_error($connection);
            }
    
            
        }
        #Si no existen usuarios a añadir...
        else{
            echo "Non existe ningún rexistro de usuario pendiente </br>";
            echo "Volvendo ao menú admin... </br>";
            header("refresh: 5; url = menu_admin_form.php");
        }
        
                    

    }

    


    #Proceso de adición de novos vehículos para aluguer.
    if (isset($_REQUEST['novos_vehiculos_aluguer'])){

    echo "<h3>Proceso de rexistro de novos vehículos para o aluguer</h3>

    <form name='form' method='post' action='rexistro_vehiculo_aluguer.php'>
                
        <p>Modelo <input type='text' name='modelo_novo' placeholder='Introduzca modelo' value=''> </p>
        <p>Cantidade <input type='number' min='0' name='cantidade_novo' placeholder='Introduzca cantidade/s' value=''> </p>
        <p>Descricion <input type='text' name='descricion_novo' placeholder='Introduzca descricion' value=''> </p>
        <p>Marca <input type='text' name='marca_novo' placeholder='Introduzca marca' value=''> </p>
        <p>Prezo <input type='text' name='prezo_novo' placeholder='Introduzca prezo' value=''> </p>
        <p>Foto <input type='text' name='foto_novo' placeholder='Introduzca url da foto' value=''> </p>
        
        <button type='submit' name='rexistro_veh' >Rexistrar vehículo aluguer</button>

    </form>";

    }


    #Proceso de adición de novos vehículos para a venta
    if (isset($_REQUEST['novos_vehiculos_venta'])){

        echo "<h3>Proceso de rexistro de novos vehículos para a venda</h3>
    
        <form name='form' method='post' action='rexistro_vehiculo_venta.php'>
                    
            <p>Modelo <input type='text' name='modelo_novo' placeholder='Introduzca modelo' value=''> </p>
            <p>Cantidade <input type='number' min='0' name='cantidade_novo' placeholder='Introduzca cantidade/s' value=''> </p>
            <p>Descricion <input type='text' name='descricion_novo' placeholder='Introduzca descricion' value=''> </p>
            <p>Marca <input type='text' name='marca_novo' placeholder='Introduzca marca' value=''> </p>
            <p>Prezo <input type='number' min='0' name='prezo_novo' placeholder='Introduzca prezo' value=''> </p>
            <p>Foto <input type='text' name='foto_novo' placeholder='Introduzca url da foto' value=''> </p>
            
            <button type='submit' name='rexistro_veh' >Rexistrar vehículo venda</button>
    
        </form>";
    
    }

    #Proceso de eliminar vehículos do aluguer
    if (isset($_REQUEST['eliminar_aluguer'])){

        echo "<h3>Proceso de eliminar vehículos do aluguer</h3>
    
        <form name='form' method='post' action='eliminar.php'>
                    
            <p>Modelo <input type='text' name='modelo_eliminar' placeholder='Introduzca modelo a eliminar' value=''> </p>
            <p>Cantidade <input type='number' min='0' name='cantidade_eliminar' placeholder='Introduzca cantidade/s' value=''> </p>
            
            <button type='submit' name='eliminar_alu' >Eliminar vehículo do aluguer</button>
    
        </form>";
    
    }

    #Proceso de eliminar vehículos da venda
    if (isset($_REQUEST['eliminar_venda'])){

        echo "<h3>Proceso de eliminar vehículos da venda</h3>
    
        <form name='form' method='post' action='eliminar.php'>
                    
            <p>Modelo <input type='text' name='modelo_eliminarV' placeholder='Introduzca modelo a eliminar' value=''> </p>
            <p>Cantidade <input type='number' min='0' name='cantidade_eliminarV' placeholder='Introduzca cantidade/s ' value=''> </p>
            
            <button type='submit' name='eliminar_ve' >Eliminar vehículo da venda</button>
    
        </form>";
    
    }

}



mysqli_close($mysqli_link);


?>
