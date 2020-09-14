<?php

namespace App\Http\Controllers;





use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportsController extends Controller
{
    public function excel(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    
}
