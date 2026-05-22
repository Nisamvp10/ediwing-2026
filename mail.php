<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vinsafesolution@gmail.com';
    $mail->Password   = 'fggjklolygaahlwj'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;



    $response = [];

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$phone || !$message) {

        $errors = [];

        if (!$name) $errors['name'] = 'Name is required';
        if (!$email) $errors['email'] = 'Email is required';
        if (!$phone) $errors['phone'] = 'Phone is required';
        if (!$message) $errors['message'] = 'Message is required';

        echo json_encode([
            'status' => false,
            'errors' => $errors
        ]);
       // exit;
    }else{

        // Recipients
        $mail->setFrom('vinsafesolution@gmail.com', 'Eduwing');

        $mail->addAddress('nisamvp10@gmail.com');

        // Content
        $mail->isHTML(true);
            $mail->Subject = 'New Enquiery Frm website';

        $mail->Body = "
            <h3>New Enquiry</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Phone:</b> $phone</p>
            <p><b>Message:</b> $message</p>
        ";

        if($mail->send()){
         
        // set a responsive message 
        $html ='<div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:10px;">

                <h2 style="color:#333;">Thank you for contacting Eduwing</h2>

                <p>Hi '.$name.',</p>

                <p>Thank you for connecting with us! 🙌</p>

                <p>We have received your message and will get back to you as soon as possible.</p
              
                <p>Thanks & Regards,<br><b>Your Team</b></p>

            </div>';

            $mail->addAddress($email);
            $mail->Subject = 'Thank you for contacting Eduwing';
            $mail->Body = $html;
            $mail->send();
               $response =  [
                    'status' => true,
                    'message' => 'Mail sent successfully'
                ];
                
        }else {
            $response =   [
                'status' => false,
                'message' => 'Mail not sent'
            ];
        }
        echo json_encode($response);

    }
}