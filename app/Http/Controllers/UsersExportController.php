<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\CheckPermission;

class UsersExportController extends Controller
{
    use CheckPermission;

    /**
     * Display the export interface.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $this->checkPermission('users.view');

        return view('usersExport.show');
    }

    // **********************************************************************

    /**
     * Export all the users in an excel that get downloaded.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
