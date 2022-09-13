<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Slim\\' => array($vendorDir . '/slim/slim/Slim'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'),
    'Psr\\Container\\' => array($vendorDir . '/psr/container/src'),
    'FastRoute\\' => array($vendorDir . '/nikic/fast-route/src'),
    'DEV\\Controllers\\' => array($baseDir . '/system/controllers'),
    'DEV\\' => array($baseDir . '/system/models'),
);