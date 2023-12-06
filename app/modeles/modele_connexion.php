<?php

function get_fieldConfig()
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

?>