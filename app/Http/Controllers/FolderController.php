<?php    
// app/Http/Controllers/FolderController.php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Product;
use App\Models\Produkt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    // public function addProductToFolder(Request $request, $folderId)
    // {
    //     $request->validate([
    //         'emri' => 'required|string|max:255',
    //         'cmimi_shitjes' => 'required|numeric',
    //         'sasia_ne_stok' => 'required|integer',
    //     ]);

    //     $folder = Folder::findOrFail($folderId);

    //     $product = new Produkt([
    //         'emri' => $request->input('emri'),
    //         'cmimi_shitjes' => $request->input('cmimi_shitjes'),
    //         'sasia_ne_stok' => $request->input('sasia_ne_stok'),
    //         'folder_id' => $folder->id,
    //         'subfolder_id' => $subfolder->subfolder_id,
    //     ]);

    //     $folder->products()->save($product);

    //     return response()->json($product, 201);
    // }

    public function getAllFolders()
    {
        $folders = Folder::with('subfolders')->whereNull('subfolder_id')->get();
        return response()->json(['result' => ['data' => $folders]], 200);
    }
    
    public function getMainFolders()
    {
        $folders = Folder::whereNull('subfolder_id')->get();
    
        if ($folders->isEmpty()) {
            return response()->json(['message' => 'Nuk ka foldera kryesorë të disponueshëm'], 404);
        }
    
        return response()->json(['result' => ['data' => $folders]], 200);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder = Folder::create([
            'name' => $request->input('name'),
            'subfolder_id' => null,
        ]);

        return response()->json($folder, 201);
    }

// FolderController.php
public function storeSubfolder(Request $request, $folderId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $parentFolder = Folder::findOrFail($folderId);

    $subfolder = new Folder();
    $subfolder->name = $validated['name'];
    $subfolder->subfolder_id = $parentFolder->id; // Lidhja me folderin kryesor
    $subfolder->save();

    return response()->json($subfolder, 201);
}
public function storeSubfolderInSubfolder(Request $request, $parentFolderId, $subfolderId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Gjejmë folderin kryesor dhe subfolderin
    $parentFolder = Folder::findOrFail($parentFolderId);
    $subfolder = Folder::findOrFail($subfolderId);

    // Krijohet subfolder i ri brenda subfolderit ekzistues
    $newSubfolder = new Folder();
    $newSubfolder->name = $validated['name'];
    $newSubfolder->subfolder_id = $subfolder->id; // Lidhja me subfolderin
    $newSubfolder->save();

    return response()->json($newSubfolder, 201);
}


public function getAllFoldersAndSubfolders()
{
    // Merr të gjithë folderët kryesorë që nuk kanë subfolderë
    $folders = Folder::with('subfolders.subfolders')->whereNull('subfolder_id')->get();

    // Kontrolloni nëse ka foldera
    if ($folders->isEmpty()) {
        return response()->json(['message' => 'Nuk ka foldera kryesorë të disponueshëm'], 404);
    }

    return response()->json(['result' => ['data' => $folders]], 200);
}

