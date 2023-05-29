<?php
require "dbconnection.php";
require 'error.php';
$dbcon = createDbConnection();

try {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $invoice_item_id = strip_tags($data->invoice_item_id ?? 'No Category');
    $invoice_item_id = filter_var($invoice_item_id, FILTER_SANITIZE_NUMBER_INT );

    $sql = "DELETE FROM invoice_items WHERE InvoiceId=?";

    $statement = $dbcon->prepare($sql);
    $statement->execute(array($invoice_item_id));
}

catch (PDOException $pdoex) {
    returnError($pdoex);
}
