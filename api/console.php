<?php
require_once 'db/db.php';
require_once 'models/UserModel.php';
require_once 'models/MessageModel.php';

function init() {
    echo "API interface initialized. Type -help for a list of commands";
    prompt();
}

function quit() {
    echo "Goodbye.\n";
    exit(0);
}

function prompt() {
    while (true) {
        echo "\n";
        $line = trim(fgets(STDIN));
        if (!$line) continue;

        $args    = str_getcsv($line, ' ');
        $command = strtolower($args[0] ?? '');
        $action  = strtolower($args[1] ?? '');
        $param1  = $args[2] ?? null;
        $param2  = $args[3] ?? null;

        switch ("$command $action") {
            case '-help':
                show_help();
                break;

            case 'list users':
                foreach (get_all_users() as $u) {
                    echo "[{$u['id']}] {$u['name']} <{$u['email']}>\n";
                }
                break;

            case 'add user':
                if (!$param1 || !$param2) {
                    echo "Usage: add user name email";
                    break;
                }
                $user = create_user(['name' => $param1, 'email' => $param2]);
                echo "Created user #{$user['id']}: {$user['name']} <{$user['email']}>";
                break;

            case 'delete user':
                if (!$param1) {
                    echo "Usage: delete user userID";
                    break;
                }
                delete_user($param1);
                echo "Deleted user #$param1";
                break;

            case 'list messages':
                foreach (get_all_messages() as $m) {
                    echo "[{$m['id']}] {$m['author']} posted: {$m['content']}\n";
                }
                break;

            case 'add message':
                if (!$param1 || !$param2) {
                    echo "Usage: add message author content";
                    break;
                }
                $msg = create_message(['author' => $param1, 'content' => $param2]);
                echo "Created message #{$msg['id']}";
                break;

            case 'delete message':
                if (!$param1) {
                    echo "Usage: delete message messageID";
                    break;
                }
                delete_message($param1);
                echo "Deleted message #$param1";
                break;

            case 'quit':
                quit();
                break;
            
            default:
                echo "Unknown command: $line";
                echo "\nType `-help` to see available commands.";
        }
    }
}

function show_help() {
    echo <<<EOD
Available commands:
    -help
    list users
    add user
    delete user
    list messages
    add message
    delete message
    quit
EOD;
}

init();