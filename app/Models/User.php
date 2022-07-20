<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['imageString'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function updateUser($data)
    {
        self::update($data);

        return self::refresh();
    }

    public function getImageStringAttribute()
    {   
        if (is_null($this->photo)) 
            return null;

        $path = explode('/', $this->photo);

        $type = pathinfo(Storage::path($path[2]), PATHINFO_EXTENSION);
        $data = Storage::get($this->photo);
        $base64 = 'data:face_image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
