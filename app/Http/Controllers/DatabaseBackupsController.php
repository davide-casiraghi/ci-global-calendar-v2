<?php

namespace App\Http\Controllers;

use App\Services\DatabaseBackupService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseBackupsController extends Controller
{
    use CheckPermission;

    private DatabaseBackupService $databaseBackupService;

    public function __construct(
        DatabaseBackupService $databaseBackupService
    ) {
        $this->databaseBackupService = $databaseBackupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $this->checkPermission('database_backup.view');
        $databaseBackupFiles = $this->databaseBackupService->getDbBackups();

        return view('dbBackupFiles.index', [
            'databaseBackupFiles' => $databaseBackupFiles,
        ]);
    }

    /**
     * Download db backup file.
     *
     * @param  string  $databaseBackupFileName
     * @return StreamedResponse
     */
    public function download(string $databaseBackupFileName): StreamedResponse
    {
        $this->checkPermission('database_backup.view');
        return $this->databaseBackupService->downloadDbBackupFile($databaseBackupFileName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $databaseBackupFileName
     * @return RedirectResponse
     */
    public function destroy(string $databaseBackupFileName): RedirectResponse
    {
        $this->checkPermission('database_backup.delete');
        $this->databaseBackupService->deleteDbBackup($databaseBackupFileName);

        return redirect()->route('databaseBackups.index')
            ->with('success', 'Database backups deleted successfully');
    }
}
