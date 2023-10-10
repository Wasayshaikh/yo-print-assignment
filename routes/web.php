<?php

use App\Jobs\ProcessCSVFile;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data['files'] = Uploads::get();
    return view('welcome', $data);
});

Route::post('/uploads', function (Request $request){
    $uploadedFile = $request->file('file');
    if( $request->has('file') ) {
        $csv    = file($request->file);
        $chunks = array_chunk($csv,1000);
        $header = explode(',', 'UNIQUE_KEY,PRODUCT_TITLE,PRODUCT_DESCRIPTION,STYLE#,AVAILABLE_SIZES,BRAND_LOGO_IMAGE,THUMBNAIL_IMAGE,COLOR_SWATCH_IMAGE,PRODUCT_IMAGE,SPEC_SHEET,PRICE_TEXT,SUGGESTED_PRICE,CATEGORY_NAME,SUBCATEGORY_NAME,COLOR_NAME,COLOR_SQUARE_IMAGE,COLOR_PRODUCT_IMAGE,COLOR_PRODUCT_IMAGE_THUMBNAIL,SIZE,QTY,PIECE_WEIGHT,PIECE_PRICE,DOZENS_PRICE,CASE_PRICE,PRICE_GROUP,CASE_SIZE,INVENTORY_KEY,SIZE_INDEX,SANMAR_MAINFRAME_COLOR,MILL,PRODUCT_STATUS,COMPANION_STYLES,MSRP,MAP_PRICING,FRONT_MODEL_IMAGE_URL,BACK_MODEL_IMAGE,FRONT_FLAT_IMAGE,BACK_FLAT_IMAGE,PRODUCT_MEASUREMENTS,PMS_COLOR,GTIN');    
        
        event(new \App\Events\FileUploadEvent('uploading'));
        $uploads = Uploads::updateOrCreate(
            ['id' => 0],[
                'name' =>$uploadedFile->getClientOriginalName(),
                'status' =>'uploading'
            ]
        );
        foreach ($chunks as $key => $chunk) {
        $data = array_map('str_getcsv', $chunk);
            if($key == 0){
                // $header = $data[0];
                unset($data[0]);
            }

            ProcessCSVFile::dispatch($data, $header ,$uploads->id);  
                          
        }
    }
});
