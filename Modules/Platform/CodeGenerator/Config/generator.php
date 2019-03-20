<?php

return [
    'setup' => [

        /**
         * Module Name
         */
        'module_name' => 'Testimonials',

        /**
         * Singular module Name
         */
        'singular_name' => 'Testimonials',

        /**
         * If set to true. Visibility of records in module will be limited with "Assigned TO" field (User or Group)
         */
        'entity_private_access' => false,

        /**
         * Entities definition
         */
        'entity' => [
            'Testimonial' => [

                /**
                 * Entity name
                 */
                'name' => 'Testimonial',

                /**
                 * Entity database table name
                 */
                'table' => 'testimonials',

                /**
                 * main - Main entity of module.
                 * settings - Dictionary entity of module
                 */
                'type' => 'main',

                /**
                 * HasMorphOwner trait will be added to entity
                 */
                'ownable' => false,

                /**
                 * LogsActivity trait will be added to entity
                 */
                'activity' => false,

                /**
                 * Commentable trait will be added to entity
                 */
                'comments' => true,

                /**
                 * HasAttachment trait will be added to entity
                 */
                'attachments' => true,

                'properties' => [

                    /**
                     * Definition of section in show|create|edit
                     */
                    'information' => [

                        'product_id' => [
                            'type' => 'manyToOne', // Relation Type
                            'relation' => 'product', // relation name
                            'display_column' => 'name', // Visible field in form and show view
                            'belongs_to' => 'Product' // Belongs To
                        ],
                        'contact_id' => [
                            'type' => 'manyToOne', // Relation Type
                            'relation' => 'contact', // relation name
                            'display_column' => 'full_name', // Visible field in form and show view
                            'belongs_to' => 'Contact' // Belongs To
                        ],

                    ],

                    'comment' => [
                        'comment' => ['type' => 'text'],
                    ],

                ]
            ],
        ]

    ]
];
