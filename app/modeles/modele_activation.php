<?php

function get_fieldConfig()
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

?>