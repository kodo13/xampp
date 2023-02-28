<?php


#Creamos la conexión con la base de datos

$mysqli_link = mysqli_connect("localhost","root","","frota");
mysqli_set_charset($mysqli_link, "utf8");

#Si hay algún error, se sale del programa

if (mysqli_connect_errno()){
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}



#Se escolleu a opción de eliminar vehiculos do aluguer
if (isset($_REQUEST['eliminar_alu'])){
    $modelo = $_REQUEST['modelo_eliminar']; 
    $cantidade = $_REQUEST['cantidade_eliminar']; #Recollemos a cantidade a retirar introducida polo admin

    #Si se cubriron os campos...
    if (isset($modelo) && isset($cantidade)){

        
        $select_eliminar = "SELECT * from vehiculo_aluguer where modelo='$modelo'";
        $result_eliminar = mysqli_query($mysqli_link,$select_eliminar);
        $num_filas = $result_eliminar->num_rows;

        $fila = mysqli_fetch_array($result_eliminar, MYSQLI_ASSOC);

        #Gardamos a cantidade introducida polo admin
        $cant = $fila['cantidade'];
        
        #Gardamos na variable resto o número de vehículos que quedan.
        $resto=$cant-$cantidade;
    
        if ($num_filas>0){

            #Si é maior que 0, é que a consulta devolveu valores o que significa que hai unidades dese modelo.

            //Si a cantidade introducida é menor que a que temos...
            if ($cantidade < $cant){
                #Actualizamos á cantidade
                $u="UPDATE vehiculo_aluguer SET cantidade=$resto where modelo='$modelo'";

                $result_u = mysqli_query($mysqli_link,$u);

                #Si se realiza correctamente o update...
                if ($result_u){

                    echo "</br> Quitáronse ".$cantidade." cantidades do modelo ".$modelo.", quedan ".$resto." </br>";
                    
                    echo "Volvendo ao menú do admin...";
                    mysqli_close($mysqli_link);

                    header("refresh: 5; url = menu_admin_form.php");

                }
                else{
                    echo "Algo fallou...<br>";
                    echo "Volvendo ao menú do admin...";
                    mysqli_close($mysqli_link);

                    header("refresh: 5; url = menu_admin_form.php");
                }
                    


            }


            #Si a cantidade introducida é maior que a cantidade que existe...
            elseif ($cantidade > $cant){
                #OLLO!! En SET cantidade='cantidade - $cantidade' --> non poñer comillas senón da erro
                $update="UPDATE vehiculo_aluguer SET cantidade=cantidade - $cant where modelo='$modelo'";
                $result_update= mysqli_query($mysqli_link,$update);
                
                #Comprobamos resultado do update
                if ($result_update){
                    
                    echo "Quitáronse ".$cant." cantidades do modelo ".$modelo.", non ".$cantidade." xa que non había tantas unidades. </br>";
                    
                    #Eliminamos o modelo que quedou a 0
                    $delete="DELETE FROM vehiculo_aluguer WHERE cantidade=0 and modelo = '$modelo'";
                    $result_delete = mysqli_query($mysqli_link,$delete);

                    if ($result_delete){
                        echo "Non quedan cantidades...Eliminando o vehículo $modelo da base de datos...</br>";

                        echo "Volvendo ao menú do admin...";
                        mysqli_close($mysqli_link);

                        header("refresh: 5; url = menu_admin_form.php");
                    }

                }
            

            }
            #Senón, queda a opción de que a cantidade introducida é a mesma que a existente.
            else{
                $update2="UPDATE vehiculo_aluguer SET cantidade=0 where modelo='$modelo'";
                $result_update2= mysqli_query($mysqli_link,$update2);
            
                if ($result_update2){
                    
                    echo "Quitáronse ".$cantidade." cantidades do modelo ".$modelo.", que eran as que había en total </br>";
                    

                    $delete2="DELETE FROM vehiculo_aluguer WHERE cantidade=0 and modelo = '$modelo'";
                    $result_delete2 = mysqli_query($mysqli_link,$delete2);

                    if ($result_delete2){
                        echo "Xa non quedan cantidades...Eliminando o vehículo $modelo da base de datos...</br>";

                        echo "Volvendo ao menú do admin...";
                        mysqli_close($mysqli_link);

                        header("refresh: 5; url = menu_admin_form.php");
                    }
                }

            }
        }
        else{

            echo "Xa non existe ese modelo na base de datos! </br>";
            echo "Volvendo ao menú do admin...";
            mysqli_close($mysqli_link);

            header("refresh: 5; url = menu_admin_form.php");

        }
    }
    else{
        #Se non se cubriron os campos, avisamos e volvemos ao menú do admin
        echo "Faltaron campos por cubrir ou non son válidos...</br>";
        echo "Volvendo ao menú do admin...";
        mysqli_close($mysqli_link);

        header("refresh: 5; url = menu_admin_form.php");
    }
}


