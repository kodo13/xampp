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



#Hacemos la consulta a la BBDD para comprobar si existe el usuario.
$select_query = "SELECT usuario from usuario where usuario='$usuario'";

$result = mysqli_query($mysqli_link, $select_query);


#Si el resultado es true, entra al if, si no , saltamos al else.
    #Comprobamos el número de filas de la consulta, si no se devuelve nada, es que no existe el usuario con esa contraseña.

$num_filas = $result->num_rows;

#Si es mayor que 0, es que la consulta ha devuelto algún valor.

if ($num_filas > 0) {

    #Comprobamos si existe el par de usuario y contraseña.
    $select_query2 = "SELECT usuario from usuario where usuario='$usuario' and contrasinal='$contrasinal'";

    $result2 = mysqli_query($mysqli_link, $select_query2);

    $num_filas2 = $result2->num_rows;
    
    if ($num_filas2 > 0) {


        session_start();
        $_SESSION['usuario'] = $usuario;

        echo "Bienvenido <b>$usuario</b>, estás dentro. Redirigiendo al <i>menú de usuario</i> en 5 segundos...<br></br>";
        echo "<img src='/cars/welcome.jpeg' border='0' width='500' height='500'>";
        header("refresh: 5; url = menu_user_form.php");
    }
    else {

        #Si existe el usuario pero no está bien la contraseña.
        echo "<img src='/cars/fail.png' border='0' width='500' height='300'>";
        echo "<br/> La contraseña introducida no es correcta, inténtalo de nuevo en 5 segundos. ";
        header("refresh: 5; url = index.html");
    }
}
#Si no devuelve nada, el usuario no existe en la tabla usuario. 

else {

    echo "No existe ninguna cuenta creada con el usuario $usuario, serás redirigido en 5 segundos al registro. ";
    header("refresh: 5; url = rexistro.html");
}





# pechamos a conexión co MySQL

mysqli_close($mysqli_link);


?>

