<?php
    

# Iniciamos conexión con el servicio MySQL
$mysqli_link = mysqli_connect("localhost", "root","", "frota");
mysqli_set_charset($mysqli_link, "utf8");

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %",
        mysqli_connect_error());
    exit;
}


# Iniciamos la sesión
session_start();

if(!isset($_SESSION["usuario"])){
    #Si entra aquí, no tiene sesión iniciada y mandamos a login.
    echo "No tienes la sesión iniciada, redireccionando al login... ";
    mysqli_close($mysqli_link);
    header("refresh: 5; url = index.html");
    
}else{
    
    echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";

    #Creamos botón para volver ao menú principal

    echo "

    <form name='formulario' method='post' action='menu_admin_form.php'>

    <button type='submit' name='volver' ><b>Volver menú admin</b></button>

    </form>

    ";
}


#Si escolle modificar vehículos do aluguer vimos á seguinte opción
if (isset($_REQUEST['modificar_aluguer'])){
    #Mostramos formulario para que o admin introduzca o modelo do que quere modificar os datos
    echo "
        <html>
            <head>
                <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                <title>Modificación datos vehículos</title>
            </head>

            <body>
                
                <h2>Páxina de modificación de vehículos aluguer</h2>

                <form name='mod_veh_aluguer' method='POST' action='modificar_veh_admin.php'>
                    
                    <p>Modelo <input type='text' name='modelo_modificarA' placeholder='Introduzca modelo a modificar' value=''> </p>
                    <br/><br/>
                    
                    <button type='submit' name='mod_veh' ><b>Seleccionar modelo</b></button>
                </form>
                

            </body>
        </html>";

}



#Ao pulsar o botón de seleccionar modelo na opcion de modificar veh_aluguer...
if (isset($_REQUEST['mod_veh'])){

    #Recollemos o modelo seleccionado 
    $modelo= $_REQUEST['modelo_modificarA'];

   
    #Facemos consulta á base de datos para ver se existe o modelo introducido
    $select_modelo = "SELECT * from vehiculo_aluguer where modelo= '$modelo'";

    $result_modelo = mysqli_query($mysqli_link, $select_modelo);
    $num_filas = $result_modelo->num_rows;


    #Se existe o modelo...
    if ($num_filas > 0){
        
        #Recollemos os datos do modelo seleccionado
        while ($fila = mysqli_fetch_array($result_modelo, MYSQLI_ASSOC)) {
            echo "<br/>";
            $modelo = $fila['modelo'];
            $cantidade = $fila['cantidade'];
            $descricion = $fila['descricion'];
            $marca = $fila['marca'];
            $prezo = $fila['prezo'];
            $foto = $fila['foto'];
        

        }

        #Creamos formulario para a modificación de datos.

        echo "
            <html>

            <h1>Modificación de Datos de vehículo aluguer</h1>

            <h5> Cambia os datos que queiras modificar</h5>

            <form name='formulario' method='post' action='mod_datos_veh.php' >
                <!-- O nome do modelo non se pode modificar -->
                <p>Modelo <input type='text' name='modelo' readonly value='$modelo'>>  </p>
                <p>Cantidade <input type='text' name='cantidade_novo' placeholder='Introduzca nova cantidade' value='$cantidade'> </p>
                <p>Descricion <input type='text' name='descricion_novo' placeholder='Introduzca nova descricion' value='$descricion'> </p>
                <p>Marca <input type='text' name='marca_novo' placeholder='Introduzca nova marca' value='$marca'> </p>
                <p>Prezo <input type='text' name='prezo_novo' placeholder='Introduzca novo prezo' value='$prezo'> </p>
                <p>Foto <input type='text' name='foto_novo' placeholder='Introduzca nova foto' value='$foto'> </p>
            

                <button type='submit' name='mod_datos_aluguer' >Modificar datos</button>
                <br/>
                
            </form>

            </html>";



    }
    else{

        echo "O modelo introducino non existe na base de datos.</br>";
        
        echo "Se desexa introducir un novo vehículo, selecciona o botón de <b>Añadir novos vehículos para alugar</b> do menú admin.</br>";
        echo "Volvendo ao menú admin...";
        mysqli_close($mysqli_link);
        header("refresh: 5; url = menu_admin_form.php");
    }
    

    
}

#Si escolle modificar vehículos da venda...
if (isset($_REQUEST['modificar_venda'])){
    #Mostramos formulario para que o admin introduzca o modelo do que quere modificar os datos
    echo "
        <html>
            <head>
                <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                <title>Modificación datos vehículos venda</title>
            </head>

            <body>
                
                <h2>Páxina de modificación de vehículos venda</h2>

                <form name='mod_veh_venda' method='POST' action='modificar_veh_admin.php'>
                    
                    <p>Modelo <input type='text' name='modelo_modificarV' placeholder='Introduzca modelo a modificar' value=''> </p>
                    <br/><br/>
                    
                    <button type='submit' name='mod_vehV' ><b>Seleccionar modelo</b></button>
                </form>
                

            </body>
        </html>";

}



#Ao pulsar o botón de seleccionar modelo...
if (isset($_REQUEST['mod_vehV'])){

    #Recollemos o modelo seleccionado 
    $modelo= $_REQUEST['modelo_modificarV'];

   
    #Facemos consulta á base de datos para ver se existe o modelo introducido
    $select_modelo = "SELECT * from vehiculo_venda where modelo= '$modelo'";

    $result_modelo = mysqli_query($mysqli_link, $select_modelo);
    $num_filas = $result_modelo->num_rows;


    #Se existe o modelo...
    if ($num_filas > 0){
        
        #Recollemos os datos do modelo seleccionado
        while ($fila = mysqli_fetch_array($result_modelo, MYSQLI_ASSOC)) {
            echo "<br/>";
            $modelo = $fila['modelo'];
            $cantidade = $fila['cantidade'];
            $descricion = $fila['descricion'];
            $marca = $fila['marca'];
            $prezo = $fila['prezo'];
            $foto = $fila['foto'];
        

        }

        #Creamos formulario para a modificación de datos.

        echo "
            <html>

            <h1>Modificación de Datos de vehículo venda</h1>

            <h5> Cambia os datos que queiras modificar</h5>

            <form name='formulario' method='post' action='mod_datos_veh.php' >
                <!-- O nome do modelo non se pode modificar -->
                <p>Modelo <input type='text' name='modelo' readonly value='$modelo'>>  </p>
                <p>Cantidade <input type='text' name='cantidade_novo' placeholder='Introduzca nova cantidade' value='$cantidade'> </p>
                <p>Descricion <input type='text' name='descricion_novo' placeholder='Introduzca nova descricion' value='$descricion'> </p>
                <p>Marca <input type='text' name='marca_novo' placeholder='Introduzca nova marca' value='$marca'> </p>
                <p>Prezo <input type='text' name='prezo_novo' placeholder='Introduzca novo prezo' value='$prezo'> </p>
                <p>Foto <input type='text' name='foto_novo' placeholder='Introduzca nova foto' value='$foto'> </p>
            

                <button type='submit' name='mod_datos_venda' >Modificar datos</button>
                <br/>
                
            </form>

            </html>";



    }
    else{

        echo "O modelo introducido non existe na base de datos.</br>";
        
        echo "Se desexa introducir un novo vehículo, selcciona o botón de <b>Añadir novos vehículos para a venda</b> do menú admin.</br>";
        echo "Volvendo ao menú admin...";
        mysqli_close($mysqli_link);
        header("refresh: 5; url = menu_admin_form.php");
    }
    

    
}

?>