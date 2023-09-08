<?php

// API endpoint to list all converted PDF files
function handleListFilesRequest()
{
    // Get the list of PDF files in the directory
    $files = glob('path/to/pdf/files/*.pdf');

    // Return the list of files as the API response
    return responseJson($files);
}

// API endpoint to delete a specific PDF file
function handleDeleteFileRequest()
{
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return responseError('Invalid request method. Only POST requests are allowed.');
    }

    // Get the filename from the request body
    $filename = $_POST['filename'];

    // Validate the filename
    if (empty($filename)) {
        return responseError('Filename is required.');
    }

    // Construct the full path to the PDF file
    $filePath = 'path/to/pdf/files/' . $filename;

    // Check if the file exists
    if (!file_exists($filePath)) {
        return responseError('File not found.');
    }

    // Delete the file
    if (!unlink($filePath)) {
        return responseError('Failed to delete file.');
    }

    // Return success response
    return responseSuccess('File deleted successfully.');
}

// API endpoint to download a specific PDF file
function handleDownloadFileRequest()
{
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return responseError('Invalid request method. Only POST requests are allowed.');
    }

    // Get the filename from the request body
    $filename = $_POST['filename'];

    // Validate the filename
    if (empty($filename)) {
        return responseError('Filename is required.');
    }

    // Construct the full path to the PDF file
    $filePath = 'path/to/pdf/files/' . $filename;

    // Check if the file exists
    if (!file_exists($filePath)) {
        return responseError('File not found.');
    }

    // Set the appropriate headers for file download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filePath));

    // Read the file and output the content
    readfile($filePath);

    exit;
}

?>