<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupDatabaseController extends Controller
{
    public function backupDatabase()
    {
        try {
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbHost = env('DB_HOST', '127.0.0.1');

            $filename = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
            $storagePath = storage_path('app/backups/' . $filename);

            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$storagePath}";

            exec($command, $output, $resultCode);

            if ($resultCode !== 0) {
                return back()->with('error', 'Backup failed. Check server permissions or mysqldump path.');
            }

            return back()->with('success', "Database backup saved to backups/{$filename}");
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
}