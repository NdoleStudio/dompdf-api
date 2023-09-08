<?php

// Handle the API request
function handleRequest()
{
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return responseError('Invalid request method. Only POST requests are allowed.');
    }

    // Get the HTML content from the request body
    $html = file_get_contents('php://input');

    // Validate the HTML content
    if (empty($html)) {
        return responseError('HTML content is required.');
    }

    // Convert the HTML to PDF
    $pdf = convertToPdf($html);

    // Check if the conversion was successful
    if ($pdf === false) {
        return responseError('Failed to convert HTML to PDF.');
    }

    // Return the PDF file
    return responsePdf($pdf);
}

// Function to handle error response
function responseError($message)
{
    http_response_code(400); // Set the HTTP response code to 400 Bad Request
    return json_encode(['error' => $message]);
}

// Function to handle PDF response
function responsePdf($pdf)
{
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="document.pdf"');
    echo $pdf;
    exit;
}

?>