<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCodes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'used',
        'expiration_date',
        'usage_date',
        'recipient_id',
        'special_offer_id',
    ];

    /**
     * get the related recipient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Recipients::class);
    }

    /**
     * get the related special offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialOffer()
    {
        return $this->belongsTo(SpecialOffers::class);
    }

    /**
     * generate the random code and verify if already exists
     *
     * @return string
     */
    public static function generateCode()
    {
        do {
            $rand = str_random(8);
            $code = self::where('code', $rand)->first();
        } while (!empty($code));

        return $rand;
    }
}
