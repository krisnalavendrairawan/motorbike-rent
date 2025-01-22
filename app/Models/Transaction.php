<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by'];
    protected $fillable = [];

    protected static function booted(): void
    {
        static::creating(function (Transaction $transaction) {
            $transaction->created_by = Auth::id();
        });

        static::updating(function (Transaction $transaction) {
            $transaction->updated_by = Auth::id();
        });

        static::deleting(function (Transaction $transaction) {
            self::whereId($transaction->id)->update(['deleted_by' => Auth::id()]);
        });
    }

    // public function resolveRouteBinding($value, $field = null)
    // {
    //     return $this->whereId(Crypt::decrypt($value))->firstOrFail();
    // }

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
