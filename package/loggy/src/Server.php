<?php

namespace DeepDigital\Loggy;

class Server
{
    /**
     * Base URL to the server.
     */
    const URL = 'http://loggy.test/api';

    const SUCCESSFUL_RESPONSES = [
        201,
        200
    ];

    /**
     * Default heades of the
     */
    const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json'
    ];
}
