<?php

namespace App\Http\Controllers;

use App\Jobs\ImportUsersJob;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //php artisan queue:work
    public function index()
    {
        return view('index');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'fileExcel' => 'required|max:50000|mimes:xlsx,application/excel'
        ]);


        $file = $request->file('fileExcel');
        $filePath = $file->storeAs('imports', 'imported_file.xlsx');
        ImportUsersJob::dispatch($filePath);
        return "done";
    }
}
