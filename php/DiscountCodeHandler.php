<?php
require_once('Database.php');
require_once('DiscountCode.php');
$db = new Database();

if (isset($_POST['action'])) {
    $action = htmlspecialchars($_POST['action']);

    if ($action === 'LOAD') {
        echo json_encode(DiscountCode::all($db));
    } else if ($action === 'ADD') {

    } else if ($action === 'EDIT') {

    } else if ($action === 'REMOVE') {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            echo DiscountCode::remove($db, $id);
        } else {
            echo 'ID not supplied.';
        }
    }
}
