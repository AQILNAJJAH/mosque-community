<?php
    if(isset($_POST['reset'])) {
        $email = $_POST['email'];
    }
    else {
        exit();
    }
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'main/Exception.php';
    require 'main/PHPMailer.php';
    require 'main/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'NN@YAHOO.COM';                     //SMTP username
    $mail->Password   = 'MLIWHSKJOIH';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('NN@YAHOO.COM', 'Admin');
    $mail->addAddress($email);     //Add a recipient

    $code = substr(str_shuffle('KKK'),0,10);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body    = 'To reset your password click <a href="http://localhost/fyp/change_password.php?code='.$code.'">here </a>. </br> Reset your 
    password in a day.';

    $conn = mysqli_connect('localhost', 'root', '', 'mosque', 3308);

    if($conn->connect_error){
        die('Could not connect to the database.');
    }

    $verifyQuery = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if($verifyQuery->num_rows){
        $codeQuery = $conn->query("UPDATE users SET code = '$code' WHERE email = '$email'");

        $mail->send();
        echo 'Message has been sent';
    }
    $conn->close();
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>