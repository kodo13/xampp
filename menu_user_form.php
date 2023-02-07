<?php

#iniciamos la sesión para mostrar la sesión del usuario.
session_start();

#Mostramos sesión del usuario.
echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";


echo "<div align='right'>
        <form name='formulario2' method='post' action='mod_datos_form.php'>
            <button type='submit' name='modificar' >Modificar os meus datos</button>
            <button type='submit' name='cerrar' >Cerrar sesión</button>
            <br/>

        </form>
        </div>";

?>


<html>
    <head>
        <title>Menú user</title>
    </head>

    <body>
   
    <h2>Menú do usuario!</h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!--Formulario en el cual tenemos solo los botones de listar los vehiculos -->
        <form  name="formulario" method="post" action="lista_vehiculos.php">
            <button type="submit" name="lista_aluguer" >Lista coches e motos en <b>aluguer</b></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" name="lista_venda" >Lista coches e motos á <b>venda</b></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </form>

        <!--Formulario en el cual tenemos los botones de alugar, comprar ou devolver vehiculos. -->
        <form  name="formulario" method="post" action="menu_user.php">

            
            <button type="submit" name="aluguer" >Ir a <b>aluguer de vehículos</b></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
            <button type="submit" name="venda" >Ir a <b>compra vehículos</b></button>
            
           
            </br></br></br>
            <button type="submit" name="devolucion" >Devolver vehículo <b>alugado</b></button>
            
            

        </form>


        <br></br>
        
        
        
    </body>



</html>