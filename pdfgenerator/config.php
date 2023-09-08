<?php

// Convert HTML to PDF with configuration options
function convertToPdf($html, $options = [])
{
    // Create a new instance of Dompdf
    $dompdf = new Dompdf();

    // Set the PDF generation options
    if (isset($options['pageSize'])) {
        $dompdf->setPaper($options['pageSize'], $options['orientation']);
    }
    
    if (isset($options['margins'])) {
        $dompdf->set_option('margin', $options['margins']);
    }

    // Load the HTML content
    $dompdf->loadHtml($html);

    // Render the PDF
    if (!$dompdf->render()) {
        throw new Exception('Failed to render PDF: ' . $dompdf->get_error());
    }

    // Get the PDF content
    $pdf = $dompdf->output();

    return $pdf;
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

    // Get the configuration options from the request
    $options = [];
    if (isset($_POST['options'])) {
        $options = json_decode($_POST['options'], true);
        if ($options === null) {
            return responseError('Invalid options format. JSON format expected.');
        }
    }

    // Convert the HTML to PDF with the provided options
    try {
        $pdf = convertToPdf($html, $options);
    } catch (Exception $e) {
        return responseError('Failed to convert HTML to PDF: ' . $e->getMessage());
    }

    // Return the PDF file
    return responsePdf($pdf);
}


?>