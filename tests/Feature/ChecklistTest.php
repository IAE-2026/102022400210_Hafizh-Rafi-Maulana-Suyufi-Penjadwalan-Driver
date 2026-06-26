<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    use RefreshDatabase;

    private $apiKey = '102022400210';
    
    // Sesuai dengan route yang ada di api.php dan testing.md (menggunakan schedules)
    private $endpoint = '/api/v1/schedules';
    
    /**
     * Security & Standard
     */
    public function test_endpoint_menolak_request_tanpa_key()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(401);
    }

    public function test_request_dengan_key_berhasil()
    {
        $response = $this->getJson($this->endpoint, [
            'X-IAE-KEY' => $this->apiKey
        ]);
        $response->assertStatus(200);
    }

    /**
     * Fungsionalitas REST
     */
    public function test_get_resource_returns_200_and_json_wrapper()
    {
        $response = $this->getJson($this->endpoint, [
            'X-IAE-KEY' => $this->apiKey
        ]);
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data',
                     'meta'
                 ]);
    }

    public function test_get_resource_id_returns_404_and_error_wrapper()
    {
        // Using a non-existent ID like 99999
        $response = $this->getJson($this->endpoint . '/99999', [
            'X-IAE-KEY' => $this->apiKey
        ]);
        
        $response->assertStatus(404)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'errors'
                 ]);
    }

    public function test_post_resource_returns_201_and_json_wrapper()
    {
        $response = $this->postJson($this->endpoint, [
            'driver_name' => 'John Doe',
            'vehicle_id' => 1,
            'plate_number' => 'B 1234 CD',
            'schedule_date' => '2026-07-01',
            'shift' => 'pagi'
        ], [
            'X-IAE-KEY' => $this->apiKey
        ]);
        
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data',
                     'meta'
                 ]);
    }

    /**
     * API Documentation
     */
    public function test_swagger_ui_dapat_diakses()
    {
        $response = $this->get('/api/documentation');
        $response->assertStatus(200);
    }

    /**
     * GraphQL Implementation
     */
    public function test_graphql_endpoint_dapat_diakses()
    {
        $response = $this->postJson('/graphql', [
            'query' => '{ __schema { types { name } } }'
        ], [
            'X-IAE-KEY' => $this->apiKey
        ]);
        
        $response->assertStatus(200);
    }

    public function test_service_berjalan_di_docker()
    {
        $this->assertTrue(file_exists(base_path('docker-compose.yml')) || file_exists(base_path('Dockerfile')));
    }

    public function test_swagger_mencerminkan_endpoint_rest()
    {
        $response = $this->get('/docs');
        $response->assertStatus(200);
        $this->assertStringContainsString('/schedules', $response->getContent());
    }

    public function test_graphql_playground_dapat_diakses()
    {
        $response = $this->get('/graphiql');
        $response->assertStatus(200);
    }
}
