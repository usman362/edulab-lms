<?php

namespace Modules\LMS\Models\Purchase;

use Modules\LMS\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\PaymentDocument;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentDocument(): HasOne
    {
        return $this->hasOne(PaymentDocument::class);
    }


    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

}
