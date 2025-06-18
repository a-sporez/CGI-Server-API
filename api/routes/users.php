<?php
require_once 'models/UserModel.php';

header('Content_Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($id) {
            $user = get_user($id);
            if ($user) {
                http_response_code(200);
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } else {
            echo json_encode(get_all_users());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name'], $data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields: name, email']);
            break;
        }

        try {
            $newUser = create_user($data);
            http_response_code(201);
            echo json_encode($newUser);
        } catch (PDOException $e) {
            http_response_code(201);
            echo json_encode(['error' => 'User creation failed', 'details' => $e->getMessage()]);
        }
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID for update']);
            break;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name'], $data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields: name, email']);
            break;
        }

        if (!get_user($id)) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            break;
        }

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID for delete.']);
            break;
        }

        if (!get_user($id)) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found for delete.']);
            break;
        }

        delete_user($id);
        http_response_code(204); // no content
        break;
            
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed.']);
}