#Se escolleu a opción de eliminar vehiculos da venda
if (isset($_REQUEST['eliminar_ve'])){

    #Recollemos os datos introducidos polo admin 
    $modelo = $_REQUEST['modelo_eliminarV']; 
    $cantidade = $_REQUEST['cantidade_eliminarV'];

    #Si se cubriron os campos...
    if (isset($modelo) && isset($cantidade)){
         #Cantidade a retirar introducida polo admin

    
        $select_eliminar = "SELECT * from vehiculo_venda where modelo='$modelo'";
        $result_eliminar = mysqli_query($mysqli_link,$select_eliminar);
        $num_filas = $result_eliminar->num_rows;
        $fila = mysqli_fetch_array($result_eliminar, MYSQLI_ASSOC);

        #Guardamos la cantidade actual del modelo introducido por el admin
        $cant = $fila['cantidade'];
        
        #Gardamos na variable resto o número de vehículos que quedan.
        $resto=$cant-$cantidade;
    
        if ($num_filas>0){

            #Si é maior que 0, é que a consulta devolveu valores o que significa que hai unidades dese modelo.

            //Si a cantidade introducida é menor que a que temos...
            if ($cantidade < $cant){

                $u="UPDATE vehiculo_venda SET cantidade=$resto where modelo='$modelo'";

                $result_u = mysqli_query($mysqli_link,$u);

                #Si se realiza correctamente o update...
                if ($result_u){

                    echo "</br> Quitáronse ".$cantidade." cantidade/s do modelo ".$modelo.", quedan ".$resto." </br>";
                    
                    echo "Volvendo ao menú do admin...";
                    mysqli_close($mysqli_link);

                    header("refresh: 5; url = menu_admin_form.php");

                }
                else{
                    echo "Algo fallou...<br>";
                    echo "Volvendo ao menú do admin...";
                    mysqli_close($mysqli_link);

                    header("refresh: 5; url = menu_admin_form.php");
                }
                    


            }


            #Si la cantidad que se quiere quitar es mayor a la que tenemos...
            elseif ($cantidade > $cant){
                #OLLO!! En SET cantidade='cantidade - $cantidade' --> non poñer comillas, senón da erro.
                $update="UPDATE vehiculo_venda SET cantidade=cantidade - $cant where modelo='$modelo'";
                $result_update= mysqli_query($mysqli_link,$update);
                
                if ($result_update){
                    
                    echo "Quitáronse ".$cant." cantidades do modelo ".$modelo.", non ".$cantidade." xa que non había tantas unidades. </br>";
                    

                    $delete="DELETE FROM vehiculo_venda WHERE cantidade=0 and modelo = '$modelo'";
                    $result_delete = mysqli_query($mysqli_link,$delete);

                    if ($result_delete){
                        echo "Non quedan cantidades...Eliminando o vehículo $modelo da base de datos...</br>";

                        echo "Volvendo ao menú do admin...";
                        mysqli_close($mysqli_link);

                        header("refresh: 5; url = menu_admin_form.php");
                    }

                }
            

            }
            #Senón, a cantidade introducida é a mesma que a que temos
            else{
                $update2="UPDATE vehiculo_venda SET cantidade=0 where modelo='$modelo'";
                $result_update2= mysqli_query($mysqli_link,$update2);
            
                if ($result_update2){
                    
                    echo "Quitáronse ".$cantidade." cantidades do modelo ".$modelo.", que eran as que había en total </br>";
                    

                    $delete2="DELETE FROM vehiculo_venda WHERE cantidade=0 and modelo = '$modelo'";
                    $result_delete2 = mysqli_query($mysqli_link,$delete2);

                    if ($result_delete2){
                        echo "Xa non quedan cantidades...Eliminando o vehículo $modelo da base de datos...</br>";

                        echo "Volvendo ao menú do admin...";
                        mysqli_close($mysqli_link);

                        header("refresh: 5; url = menu_admin_form.php");
                    }
                }

            }
        }
        else{

            echo "Xa non existe ese modelo na base de datos! </br>";
            echo "Volvendo ao menú do admin...";
            mysqli_close($mysqli_link);

            header("refresh: 5; url = menu_admin_form.php");

        }
    }
    else{
        #Se non se cubriron os campos, avisamos e volvemos ao menú do admin
        echo "Faltaron campos por cubrir ou non son válidos...</br>";
        echo "Volvendo ao menú do admin...";
        mysqli_close($mysqli_link);

        header("refresh: 5; url = menu_admin_form.php");
    }
}


# pechamos a conexión co MySQL
mysqli_close($mysqli_link);

?>
    

