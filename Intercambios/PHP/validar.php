<?php
var_dump("12222"); die();
$usuario=$_POST['usuario'];
$contrasena=$_POST['password'];
session_start();
$_SESSION['usuario']=$usuario;
include('db.php');
$consulta="SELECT*FROM usuarios where usuario='$usuario' and password='$contrasena'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_num_rows($resultado);
if($filas){
    header("location:../home.html");
}else{
   
    header("location:../index.html");
}
mysqli_free_result($resultado);
mysqli_close($conexion);
