<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Motor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'motor';
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $fillable = [];

    protected static function booted(): void
    {
        static::creating(function (Motor $motor) {
            $motor->created_by = Auth::id();
        });

        static::updating(function (Motor $motor) {
            $motor->updated_by = Auth::id();
        });

        static::deleting(function (Motor $motor) {
            self::whereId($motor->id)->update(['deleted_by' => Auth::id()]);
        });
    }

    // public function getEncryptedIdAttribute()
    // {
    //     return Crypt::encrypt($this->id);
    // }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->whereId(Crypt::decrypt($value))->firstOrFail();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function Rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function activeRentals()
    {
        return $this->hasMany(Rental::class);
    }
}
