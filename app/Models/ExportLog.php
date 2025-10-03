<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'format',
        'record_count',
        'file_size',
        'status',
        'filters',
        'file_path',
    ];

    protected $casts = [
        'filters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the export log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get recent export logs for a user
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return static::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
