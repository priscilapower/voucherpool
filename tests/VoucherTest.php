<?php

class VoucherTest extends TestCase
{
    /**
     * @return void
     */
    public function testAllVouchers()
    {
        $response = $this->json('GET','/');
        $response->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testGenerateVouchers()
    {
        $response = $this->json('POST', '/generate-voucher', ['special_offer_id' => 4,
                                                                         'expiration_date' => '2018-08-30']);
        $response->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testGenerateVouchersInvalid()
    {
        $response = $this->json('POST', '/generate-voucher', ['special_offer' => 4,
                                                                         'expiration_date' => '07/31/2018']);
        $response->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testValidateVoucher()
    {
        $response = $this->json('POST', '/validate-voucher', ['voucher_code' => 'w3CwnlUT',
                                                                         'email' => 'hlarson@example.net']);
        $response->assertResponseOk();
        $response->assertEquals(26.00, $response);
    }

    /**
     * @return void
     */
    public function testValidateVoucherInvalid()
    {
        $response = $this->json('POST', '/validate-voucher', ['voucher' => 'Lh8Guee8',
                                                                         'email' => 'sydney08']);
        $response->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testRecipientVouchers()
    {
        $response = $this->json('POST', '/recipient-vouchers', ['email' => 'verda.schoen@example.org']);
        $response->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testRecipientVouchersInvalid()
    {
        $response = $this->json('POST', '/recipient-vouchers', ['email' => 'emailtest@']);
        $response->assertResponseOk();
    }
}
