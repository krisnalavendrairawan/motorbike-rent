<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Rental extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rental';
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $fillable = [];

    protected static function booted(): void
    {
        static::creating(function (Rental $rental) {
            $rental->created_by = Auth::id();
        });

        static::updating(function (Rental $rental) {
            $rental->updated_by = Auth::id();
        });

        static::deleting(function (Rental $rental) {
            self::whereId($rental->id)->update(['deleted_by' => Auth::id()]);
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

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'motor_id');
    }

    public function returns()
    {
        return $this->belongsTo(Returns::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
