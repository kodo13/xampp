<?php

#Recogemos variables del  formulario de rexistro.

$modelo = $_REQUEST['modelo_novo'];
$cantidade = $_REQUEST['cantidade_novo'];
$descricion = $_REQUEST['descricion_novo'];
$marca = $_REQUEST['marca_novo'];
$prezo = $_REQUEST['prezo_novo'];
$foto = $_REQUEST['foto_novo'];


#Creamos la conexión con la base de datos

$mysqli_link = mysqli_connect("localhost","root","","frota");
mysqli_set_charset($mysqli_link, "utf8");

#Si hay algún error, se sale del programa

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}



#Comrobamos que todas las variables existan y no estén vacías.
if ((isset($modelo)) && (isset($cantidade)) && (isset($descricion)) && (isset($marca)) && (isset($prezo)) && (isset($foto))) {

    
    #Facemos comprobación de si existe ese mismo modelo, si existe, simplemente actualizamos a cantidade

    $select_modelo= "SELECT * from vehiculo_aluguer where modelo='$modelo'";
    $result_modelo = mysqli_query($mysqli_link, $select_modelo);

    $num_filas = $result_modelo->num_rows;

    if ($num_filas > 0){
        #Si existen vehículos, á cantidade que había se lle suman as cantidades do rexistro.
        $update="UPDATE `vehiculo_aluguer` SET cantidade=cantidade +$cantidade where modelo='$modelo'";
        
        if (mysqli_query($mysqli_link, $update)) {
            echo "Xa existe ese modelo rexistrado, actualizamos as cantidades do modelo $modelo. </br> </br>" ;
            echo "Volvendo ao menú de admin";
            header("refresh: 5; url = menu_admin_form.php");
        } else {
            echo "Error ao actualizar cantidades, volvendo ao menú de admin";
            header("refresh: 5; url = menu_admin_form.php");
        }
        
    }

    else{

        #El modelo no existe y hacemos las inserciones en la tabla vehiculo_aluguer.

        $insert = "INSERT INTO vehiculo_aluguer (modelo, cantidade, descricion, marca, prezo, foto) VALUES ('$modelo','$cantidade','$descricion','$marca','$prezo','$foto')";

        #Ejecutamos la inserción y comprobamos si se hace correctamente.
        if (mysqli_query($mysqli_link, $insert)) {
            echo "Vehículo novo rexistrado correctamente! </br>";
            echo "Volvendo ao menú de admin";
            header("refresh: 5; url = menu_admin_form.php");
            
        } else {
            echo "Erro ao facer o rexistro do novo vehículo...Volviendo ao menú admin";
            header("refresh: 5; url = menu_admin_form.php");
        }

    }


    
    

}

else{
    echo "hola?";
    #Salta aquí si falta algún dato por introducir.
    echo "Faltan datos por introducir! Volviendo al registro";
    header("refresh: 3; url = rexistro.html");
}



# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>