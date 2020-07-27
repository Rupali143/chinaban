<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample1()
    {
       $response = $this->get('/fetch-category');
       $response->assertStatus(200);
    }

    // public function loginTest1()
    // {
    //     $response = $this->post("/admin/category");
    //     $response->assertStatus(200);
    // }

    // public function checkCategory(){
    // 	$response = $this->post("/checkCategory");
    // } 
}
