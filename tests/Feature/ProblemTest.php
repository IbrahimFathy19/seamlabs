<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProblemTest extends TestCase
{
    public function test_problem_1_valid()
    {
        $response = $this->get('/api/problem/1?start=1&end=8');
        $response->assertJson([
            'object' => [
                "count" => 7
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_1_valid_negative()
    {
        $response = $this->get('/api/problem/1?start=-1&end=8');
        $response->assertJson([
            'object' => [
                "count" => 9
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_1_bad_request_end_not_found()
    {
        $response = $this->get('/api/problem/1?start=1');
        $response->assertStatus(400);
    }

    public function test_problem_1_bad_request_end_is_lte_start()
    {
        $response = $this->get('/api/problem/1?start=1&end=0');
        $response->assertStatus(400);
    }

    public function test_problem_2_valid_ex1()
    {
        $response = $this->get('/api/problem/2?input_string=A');
        $response->assertJson([
            'object' => [
                "sum" => 1
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_valid_ex2()
    {
        $response = $this->get('/api/problem/2?input_string=AA');
        $response->assertJson([
            'object' => [
                "sum" => 27
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_valid_ex3()
    {
        $response = $this->get('/api/problem/2?input_string=BFG');
        $response->assertJson([
            'object' => [
                "sum" => 1515
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_valid_ex4()
    {
        $response = $this->get('/api/problem/2?input_string=AAA');
        $response->assertJson([
            'object' => [
                "sum" => 703
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_valid_ex5()
    {
        $response = $this->get('/api/problem/2?input_string=AZA');
        $response->assertJson([
            'object' => [
                "sum" => 1353
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_valid_ex6()
    {
        $response = $this->get('/api/problem/2?input_string=ABB');
        $response->assertJson([
            'object' => [
                "sum" => 730
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_2_bad_request_input_string_not_found()
    {
        $response = $this->get('/api/problem/2');
        $response->assertStatus(400);
    }

    public function test_problem_3_valid_ex1()
    {
        $response = $this->post('/api/problem/3', [
            'q_array' => [3, 4]
        ]);
        $response->assertJson([
            'object' => [
                "result" => [3, 3]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_3_valid_ex2()
    {
        $response = $this->post('/api/problem/3', [
            'q_array' => [1, 5]
        ]);
        $response->assertJson([
            'object' => [
                "result" => [1, 4]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_problem_3_bad_request_q_array_not_found()
    {
        $response = $this->post('/api/problem/3');
        $response->assertStatus(400);
    }
}
