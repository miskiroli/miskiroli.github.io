<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adatok gyűjtése az űrlapról
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Email küldése
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.google.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'miski.roland91@gmail.com';                     
        $mail->Password = $_ENV['SMTP_PASSWORD'];                          
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    

        // Email beállítások
        $mail->setFrom('miski.roland91@gmail.com', 'Your Name');
        $mail->addAddress('your-email@example.com', 'Recipient Name');

        // Email tartalma
        $mail->isHTML(true);                                  
        $mail->Subject = 'Message from your website';
        $mail->Body    = "Name: $name <br> Email: $email <br> Phone: $phone <br> Message: $message";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
