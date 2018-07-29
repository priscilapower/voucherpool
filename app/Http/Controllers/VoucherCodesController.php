<?php

namespace App\Http\Controllers;

use App\Recipients;
use App\VoucherCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherCodesController extends Controller
{
    /**
     * return all voucher codes
     *
     * @return VoucherCodes[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $vouchers = VoucherCodes::all();
        return $vouchers;
    }

    /**
     * generate a voucher code to each recipient from a special offer and an expiration date
     *
     * @param Request $request
     * @return array|JsonResponse|\Illuminate\Support\MessageBag
     */
    public function generateVoucher(Request $request)
    {
        $data = $request->all();
        $response = [];

        //validate the request data
        $validator = Validator::make($data, [
            'special_offer_id' => 'required|integer',
            'expiration_date' => 'required|date'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        try {
            $recipients = Recipients::all();
            foreach ($recipients as $recipient) {
                $voucher = [];
                $voucher['special_offer_id'] = $data['special_offer_id'];
                $voucher['expiration_date'] = $data['expiration_date'];
                $voucher['recipient_id'] = $recipient->id;
                $voucher['code'] = VoucherCodes::generateCode();

                $response[] = VoucherCodes::create($voucher);
            }

            return $response;
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * validate the voucher code by checking the code, if it's used, the expiration date and the email
     * if it's valid, return the value of percentage discount
     *
     * @param Request $request
     * @return JsonResponse|\Illuminate\Support\MessageBag
     */
    public function validateVoucher(Request $request)
    {
        $data = $request->all();

        //validate the request data
        $validator = Validator::make($data, [
            'voucher_code' => 'required|string',
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $voucher = VoucherCodes::where('code', $data['voucher_code'])
                                ->where('used', false)
                                ->whereDate('expiration_date', '>=', $date)
                                ->whereHas('recipient', function ($query) use ($data) {
                                    $query->where('email', $data['email']);
                                })
                                ->first();

        if($voucher) {
            $date = new \DateTime();
            $voucher->usage_date = $date;
            $voucher->used = true;
            $voucher->save();

            return new JsonResponse(['percentage_discount' => $voucher->specialOffer->percentage_discount], 200);
        }

        return new JsonResponse(['message' => 'The voucher is not valid!'], 200);
    }

    /**
     * return the valids vouchers by a recipient email
     *
     * @param Request $request
     * @return VoucherCodes[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|JsonResponse|\Illuminate\Support\Collection|\Illuminate\Support\MessageBag
     */
    public function getVoucherByRecipientEmail(Request $request)
    {
        $data = $request->all();

        //validate the request data
        $validator = Validator::make($data, [
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $vouchers = VoucherCodes::with('specialOffer:id,name')
                                ->where('used', false)
                                ->whereDate('expiration_date', '>=', $date)
                                ->whereHas('recipient', function ($query) use ($data) {
                                    $query->where('email', $data['email']);
                                })
                                ->get();

        if($vouchers->count() > 0) {
            return $vouchers;
        }
        return new JsonResponse(['message' => "There's no valid voucher codes!"], 200);
    }
}
