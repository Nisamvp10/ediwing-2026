<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$errors = [];

if(isset($_POST['send'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $message = trim($_POST['message']);
    if(isset($name) && empty($name)) {
        $errors['name'] = 'Name is required';
    }
    if(isset($email) && empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if(isset($phone_number) && empty($phone_number)) {
        $errors['phone_number'] = 'Phone number is required';
    }
    if(isset($message) && empty($message)) {
        $errors['message'] = 'Message is required';
    }
    $mail = new PHPMailer();
    $mail->isSMTP();
    

    if(count($errors) > 0) {
        echo json_encode(['status' => 'error', 'validate' => $errors]);
    } else {
        $to      = 'londoncollege5005@gmail.com';
        $subject = 'Enquiry form';
       $message = 'Message: ' . $message;

        $html = '<table border="1" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th colspan="2">Enquiry form</th>
            </tr>
        </thead>
        <tbody>
            <tr style="padding:10px;">
                <td>Name</td>
                <td style="padding:10px;">'.$name.'</td>
            </tr>
            <tr style="padding:10px;">
                <td>Email</td>
                <td>'.$email.'</td>
            </tr>
            <tr style="padding:10px;">
                <td>Phone number</td>
                <td style="padding:10px;">'.$phone_number.'</td>
            </tr>
            <tr style="padding:10px;">
                <td>Message</td>
                <td>'.$message.'</td>
            </tr>
        </tbody>
        </table>';
        

        $mail->isHTML(true);
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'londoncollege5005@gmail.com';
        $mail->Password = 'bvnczuehveijbvws';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->From = $email;
        $mail->FromName = $name;
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $html;
        if($mail->send()) {
            echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Form not submitted']);
        }

    }
    
}