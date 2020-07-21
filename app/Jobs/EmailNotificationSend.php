<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\User\UserRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailNotificationSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userData;

    public function __construct($userData)
    {
        $this->userData = $userData;
        // dd($this->userData);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserRepository $userData)
    {
        $fetchedUserData = $this->userData;
        foreach($fetchedUserData as $data) {
            // dd($data->email);
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                      
            $mail->isSMTP();                              // Set mailer to use SMTP
            $mail->Host = 'smtp.mailtrap.io';                
            $mail->SMTPAuth = true;                       // Enable SMTP authentication
            $mail->Username = '6fb300b5af6242';           // SMTP username
            $mail->Password = '76b0fa9166c5f7';           // SMTP password
            $mail->SMTPSecure = 'tls';                    // Enable TLS encryption
            $mail->Port = 587;      
            $mail->setFrom('rupalisatpute289@gmail.com', 'Mailer');
            $mail->addAddress($data->email);  // Add a recipient, Name is optional
            // $mail->addReplyTo('neosoft@gmail.com', 'Mailer');
            // $mail->addCC('his-her-email@gmail.com');
            // $mail->addBCC('his-her-email@gmail.com');
            //Attachments (optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   // Optional name

             //Content
            $mail->isHTML(true);
            $mail->Subject = "Hi,".$data->name."one user is looking for this products";
            $mail->Body    = "testing demo";  
             // dd($mail);
            $mail->send();

        }
        return true;
    }
}
