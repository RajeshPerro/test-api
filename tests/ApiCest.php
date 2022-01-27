<?php
class ApiCest 
{    
    public function tryUserGETApi(ApiTester $I)
    {
        $I->sendGet('/user/get');
        $I->seeResponseCodeIs(200);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function tryGetOneUserApi(ApiTester $I)
    {
        $I->sendGet('/user/get/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "id"=> "1",
            "user_name" => "rajesh10",
            "user_email" => "rajesh_test@myapp.com",
            "password" => "test_pass_23",
            "mobile_number" => "+44 78267262",
            "address" => "address_test",
            "created_at" => "2022-01-22 21:08:28",
            "modified_at"=> "2022-01-22 21:46:56"
        ]);
    }

    /**
     * Test invalid userId
     * @param ApiTester $I
     */
    public function tryGetInvalidUserApi(ApiTester $I)
    {
        $I->sendGet('/user/get/1000000001');
        $I->seeResponseCodeIs(200);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "message"=> "Invalid id, No Data!",
            "success" => false,
        ]);
    }
}