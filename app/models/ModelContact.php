<?php
namespace App\Models;

class ModelContact
{
    // Field configuration for the contact form
    public static function get_fieldConfig()
    {
        return [
            'fname' => [
                'required' => true, 
                'minLength' => 2,
                'maxLength' => 255
            ],
            'lname' => [
                'minLength' => 2,
                'maxLength' => 255
            ],
            'email' => [
                'required' => true, 
                'type' => 'email'
            ],
            'message' => [
                'required' => true, 
                'minLength' => 10,
                'maxLength' => 3000
            ]
        ];
    }

    //Sends an email using the provided array of information.
    public static function send_mail (array $array)
    {
        // Extract data from the provided array
        $expediteur = $array['email'];
        $message = $array['message'];
        
        // Hardcoded email settings
        $destinataire = "test@test.fr";
        $sujet = "projet web - formulaire de contact";
        
        // Email header construction
        $entete = "From: $expediteur\r\n" . 
                "To: $destinataire\r\n" . 
                "Subject: $sujet\r\n" . 
                "Content-Type: text/html; charset=\"UTF-8\"\r\n" . 
                "Content-Transfer-Encoding: quoted-printable\r\n";
        
        // Send the email
        mail($destinataire, $sujet, $message, $entete);
    }
}

?>