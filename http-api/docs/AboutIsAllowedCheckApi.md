Config Examples
===============

~~~php
// ACL EXAMPLE 
IsAllowedCheckApi::class => [
    'arguments' => [
        IsAllowedRcmUser::class,
        [
            'literal' => [
                IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
            ]
        ],

    ],
],
~~~
