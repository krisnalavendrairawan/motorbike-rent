<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    protected $table = 'customer';
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $fillable = [];

    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            $customer->created_by = Auth::id();
        });

        static::updating(function (Customer $customer) {
            $customer->updated_by = Auth::id();
        });

        static::deleting(function (Customer $customer) {
            self::whereId($customer->id)->update(['deleted_by' => Auth::id()]);
        });
    }

    protected function encryptedId(): Attribute
    {
        return Attribute::make(
            get: fn() => Crypt::encrypt($this->id)
        );
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->whereId(Crypt::decrypt($value))->firstOrFail();
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
