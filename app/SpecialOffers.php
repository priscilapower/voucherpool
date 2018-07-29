<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'percentage_discount',
    ];

    public function voucherCodes()
    {
        return $this->hasMany(VoucherCodes::class);
    }
}