public function addProductToSubfolder(Request $request, $folderId, $subfolderId)
{
    // Validimi i të dhënave
    $validatedData = $request->validate([
        'emri' => 'required|string|max:255',
        'pershkrimi' => 'required|string|max:255',
        'cmimi_shitjes' => 'required|numeric',
    ]);

    // Gjejmë folderin dhe subfolderin
    $folder = Folder::find($folderId);
    $subfolder = Folder::find($subfolderId);

    if (!$folder || !$subfolder) {
        return response()->json(['error' => 'Folder ose subfolder nuk u gjet'], 404);
    }

    // Krijohet produkti dhe lidhet me folderin dhe subfolderin
    Produkt::create([
        'emri' => $request->emri,
        'pershkrimi' => $request->pershkrimi,
        'cmimi_shitjes' => $request->cmimi_shitjes,
        'folder_id' => $folderId,
        'subfolder_id' => $subfolderId,
    ]);

    return response()->json([
        'message' => 'Product successfully added to subfolder',
    ], 201);
}


    public function getSubfolders($folderId)
    {
        $folder = Folder::find($folderId);

        if (!$folder) {
            return response()->json(['error' => 'Folderi nuk u gjet'], 404);
        }

        $subfolders = Folder::where('subfolder_id', $folder->id)->get();

        if ($subfolders->isEmpty()) {
            return response()->json(['message' => 'Nuk ka subfoldera për këtë folder'], 404);
        }

        return response()->json(['result' => ['data' => $subfolders]], 200);
    }

    public function getProducts($folderId)
    {
        $folder = Folder::find($folderId);

        if (!$folder) {
            return response()->json(['error' => 'Folderi nuk u gjet'], 404);
        }

        return response()->json($folder->products);
    }

    public function getProductsInSubfolder($folderId, $subfolderId)
    {
        $products = Produkt::where('folder_id', $folderId)
                           ->where('subfolder_id', $subfolderId)  // Përdorni subfolder_id
                           ->get();
    
        return response()->json($products);
    }
    // public function addProductToSubfolder(Request $request, $folderId, $subfolderId)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'emri' => 'required|string|max:255',
    //         'pershkrimi' => 'required|string|max:255',
    //         'cmimi_shitjes' => 'required|numeric',
    //         // 'sasia_ne_stok' => 'required|integer|min:1',
    //     ]);

    //     // Find the folder by its ID
    //     $folder = Folder::find($folderId);

    //     if (!$folder) {
    //         return response()->json(['error' => 'Folder not found'], 404);
    //     }

    //     // Optional: You can check if the subfolder belongs to the folder
    //     // if ($folder->id !== $subfolderId) {
    //     //     return response()->json(['error' => 'Invalid subfolder'], 400);
    //     // }

    //     // Create the product and associate it with the folder and subfolder
    //     Produkt::create([
    //         'emri' => $request->emri,
    //         'cmimi_shitjes' => $request->cmimi_shitjes,
    //      'pershkrimi' => $request->pershkrimi,
    //         'folder_id' => $folderId,
    //         'subfolder_id' => $subfolderId,  // Ensure subfolder_id is passed
    //     ]);

    //     return response()->json([
    //         'message' => 'Product successfully added to subfolder',
    //     ], 201);
    // }




    public function deleteFolder($folderId)
    {
        // Gjejmë folderin që do të fshihet
        $folder = Folder::find($folderId);

        if (!$folder) {
            return response()->json(['error' => 'Folderi nuk u gjet'], 404);
        }

        // Fshijmë produktet që janë të lidhura me këtë folder
        $folder->products()->delete();

        // Gjejmë të gjitha subfolderët që janë të lidhur me këtë folder
        $subfolders = Folder::where('subfolder_id', $folderId)->get();

        // Fshijmë të gjitha subfolderët dhe produktet që janë të lidhura me ta
        foreach ($subfolders as $subfolder) {
            $subfolder->products()->delete(); // Fshijmë produktet e subfolderit
            $subfolder->delete(); // Fshijmë subfolderin
        }

        // Fshijmë folderin kryesor
        $folder->delete();

        return response()->json(['message' => 'Folderi dhe subfolderët u fshinë me sukses'], 200);
    }

    // Funksioni për fshirjen e subfolderëve
    public function deleteSubfolder($subfolderId)
    {
        // Gjejmë subfolderin që do të fshihet
        $subfolder = Folder::find($subfolderId);

        if (!$subfolder) {
            return response()->json(['error' => 'Subfolderi nuk u gjet'], 404);
        }

        // Fshijmë produktet që janë të lidhura me këtë subfolder
        $subfolder->products()->delete();

        // Fshijmë subfolderin
        $subfolder->delete();

        return response()->json(['message' => 'Subfolderi u fshi me sukses'], 200);
    }


    public function updateFolder(Request $request, $folderId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder = Folder::findOrFail($folderId);
        $folder->name = $validated['name'];
        $folder->save();

        return response()->json(['message' => 'Emri i folderit u përditësua me sukses', 'folder' => $folder], 200);
    }

    public function updateSubfolder(Request $request, $subfolderId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subfolder = Folder::findOrFail($subfolderId);
        $subfolder->name = $validated['name'];
        $subfolder->save();

        return response()->json(['message' => 'Emri i subfolderit u përditësua me sukses', 'subfolder' => $subfolder], 200);
    }

}    