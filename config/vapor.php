<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Redirect "www" To The Root Domain
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, Vapor will redirect requests to the "www"
    | subdomain to the application's root domain. When this option is not
    | enabled, Vapor redirects your root domain to the "www" subdomain.
    |
    */

    'redirect_to_root' => true,

    /*
    |--------------------------------------------------------------------------
    | Redirect robots.txt
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, Vapor will redirect requests for your
    | application's "robots.txt" file to the location of the S3 asset
    | bucket or CloudFront's asset URL instead of serving directly.
    |
    */

    'redirect_robots_txt' => true,

    /*
    |--------------------------------------------------------------------------
    | Servable Assets
    |--------------------------------------------------------------------------
    |
    | Here you can configure list of public assets that should be servable
    | from your application's domain instead of only being servable via
    | the public S3 "asset" bucket or the AWS CloudFront CDN network.
    |
    */

    'serve_assets' => [
        'robots.txt',
        'favicon.ico',
        'js/app.js',
        'js/pdd.js',
        'css/app.css',
        'scripttags/dummy.js',
        'image/fsb_step1.png',
        'image/fsb_step2_1.png',
        'image/fsb_step2_2.png',
        'image/fsb_step3.png',
        'image/fsb_step3_2.png',
        'image/fsb_step4.png',
        'image/bar002.png',
        'image/bar017.jpeg',
        'image/bar020.png',
        'image/bar023.jpeg',
        'image/fsb-logo.svg',
        'image/fsb-logo@2x.svg',
        'vendor/vapor-ui/app.css',
        'vendor/vapor-ui/app.js'
    ],

];
