<?php

require_once 'vendor/autoload.php';

// Connecting to the Google Sheets API
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/credentials.json');
$client->addScope(Google_Service_Sheets::SPREADSHEETS);

$service = new Google_Service_Sheets($client);

$spreadsheetId = '19Wl1F6KzijDjjQ9npNKCSC_pjyy-eQSji0TDU0NT6dI';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Getting data from a form
    $email = $_POST['email'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $text = $_POST['text'];

    // Creating an array with data to write to a table
    $row = [$email, $category, $title, $text];

    // Adding data to a table
    $range = 'Лист1!A1'; // The range of cells where the data will be written
    $valueRange = new Google_Service_Sheets_ValueRange(['values' => [$row]]);
    $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, ['valueInputOption' => 'USER_ENTERED']);

    http_response_code(200);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Возвращаем ошибку
    http_response_code(400);
}
