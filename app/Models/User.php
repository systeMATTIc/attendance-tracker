<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $user) {
            $user->uuid = Str::uuid()->toString();
        });
    }

    /**
     * The attributes that are mass assignable. 
     *
     * @var array
     */
    protected $fillable = [
        "uuid",
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'travel_type_id',
        'distance_from_home'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => "boolean"
    ];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, "user_uuid", "uuid");
    }

    public function logOwnAttedance()
    {
        $userHaveloggedAttendanceForCurrentDay = $this->attendances()
            ->getBaseQuery()->whereDate('time_in', today())
            ->exists();

        if ($userHaveloggedAttendanceForCurrentDay) {
            throw new Exception("You have already logged your attendance for today !!!");
        }

        $this->attendances()->create([
            "time_in" => now(),
        ]);
    }
}
