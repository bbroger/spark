<?php

return [
    'showValidationRules' => true,

    'messages' => [
        'notBlank' => 'O campo {{name}} é obrigatório.',
        'notEmpty' => 'O campo {{name}} é obrigatório.',

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