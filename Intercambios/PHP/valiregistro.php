<?php
    
    //---------------------------- ENVIAR CORREO DE CONFIRMACIÓN ---------------------------------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Recursos/Exception.php';
require 'Recursos/PHPMailer.php';
require 'Recursos/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
//Configuración del envio de correo

//Recolección de datos del formulario e inserccion a la base de datos
    $nombre = $_POST['nombre'];     //Variables ligadas al formulario registro.html
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['password'];
    $alias = $_POST['alias'];
    $telefono = $_POST['telefono'];
    var_dump("12222"); 

    session_start();
    $_SESSION['usuario']=$usuario;  //Almacenar datos del usuario
    include('db.php');              //Inicio de sesion

    $consulta_usuario="SELECT*FROM usuarios where usuario='$usuario'";
    $resultado=mysqli_query($conexion,$consulta_usuario);
    $filas=mysqli_num_rows($resultado);
    

    if($filas){
        //header("location:../registro.html");
        echo'<script type="text/javascript"> alert("El usuario ya existe");
        window.location.href="../registro.html";</script>';     
        //header("location:../registro.html");
        //echo "<script>alert('Usuario ya existe');</script>";
        
    }
    else{
        $inserta = "INSERT INTO usuarios(usuario,password,Nombre,APpaterno,APmaterno,Alias,Telefono)VALUES('$usuario','$contrasena','$nombre','$apaterno','$amaterno','$alias','$telefono')" ;
        mysqli_query($conexion,$inserta);
        var_dump("12222"); die();
        try {
            //Server settings
            $mail->SMTPDebug = 2;                      // Enable verbose debug output
            $mail->IsSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'intercambiosnavidad2020@gmail.com';                     // SMTP username
            $mail->Password   = 'Navidad@20';                               // SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPSecure= 'tls';
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
            $mail->setFrom('intercambiosnavidad2020@gmail.com', 'Intercambios');
            $mail->addAddress($usuario, $nombre);     
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Registro';
            $mail->Body    = '¡Hola Bienvenido! \n Ahora podras realizar los intercambios con tus amigos';
            $mail->send();
            
            
            echo 'El mensaje se envió correctamente';
        } catch (Exception $e) {
            echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
        }

        echo "¡El registro fue exitoso!";
        header("location:../index.html");
    }



/*
try {
    //Server settings
    $mail->SMTPDebug = 2;                      // Enable verbose debug output
    $mail->IsSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'intercambiosnavidad2020@gmail.com';                     // SMTP username
    $mail->Password   = 'Navidad@20';                               // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->SMTPSecure= 'tls';
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    

    //Recipients
    $mail->setFrom('intercambiosnavidad2020@gmail.com', 'Intercambios');
    $mail->addAddress($usuario, $nombre);     // Add a recipient
    /*               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');*/

    // Attachments
    /*
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    */
/*    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Registro';
    $mail->Body    = '¡Hola Bienvenido! \n Ahora podras realizar los intercambios con tus amigos';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
    $mail->send();
    
    
    echo 'El mensaje se envió correctamente';
} catch (Exception $e) {
    echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
}
*/
