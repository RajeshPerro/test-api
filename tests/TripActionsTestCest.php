<?php

class TripActionsCest{

    /**
     * This is a test for creating a Trip
     * @param ApiTester $I
     */
    public function createTripViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPostAsJson('/trips/create', [
            'name' => 'A Trip to Mars',
            'start_from' => 'Earth',
            'end_to' => 'Mars',
            'total_spot' => '1000010001',
            'trip_date'=>'2022-03-12 11:00:00'
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "message"=> "Trip Created!",
            "success" => true,
        ]);

    }
}