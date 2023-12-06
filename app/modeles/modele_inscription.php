<?php

function get_fieldConfig()
{
    return [
                'inscription_pseudo' => [
                    'requis' => true,
                    'unique' => true,
                    'tableField' => 'uti_pseudo',
                    'minLength' => 2,
                    'maxLength' => 255
                ],
                'inscription_email' => [
                    'requis' => true,
                    'unique' => true,
                    'tableField' => 'uti_email',
                    'type' => 'email'
                ],
                'inscription_motDePasse' => [
                    'requis' => true,
                    'minLength' => 8,
                    'maxLength' => 72,
                    'tableField' => 'uti_motdepasse',
                    'type' => 'motDePasse'
                ],
                'inscription_motDePasse_confirmation' => [
                    'requis' => true,
                    'minLength' => 8,
                    'maxLength' => 72,
                    'type' => 'confirm',
                    'argConfirm' => 'inscription_motDePasse'
                ]
            ];
}
?>