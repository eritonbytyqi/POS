<?php

use App\Http\Controllers\ArtikujShitjeshController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\KlientController;
use App\Http\Controllers\PagesaController;
use App\Http\Controllers\ProduktController;
use App\Http\Controllers\RaportimetController;
use App\Http\Controllers\ShitjeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksioniController;
use App\Models\Raportimet;
use Illuminate\Support\Facades\Route;


Route::apiResource('produktet',ProduktController::class);
Route::apiResource('klientet',KlientController::class);
Route::apiResource('faturat',FaturaController::class);
Route::apiResource('shitjet',ShitjeController::class);
Route::apiResource('stoku',StokController::class);
Route::apiResource('transaksionet',TransaksioniController::class);
Route::apiResource('raportimet',RaportimetController::class);
Route::apiResource('pagesat',PagesaController::class);
Route::get('/folders/main', [FolderController::class, 'getMainFolders']);  // Marrim të gjithë folderat
Route::post('/folders', [FolderController::class, 'store']); // Shtojmë folder të ri
Route::delete('/folders/{folder}', [FolderController::class, 'destroy']);
Route::post('folders/{folderId}/products', [FolderController::class, 'addProductToFolder']);

Route::get('/folders/{folderId}/products', [FolderController::class, 'getProducts']);
Route::get('/folders/{folderId}/subfolders', [FolderController::class, 'getSubfolders']);
// Route::post('/folders/{folderId}/add-product', [FolderController::class, 'addProductToSubfolder']);
// Route::post('shitjet',[ShitjeController::class,'storee']);
Route::get('folders/all', [FolderController::class, 'getAllFoldersAndSubfolders']);
Route::get('/folders', [FolderController::class, 'getAllFolders']);
Route::post('/folders/add/{folderId}/subfolders', [FolderController::class, 'storeSubfolder']);
Route::get('/folders/{folderId}/subfolders/{subfolderId}/products', [FolderController::class, 'getProductsInSubfolder']);
Route::post('/folders/{folderId}/subfolders/{subfolderId}/products', [FolderController::class, 'addProductToSubfolder']);
Route::post('/folders/{parentFolderId}/subfolder/{subfolderId}', [FolderController::class, 'storeSubfolderInSubfolder']);
Route::get('/folders/{parentFolderId}/subfolder/{subfolderId}', [FolderController::class, 'storeSubfolderInSubfolder']);


// Route::post('/subfolders/{subfolderId}/products', [FolderController::class, 'addProductToSubfolder']);
Route::delete('folder/{folderId}', [FolderController::class, 'deleteFolder']);
Route::delete('subfolder/{subfolderId}', [FolderController::class, 'deleteSubfolder']);
// Route::post('/produktet/veqmas', [ProduktController::class, 'search']);
Route::post('produktet/veqmas', [ProduktController::class, 'search']);
Route::get('perdate', [RaportimetController::class, 'perDate']);
Route::put('/folders/{folderId}', [FolderController::class, 'updateFolder']);
Route::put('/subfolders/{subfolderId}', [FolderController::class, 'updateSubfolder']);
Route::get('shitjetTotale', [RaportimetController::class, 'getTotalShitje']);
Route::get('/java', [RaportimetController::class, 'perJaven']);
Route::get('/muaji', [RaportimetController::class, 'perMuajin']);
Route::get('/data-fillimit/between/datambarimit', [RaportimetController::class, 'perDateRange']);
Route::get('/raportimet/test', [RaportimetController::class, 'testFiltrim']);
Route::get('/test', function () {
    return response()->json(['message' => 'Back-end dhe front-end janë të lidhur']);
});