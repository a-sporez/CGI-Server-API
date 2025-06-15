<?php
require_once 'lib/response.php';
require_once 'db/mysql.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');
$path = str_replace('api/', '', $path);
$parts = explode('/', $path);

$resource = $parts[0] ?? '';
$id = $parts[1] ?? null;

switch ($resource) {
    case 'users':
        require 'routes/users.php';
        break;
    case 'messages':
        require 'routes/messages.php';
        break;
    default:
        json_error(404, 'Endpoit not found.');
}