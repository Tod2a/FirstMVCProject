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
}

?>