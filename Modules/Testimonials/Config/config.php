<?php

return [
    'name' => 'Testimonials',

    'entity_private_access' => false,

    'advanced_views' => true,


    /**
     * Always use lower name without custom characters, spaces, etc
     */
    'permissions' => [
        'testimonials.settings',
        'testimonials.browse',
        'testimonials.create',
        'testimonials.update',
        'testimonials.destroy'
    ]
];
