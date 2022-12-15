<?php

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

Route::middleware('auth.basic')->post('/', function (Request $request, Dompdf $dompdf) {
    $dompdf->loadHtml($request->getContent());
    $dompdf->render();
    return response($dompdf->output(), Response::HTTP_OK, [
        'Content-type'        => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="document.pdf"',
    ]);
});

Route::middleware('auth.basic')->get('/ping', function () {
    return response()->json([
        "success" => true,
        "version" => config('app.version')
    ]);
});

Route::middleware('auth.basic')->any("{any?}", function () {
    return response(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
})->where('any', '.*');


