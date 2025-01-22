<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service';
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $fillable = [];

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            $service->created_by = Auth::id();
        });

        static::updating(function (Service $service) {
            $service->updated_by = Auth::id();
        });

        static::deleting(function (Service $service) {
            self::whereId($service->id)->update(['deleted_by' => Auth::id()]);
        });
    }

    public function getEncryptedIdAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->whereId(Crypt::decrypt($value))->firstOrFail();
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }
}
