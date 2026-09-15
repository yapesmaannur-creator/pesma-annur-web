<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'date',
        'location',
        'time_start',
        'time_end',
        'organizer',
        'contact_person',
        'registration_link',
        'max_participants',
        'is_active',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_active' => 'boolean',
            'max_participants' => 'integer',
        ];
    }

    public function isUpcoming(): bool
    {
        return $this->status === 'upcoming';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getFormattedScheduleAttribute(): string
    {
        $schedule = '';
        if ($this->date) {
            $schedule = Carbon::parse($this->date)->translatedFormat('l, d F Y');
        }
        if ($this->time_start) {
            $schedule .= ' | ' . Carbon::parse($this->time_start)->format('H:i');
            if ($this->time_end) {
                $schedule .= ' - ' . Carbon::parse($this->time_end)->format('H:i');
            }
            $schedule .= ' WIB';
        }
        return $schedule ?: 'Belum ditentukan';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'upcoming' => 'Mendatang',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'upcoming' => 'primary',
            'ongoing' => 'success',
            'completed' => 'secondary',
            'cancelled' => 'danger',
            default => 'warning',
        };
    }
}
