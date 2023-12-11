<?php

function get_fieldConnexionConfig()
{
    return [
        'connexion_pseudo' => [
            'requis' => true,
            'type' => 'pseudo',
            'minLength' => 2,
            'maxLength' => 255,
            'tableField' => 'uti_pseudo'
        ],
        'connexion_motDePasse' => [
            'requis' => true,
            'minLength' => 8,
            'maxLength' => 72,
            'type' => 'motDePasse',
            'tableField' => 'uti_motdepasse'
        ]
    ];
}

function get_fieldActivationConfig()
{
    return [
        'activation_utilisateurId' => [
            'tableField' => 'uti_id',
            'type' => 'id'
        ],
        'activation_code' => [
            'requis' => true,
            'type' => 'activationCode',
            'minLength' => 5,
            'maxLength' => 5,
            'tableField' => 'uti_code_activation',
            'activedField' => 'uti_compte_active'
        ]
    ];
}

function get_fieldInscriptionConfig()
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