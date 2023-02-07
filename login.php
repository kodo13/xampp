<?php
#Header para la correcta visualización y tratamiento de las tildes y ñ.

header("Content-Type: text/html;charset=utf-8");


$usuario = $_REQUEST['usuario'];
$contrasinal = $_REQUEST['contrasinal'];

#Creamos la conexión con la base de datos

$mysqli_link = mysqli_connect("localhost","root","","frota");

#Indicamos el modelo de caracteres a usar.

mysqli_set_charset($mysqli_link, "utf8");

#Si hay algún error, se sale del programa

if (mysqli_connect_errno())
{
    printf("La conexión con MySQL ha fallado con error: %s",
        mysqli_connect_error());
    exit;
}



#Hacemos la consulta a la BBDD para comprobar si existe el usuario. Aparte, comprobamos el tipo de usuario para ir a un menú u otro.
$select_query = "SELECT usuario from usuario where usuario='$usuario'";



$result = mysqli_query($mysqli_link, $select_query);


#Si el resultado es true, entra al if, si no , saltamos al else.
    #Comprobamos el número de filas de la consulta, si no se devuelve nada, es que no existe el usuario con esa contraseña.

$num_filas = $result->num_rows;

#Si es mayor que 0, es que la consulta ha devuelto algún valor.

if ($num_filas > 0) {

    #Comprobamos si existe el par de usuario y contraseña.
    $select_query2 = "SELECT usuario from usuario where usuario='$usuario' and contrasinal='$contrasinal' and tipo_usuario='a'";

    $result2 = mysqli_query($mysqli_link, $select_query2);

    $num_filas2 = $result2->num_rows;
    #Si num_filas2 es mayor que 0, es que existe ese usuario admin con esa contrasinal 
    if ($num_filas2 > 0) {

        
        session_start();
        $_SESSION['usuario'] = $usuario;

        echo "Bienvenid@ <b>$usuario</b>, estás dentro. Redirigiendo al <i>menú de admin</i> en 5 segundos...<br></br>";
        echo "<img src='/cars/welcome.jpeg' border='0' width='500' height='500'>";
        header("refresh: 5; url = menu_admin_form.php");
    }
    #Si no, es que no existe. Entonces hacemos otra consulta para ver si ese usuario existe y tiene esa contrasinal
    else {
        $select_query3 = "SELECT usuario from usuario where usuario='$usuario' and contrasinal='$contrasinal' and tipo_usuario='u'";

        $result3 = mysqli_query($mysqli_link, $select_query3);

        $num_filas3 = $result3->num_rows;
        #Si existe, num_filas3 será mayor que 0 y lo redirigimos al menú de usuario.
        if ($num_filas3 > 0) {


            session_start();
            $_SESSION['usuario'] = $usuario;
    
            echo "Bienvenid@ <b>$usuario</b>, estás dentro. Redirigiendo al <i>menú de usuario</i> en 5 segundos...<br></br>";
            echo "<img src='/cars/welcome.jpeg' border='0' width='500' height='500'>";
            header("refresh: 5; url = menu_user_form.php");
        }
        else{
            #Si existe el usuario pero no está bien la contraseña.
            echo "<img src='/cars/fail.png' border='0' width='500' height='300'>";
            echo "<br/> La contraseña introducida no es correcta, inténtalo de nuevo en 5 segundos. ";
            header("refresh: 5; url = index.html");
        }
        
        
    }
}
#Si no devuelve nada, el usuario no existe en la tabla usuario. 

else {
    #Comprobamos si existe el usuario en la táboa novo_rexistro
    $select_novo = "SELECT * from novo_rexistro where usuario='$usuario'";
    $result_novo = mysqli_query($mysqli_link, $select_novo);

    $num_filas_n = $result_novo->num_rows;

    if ($num_filas_n>0){
        echo "Existe el usuario pero estamos pendientes de la aprobación del admin</br>";
        echo "Redirigiendo al login...";
        header("refresh: 5; url = login.php");
    }
    else{
        echo "No existe ninguna cuenta creada con el usuario $usuario, serás redirigido en 5 segundos al registro. ";
        header("refresh: 5; url = rexistro.html");
    }


    
}





# pechamos a conexión co MySQL

mysqli_close($mysqli_link);


?>

