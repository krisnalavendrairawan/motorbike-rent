<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Returns extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'return';
    protected $guarded = ['id'];
    protected $fillable = ['rental_id', 'return_date', 'status'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            self::whereId($model->id)->update(['deleted_by' => Auth::id()]);
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

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
