<?php

#iniciamos la sesión para mostrar la sesión del usuario.
session_start();

#Mostramos sesión del usuario.
echo "<br><div align='right'><b>Usuario:</b> ".$_SESSION["usuario"]."</div><br>";

?>


<html>
    <head>
        <title>Menú user</title>
    </head>

    <body>
        
        <h2>Menú do usuario!</h2>

        <form  name="formulario" method="post" action="menu_user.php">

            <button type="submit" name="aluguer" >Lista coches e motos en <b>aluguer</b></button>
            <br></br>
            <button type="submit" name="venta" >Lista coches e motos á <b>venda</b></button>
            <br/>
            

        </form>
        <br></br>
        
        <form name="formulario2" method="post" action="mod_datos_form.php">
            <button type="submit" name="modificar" >Modificar os meus datos</button>
            <br/>

        </form>
        
    </body>



</html>