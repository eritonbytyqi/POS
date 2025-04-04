<?php
return [
    'paths' => ['api/*'], // Përdoret për të specifikuar rrugët ku CORS aplikohet
    'allowed_methods' => ['*'], // Lejon të gjitha metodat HTTP (GET, POST, PUT, DELETE)
    'allowed_origins' => ['*'], // Lejon të gjitha origjinat
    'allowed_headers' => ['*'], // Lejon të gjitha kokat
    'exposed_headers' => false,
    'max_age' => false,
    'supports_credentials' => false,
];
return [
    'paths' => ['api/*', '/login', '/logout'],
    'allowed_methods' => ['*'],  // Lejon të gjitha metodat e HTTP (GET, POST, PUT, DELETE)
    'allowed_origins' => ['http://localhost:8080', 'http://localhost:8000'],  // Origjinat e lejuara (frontend dhe backend)
    'allowed_headers' => ['*'],  // Lejon të gjitha kërkesat për headera
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  // Lejon mbajtjen e cookies dhe credentialeve
];
