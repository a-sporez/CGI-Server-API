<?php
function json($data, $code = 200) {
    http_response_code(code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function json_error($code, $message) {
    json(['error' => $message], $code);
}