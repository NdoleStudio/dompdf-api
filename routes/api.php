<?php

use Dompdf\Options;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.basic')->get('/', function (Request $request) {
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $options = new Options();
    $options->setIsRemoteEnabled(true);
    $dompdf->setOptions($options);
    $dompdf->loadHtml($request->getContent());

    $dompdf->render();

    return response($dompdf->output(), 200, [
        'Content-type'        => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="api.pdf"',
    ]);
});
