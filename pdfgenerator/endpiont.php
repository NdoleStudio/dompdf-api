<?php


// Handle the API request
function handleRequest()
{
    // Check the API endpoint
    $endpoint = $_SERVER['REQUEST_URI'];
    
    switch ($endpoint) {
        case '/convert':
            return handleConvertRequest();
        case '/convert-multiple':
            return handleConvertMultipleRequest();
        default:
            return responseError('Invalid API endpoint.');
    }
}

// Handle the convert request for a single HTML file
function handleConvertRequest()
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

// Handle the convert request for multiple HTML files
function handleConvertMultipleRequest()
{
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return responseError('Invalid request method. Only POST requests are allowed.');
    }

    // Get the HTML files from the request body
    $htmlFiles = $_FILES['html_files'];

    // Validate the HTML files
    if (empty($htmlFiles)) {
        return responseError('HTML files are required.');
    }

    // Convert each HTML file to PDF
    $pdfFiles = [];
    foreach ($htmlFiles['tmp_name'] as $index => $tmpName) {
        $htmlContent = file_get_contents($tmpName);
        $pdf = convertToPdf($htmlContent);
        if ($pdf === false) {
            return responseError("Failed to convert HTML file {$htmlFiles['name'][$index]} to PDF.");
        }
        $pdfFiles[] = $pdf;
    }

    // Return the PDF files
    return responsePdfFiles($pdfFiles);
}

// Function to handle PDF files response
function responsePdfFiles($pdfFiles)
{
    $zipFilename = 'converted_files.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipFilename, ZipArchive::CREATE) !== true) {
        return responseError('Failed to create ZIP file.');
    }

    foreach ($pdfFiles as $index => $pdf) {
        $filename = "document{$index}.pdf";
        $zip->addFromString($filename, $pdf);
    }

    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
    readfile($zipFilename);
    unlink($zipFilename);

    exit;
}


?>