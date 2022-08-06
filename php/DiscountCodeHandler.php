<?php
require_once('Database.php');
require_once('DiscountCode.php');
$db = new Database();

if (isset($_POST['action'])) {
    $action = htmlspecialchars($_POST['action']);

    /*
    LOAD = Get all
    GET = Get one
    ADD = Create one
    EDIT = Update one
    REMOVE = Delete one
    */
    if ($action === 'LOAD') {
        echo json_encode(DiscountCode::all($db));
    } else if ($action === 'GET') {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            $dc = DiscountCode::find($db, $id);
            $dc->start_date = new DateTime($dc->start_date);
            $dc->start_date = $dc->start_date->format('Y-m-d') . 'T' . $dc->start_date->format('H:i');
            $dc->end_date = !empty($dc->end_date) ? new DateTime($dc->end_date) : null;
            $dc->end_date = !empty($dc->end_date) ? $dc->end_date->format('Y-m-d') . 'T' . $dc->end_date->format('H:i') : null;
            echo json_encode($dc);
        } else {
            echo 'ID not supplied.';
        }
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
