<?php

class ReserveActionsCest{

    private static $trip_id;
    private static $user_id;
    private static $reserve_id;

    /**
     * This is a test for creating a Reserve
     * Step - 1 : We try to create a User
     * Step - 2 : We try to create a Trip
     * Step - 3 : We Grab those User and Trip IDs and Crate Reserve with that
     * @param ApiTester $I
     */
    public function createUserTest(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        //Create User
        $I->sendPostAsJson('/user/create', [
            'user_name' => 'Mr.Test User',
            'user_email' => 'test_user@myapp.com',
            'password' => 'EarthIsAwesome#123',
            'mobile_number' => '+48605122990',
            'address' => 'Lodz, Poland',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        self::$user_id = $I->grabDataFromResponseByJsonPath('$.created_user_id')[0];

        $I->seeResponseContainsJson([
            "message"=> "User Created!",
            "success" => true,
            "created_user_id" => self::$user_id
        ]);

    }

    /**
     * This is a test for creating a Trip
     * @param ApiTester $I
     */
    public function createTripTest(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        //Create Trip
        $I->sendPostAsJson('/trips/create', [
            'name' => 'A Trip to Mars',
            'start_from' => 'Earth',
            'end_to' => 'Mars',
            'total_spot' => '1',
            'trip_date'=>'2022-03-12 11:00:00'
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        self::$trip_id = $I->grabDataFromResponseByJsonPath('$.created_trip_id')[0];

        $I->seeResponseContainsJson([
            "message"=> "Trip Created!",
            "success" => true,
            "created_trip_id" => self::$trip_id
        ]);

    }

    /**
     * This is a test for creating a Reserve
     * Step - 1 : Grab the user_id from previous test
     * Step - 2 : Grab the trip_id from previous test
     * Step - 3 : Use those User and Trip IDs and Crate Reserve with that
     * @param ApiTester $I
     */
    public function createReserveTest(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $create_reserve_mutation_data = [
            'user_id' => self::$user_id,
            'trip_id' => self::$trip_id,
            'number_of_spots' => 5
        ];

        /*
         * Test #1
        Test Create Reserve, we are trying to create
        with more space that we have created in Trip above
       */
        $I->sendPostAsJson('/reserve/create',$create_reserve_mutation_data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "error"=> "Not enough spots",
            "success" => false
        ]);

        /**
         *Test #2
         * Test Create Reserve, with proper data
         * We have created Trip above with total_spot = 1
         * So, this request should work, and we should be able to
          reserve the spot.
        */
        $create_reserve_mutation_data['number_of_spots'] = 1;
        $I->sendPostAsJson('/reserve/create',$create_reserve_mutation_data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        self::$reserve_id = $I->grabDataFromResponseByJsonPath('$.created_reserve_id')[0];
        $I->seeResponseContainsJson([
            "message"=> "OK",
            "success" => true,
            "created_reserve_id" => self::$reserve_id
        ]);

        /**
         * Test #3
         * Test Create Reserve, with proper data
         * We have created Trip above with total_spot = 1
         * and in previous request we have successfully reserved that spot!
         * So, this spot should show us the error message
         */
        $I->sendPostAsJson('/reserve/create',$create_reserve_mutation_data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "error"=> "Sold out!",
            "success" => false
        ]);


    }

    /**
     * This is a test for cancel a spot and then
      book it again.
     * Background :
        Due to the reason our last test was try to book the trip which we have
        create above and it showed us "Sold out!" because trip had 1 spot and it
        was reserved!
     * So, now we want to cancel that and re-book the spot by the business logic,
        it should allow us to do that.
     * @param ApiTester $I
     */
    public function cancelAndReserveAgainTest(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $cancel_reserve_mutation_data = [
            'number_of_spots' => 5
        ];

        //Test #4 : We are trying to cancel more spots than we have!
        $I->sendPutAsJson('/reserve/cancel/'.self::$reserve_id,$cancel_reserve_mutation_data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "message"=> "Invalid `id`/ param",
            "success" => false
        ]);

        /**
         * Test #5 : We are actually Cancelling the reservation this time!
            also testing flexible reservation by passing params
         */
        $cancel_reserve_mutation_data['number_of_spots'] = 1;
        $I->sendPutAsJson('/reserve/cancel/'.self::$reserve_id,$cancel_reserve_mutation_data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "message"=> "1 spot cancelled!",
            "success" => true
        ]);

        /**
         * Test #6: Now we are booking that cancelled spot
            by the logic it should allow us to do such operation
         */
        $I->sendPostAsJson('/reserve/create',[
            'user_id' => self::$user_id,
            'trip_id' => self::$trip_id,
            'number_of_spots' => 1
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

      $newly_created_reserve_id = $I->grabDataFromResponseByJsonPath('$.created_reserve_id')[0];
        $I->seeResponseContainsJson([
            "message"=> "OK",
            "success" => true,
            "created_reserve_id" => $newly_created_reserve_id
        ]);
    }
}