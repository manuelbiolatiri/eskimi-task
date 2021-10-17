<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignEndpointsTest extends TestCase
{
    /**
     * Required fields for creating campaign
     *
     * @return void
     */
    public function testRequiredFieldsForCreatingCampaign()
    {
        $this->json('POST', 'api/campaigns', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "from" => ["The from field is required."],
                    "to" => ["The to field is required."],
                    "daily_budget" => ["The daily budget field is required."],
                    "total_budget" => ["The total budget field is required."]
                ]
            ]);
    }


    public function testSuccessfulCampaignCreation()
    {
        $userData = [
            "name" => "Test",
            "from" => date('Y-m-d'),
            "to" => date('Y-m-d'),
            'total_budget' => 1000,
            'daily_budget' => 100,
        ];

        $this->json('POST', 'api/campaigns', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "campaign" => [
                    'id',
                    'name',
                    'from',
                    'to',
                    'daily_budget',
                    'total_budget',
                ],
            ]);
    }
}
