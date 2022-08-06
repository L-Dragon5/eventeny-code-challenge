<?php
require_once('Database.php');
require_once('DiscountCode.php');
$db = new Database();

if (isset($_POST['action'])) {
    $action = htmlspecialchars($_POST['action']);

    if ($action === 'LOAD') {
        echo json_encode(DiscountCode::all($db));
    } else if ($action === 'ADD') {
        if (isset($_POST['discountCode'])) {
            $dc = array_map('cleanData', $_POST['discountCode']);
            if (empty($dc['name'])) {
                echo 'Name cannot be empty';
            } else {
                echo DiscountCode::add($db, $_POST['discountCode']);
            }
        } else {
            echo 'Discount Code information not supplied.';
        }
    } else if ($action === 'EDIT') {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);

            if (isset($_POST['discountCode'])) {
                $dc = array_map('cleanData', $_POST['discountCode']);
                if (empty($dc['name'])) {
                    echo 'Name cannot be empty';
                } else {
                    echo DiscountCode::edit($db, $id, $dc);
                }
            } else {
                echo 'Discount Code information not supplied.';
            }
        } else {
            echo 'ID not supplied.';
        }
    } else if ($action === 'REMOVE') {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            echo DiscountCode::remove($db, $id);
        } else {
            echo 'ID not supplied.';
        }
    }
}

function cleanData($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
