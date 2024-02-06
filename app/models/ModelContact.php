<?php
namespace App\Models;

class ModelContact
{
    public static function get_fieldConfig()
    {
        return [
            'fname' => [
                'requis' => true, 
                'minLength' => 2,
                'maxLength' => 255
            ],
            'lname' => [
                'minLength' => 2,
                'maxLength' => 255
            ],
            'email' => [
                'requis' => true, 
                'type' => 'email'
            ],
            'message' => [
                'requis' => true, 
                'minLength' => 10,
                'maxLength' => 3000
            ]
        ];
    }
}

?>