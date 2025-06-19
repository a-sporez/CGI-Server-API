<?php
require_once 'models/MessageModel.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($id) {
            $message = get_message($id);
            if ($message) {
                http_response_code(200);
                echo json_encode($message);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Message not found.']);
            }
        } else {
            echo json_encode(get_all_messages());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['author'], $data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields: author, content']);
            break;
        }

        try {
            $newMessage = create_message($data);
            http_response_code(201);
            echo json_encode($newMessage);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Post failed.', 'details' => $e->getMessage()]);
        }
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID for update.']);
            break;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['author'], $data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields: author, content']);
            break;
        }

        if (!get_message($id)) {
            http_response_code(404);
            echo json_encode(['error' => 'Message not found']);
            break;
        }

        echo json_encode(update_message($id, $data));
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID for delete.']);
            break;
        }

        if (!get_message($id)) {
            http_response_code(404);
            echo json_encode(['error' => "Message not found."]);
            break;
        }

        delete_message($id);
        http_response_code(204);
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed.']);
}