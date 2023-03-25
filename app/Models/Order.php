<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'prica',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne {
        return $this->hasOne(Payment::class);
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class);
    }
}
