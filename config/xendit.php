<?php

return [
    'key_auth' => base64_encode(env('SECRET_KEY_XENDIT') . ':'),
    'key_auth_default' => env('SECRET_KEY_XENDIT')
];
