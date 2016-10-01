<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

define('CONF_FILE', __DIR__ . '/conf.php');

$app = new \Tonic\Application([
    'load' => __DIR__.'/Iaejean/*/*Controller.php'
]);

try {
    $request = new \Tonic\Request([
        'mimetypes' => [
            'json' => 'application/json'
        ]
    ]);
    $resource = $app->getResource($request);
    $response = $resource->exec();
} catch (\Tonic\NotFoundException $e) {
    $response = new \Tonic\Response(404, json_encode($e->getMessage()));
} catch (Tonic\Exception $e) {
    $response = new Tonic\Response(500, json_encode($e->getMessage()));
}
$response->output();
