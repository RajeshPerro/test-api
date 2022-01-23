<?php
class ApiCest 
{    
    public function tryUserGETApi(ApiTester $I)
    {
        $I->sendGet('/user/get');
        $I->seeResponseCodeIs(200);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'user_name' => 'string',
            'user_email' => 'string:email',
            'password' => 'string|null',
            'mobile_number' => 'string|null',
            'address' => 'string|null',
            'created_at' => 'string',
            'modified_at' => 'string',
        ]);
    }
}