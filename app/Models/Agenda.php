<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'end_date',
        'time',
        'end_time',
        'location',
        'organizer',
        'image',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Accessor for time attribute to ensure standard 00:00 WIB format
     */
    public function getTimeAttribute($value)
    {
        if (!$value) return null;
        $val = str_replace('.', ':', trim($value));
        if (preg_match('/^\d{1,2}:\d{2}$/', $val)) {
            return $val . ' WIB';
        }
        return $val;
    }

    /**
     * Accessor for end_time attribute to ensure standard 00:00 WIB format
     */
    public function getEndTimeAttribute($value)
    {
        if (!$value) return null;
        $val = str_replace('.', ':', trim($value));
        if (preg_match('/^\d{1,2}:\d{2}$/', $val)) {
            return $val . ' WIB';
        }
        return $val;
    }
    /**
     * Automatically delete agendas that have passed their end_date (or date if end_date is null).
     */
    public static function cleanupExpired()
    {
        $expired = self::where('is_active', true)
            ->where(function($query) {
                $query->whereNotNull('end_date')->whereDate('end_date', '<', now()->toDateString());
            })->orWhere(function($query) {
                $query->whereNull('end_date')->whereDate('date', '<', now()->toDateString());
            })->get();

        foreach($expired as $agenda) {
            $agenda->update(['is_active' => false]);
        }
    }
}
