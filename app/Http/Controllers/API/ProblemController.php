<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

define("ALPHABETICAL_CHARACTERS_COUNT", 26);

class ProblemController extends Controller
{

    public function problem_1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|integer',
            'end' => 'required|integer|gte:start',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $start = $validator->validated()['start'];
        $end = $validator->validated()['end'];

        $count = 0;
        for ($i = $start; $i <= $end; $i++) {
            if (!str_contains((string)$i, '5')) {
                $count++;
            }
        }
        return $this->handleResponse([
            'count' => $count
        ]);
    }

    public function problem_2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_string' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $str = $validator->validated()['input_string'];
        $str_length = strlen($str);

        $sum = 0;
        for ($i = 0; $i < $str_length; $i++) {
            $sum += (ord($str[$i]) - 64) * pow(ALPHABETICAL_CHARACTERS_COUNT, $str_length - 1 - $i);
        }

        return $this->handleResponse([
            'sum' => $sum
        ]);
    }

    public function problem_3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q_array' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $arr = $validator->validated()['q_array'];
        $result = [];
        foreach ($arr as $x) {
            $counter = 0;
            while ($x !== 0) {
                // find minimum numbers that give minimum sum
                $a = (int)ceil(sqrt($x));
                $b = (int)($x / $a);

                if ($a !== 1 && $b !== 1) {
                    $x = max($a, $b);
                } else {
                    $x--;
                }
                $counter++;
            }
            array_push($result, $counter);
        }
        return $this->handleResponse([
            'result' => $result
        ]);
    }
}
