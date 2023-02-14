<?php  

#Menú de admin onde elixe si admite novos usuarios ou mete novos vehículos.


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

    #Mostramos sesión del usuario.
echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";


#Botón do menú do admin que sirve para modificar os seus datos e/ou pechar sesión
echo "<div align='right'>
        <form name='formulario2' method='post' action='mod_datos_form.php'>
            <!-- <button type='submit' name='modificar' >Modificar os meus datos</button> -->
            <button type='submit' name='cerrar' >Cerrar sesión</button> 
            <br/>

        </form>
        </div>";


}

?>

<html>
    <head>
        <title>Menú admin</title>
    </head>

    <body>
   
    <h2>Menú admin!</h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       

        <form  name="formulario" method="post" action="menu_admin.php">

            
            <button type="submit" name="novos_vehiculos_aluguer" >Añadir <b>novos vehículos para alugar</b></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" name="eliminar_aluguer" ><b>Elimimar vehículos para aluguer</b></button>

            </br></br>
            <button type="submit" name="novos_vehiculos_venta" >Añadir <b>novos vehículos para vender</b></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" name="eliminar_venda" ><b>Eliminar vehículos para a venda</b></button>

            </br></br>
            <button type="submit" name="novos_users" ><b>Admitir novos usuarios</b></button>  
            
            

        </form>


        <br></br>
        
        
        
    </body>



</html>

