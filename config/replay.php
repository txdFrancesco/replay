<?php

use Bvtterfly\Replay\Policies\ReplayPolicy;


return [

    /*
    |--------------------------------------------------------------------------
    | Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the cache store that gets used while Replay will store the
    | information required for it to function.
    | By default, Replay will use the default cache store.
    |
    | Please see config/cache.php for the list of all available Cache Stores.
    |
     */

    'use' => env('REPLAY_CACHE_STORE', config('cache.default')),

    /*
    |--------------------------------------------------------------------------
    | Replay Master Switch
    |--------------------------------------------------------------------------
    |
    | Replay is enabled by default,
    | Use this setting to enable/disable the Replay.
    |
    */

    'enabled' => env('REPLAY_ENABLED', true),
    

    /*
    |--------------------------------------------------------------------------
    | Expiration Seconds
    |--------------------------------------------------------------------------
    |
    | This value controls the number of seconds until an idempotency response
    | is considered expired.
    |
    | The default is set to 1 day.
    |
    */

    'expiration' => 60 * 60 * 24,

    /*
    |--------------------------------------------------------------------------
    | Request Header Name
    |--------------------------------------------------------------------------
    |
    | Replay will check this header name to determine
    | if a request is an Idempotency request.
    |
    */

    'header_name' => 'Idempotency-Key',

    /*
    |--------------------------------------------------------------------------
    | Response Header Name
    |--------------------------------------------------------------------------
    |
    | Replay will add this header to previously executed responses
    | that's being replayed from the server.
    |
    | Use null or empty, if you don't need to identify these responses.
    |
    */
    'replied_header_name' => 'Idempotent-Replayed',

    /*
    |--------------------------------------------------------------------------
    | Policy
    |--------------------------------------------------------------------------
    |
    | The policy determines whether a request is idempotent and whether the response should
    |  be recorded.
    |
    */

    'policy' => ReplayPolicy::class,
    'methods' => ['POST','PATCH','DELETE'],
    
    
    'wait_for_response_in_process_timeout' => 10,
    'include_headers_in_signature' => false,
    'include_user_in_signature' => true

];
