<?php

Respect\Validation\Validator::with('App\Validation\Rules');

return [
    'showValidationRules' => false,

    /**
     * Default messages.
     */
    'messages' => [
        'notBlank' => 'O campo {{name}} é obrigatório.',
        'notEmpty' => 'O campo {{name}} é obrigatório.',
        'email' => 'O campo {{name}} precisa ter um e-mail válido.',
        'length' => 'O campo {{name}} precisa ter um tamanho entre {{minValue}} e {{maxValue}}.',
        'uniqueField' => 'O valor do campo {{name}} já está sendo utilizado.',
        'uploaded' => 'O campo {{name}} precisa conter um arquivo.',
        'image' => 'O campo {{name}} precisa conter uma imagem.',

        /**
         * Default custom messages for attributes.
         * 
         * If the validator don't matches custom messages for attributes
         * on validate() method, the validator search here.
         */
        'custom' => [
            'example' => 'O corpo precisa ser numérico e preenchido.',

            'example.notBlank' => 'Preencha este campo.',

            'example' => [
                // The last is the matched
                'notBlank' => 'customized-message'
            ]
        ]
    ],

    'attributes' => [
        'example' => 'exemplo'
    ]
];
