<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        "uuid",
        "user_uuid",
        "time_in",
        "time_out"
    ];

    protected $dates = [
        "time_in", "time_out"
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $attendance) {
            $attendance->uuid = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_uuid");
    }

    public function close()
    {
        if (!is_null($this->time_out)) {
            throw new Exception("This attendance log had been closed. Cannot close again !!!");
        }

        $this->update(["time_out" => now()]);
    }
}
