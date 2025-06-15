<?php

require_once 'models/UserModel.php';

switch ($method) {
    case 'GET':
        echo json($id ? get_user($id) : get_all_users());
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json(create_user($data));
        break;
    default:
        json_error(405, 'Method not allowed.');
}