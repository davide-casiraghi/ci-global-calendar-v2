<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\CheckPermission;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UsersExportController extends Controller
{
    use CheckPermission;

    /**
     * Display the export interface.
     *
     * @return View
     */
    public function show(): View
    {
        $this->checkPermission('user_export.view');
        return view('usersExport.show');
    }

    /**
     * Export all the users in an excel that get downloaded.
     *
     * @return BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $this->checkPermission('user_export.view');
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
