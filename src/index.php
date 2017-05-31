<?php
    
    $path = explode("/", $_SERVER['PATH_INFO'] ?? $_SERVER['REDIRECT_URL'] ?? null);
    $name = $path[1] ?? null;
    $token = $path[2] ?? null;
    $params = array_slice($path, 3);
    
    $debug = $_GET['debug'] ?? false == true;
    
    if (!$name) {
        echo 'Missing hook name';
        http_response_code(400);
        die();
    }
    
    if (!$token) {
        echo 'Missing token';
        http_response_code(400);
        die();
    }
    
    $name = strtolower(preg_replace('@[^0-9a-z\-\_]@is', '', $name));
    
    $config = @file_get_contents("./config/" . $name . ".json");
    if ($config) {
        $config = json_decode($config, true);
    }
    
    if (!$config) {
        echo 'Webhook not found';
        http_response_code(404);
        die();
    }
    
    if (!isset($config['token']) || $token != $config['token']) {
        echo 'Forbidden';
        http_response_code(403);
        die();
    }
    
    foreach ($config['scripts'] as $script) {
        
        $script = preg_replace_callback('@\$([0-9]+)@', function($param) use(&$params) {
            return $params[$param[1]-1];
        }, $script);
        
        $log = [];
        exec($script.' 2>&1', $log, $status);
        
        if ($debug) {
            echo '<strong>'.$script.'</strong><br><pre>';
            foreach ($log as $l) {
                echo $l.'<br>';
            }
            echo '</pre><br><br>';
        }
        
    }
    
?>