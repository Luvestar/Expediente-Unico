<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    public static function log($action, $tableName = null, $recordId = null, $oldValues = null, $newValues = null)
    {
        $user = Auth::user();
        
        AuditLog::create([
            'user_id' => $user->id ?? null,
            'user_email' => $user->email ?? null,
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}