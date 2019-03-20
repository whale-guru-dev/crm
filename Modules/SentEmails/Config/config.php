<?php

return [
    'name' => 'SentEmails',

    'entity_private_access' => false,

    'email_list_cache_time' => 15, // In minutes

    /**
     * Always use lower name without custom characters, spaces, etc
     */
    'permissions' => [
        'sentemails.settings',
        'sentemails.browse',
        'sentemails.create',
        'sentemails.update',
        'sentemails.destroy'
    ]
];
