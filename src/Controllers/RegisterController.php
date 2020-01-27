<?php
namespace Src\Controllers;
require __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Src\Models\User;
use Slim\Views\Twig as View;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Database\Capsule\Manager;
namespace App;

use Illuminate\Database\Eloquent\Model;
use Slim\App;


class RegisterController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'register.twig');
    }

    public function register($request, $response)
    {
        //register user in db
//        $app = new \Slim\Slim();
//        $app->post('/register', function ($request, $response){ //How it is supposed to be
        $first_name = $request->getParam('txtFirstName');
        $last_name 	= $request->getParam('txtLastName');
        $email 	= $request->getParam('txtEmail');
        $password 	= md5($request->getParam('txtPassword'));
        $created_at = date("Y/m/d");
        $updated_at = date("Y/m/d");

        User::create([ //STORE IN DB
            'name' => $first_name,
            'email' => $email,
            'password' => $password,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'verified' => 0
        ]);

        $this->send_verification_email($email);
//        });
    }


    public function send_verification_email($email) //Works with MailTrap
    {
//         Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true); // Send via MailTrap

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = '9d95a851dedfe4';                     // SMTP username
            $mail->Password = '99a15b9c4d36b0';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 2525;             // TCP port to connect to

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email, 'Joe User');     // Add a recipient
            $mail->addAddress($email);               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            // Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Please verify your profile';
            $mail->Body = 'Please click <b><a href="http://localhost:9999/register/verify">on this link</a></b> to verify your profile. ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            header('Location: ' . $_SERVER['REQUEST_URI'] . '/checkMail');
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function checkMail($request, $response)
    {
        return $this->view->render($response, 'checkMail.twig');
    }

    public function verify($request, $response)
    {
        //update VERIFIED field in db
//        $app = new \Slim\Slim();
//        $app->get('/register/verify', function ($request, $response){ //How it is supposed to be
            $user = $this->table('users')->update('verified', 1)->where('id', $request->id);

            User::where('id', $response->id)->update(['verified' => 1]);
            return $this->view->render($response, 'verifyEmail.twig');
//    });
    }
}
