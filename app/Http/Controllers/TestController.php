<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $s = $request->s;
        $len = strlen($s);
        if ($len < 2 || $len > 10000) {
            return $this->error('param length error');
        }
        $map = [
            '(' => ')',
            '[' => ']',
            '{' => '}'
        ];
        $sArr = str_split($s);
        $stack = [];

        foreach ($sArr as $item) {
            if (!empty($stack) && $map[end($stack)] == $item) {
                array_pop($stack);
            } else {
                array_push($stack, $item);
            }
        }

        if (!empty($stack)) {
            return $this->error('param format error');
        }
        return $this->success(true);

    }

}
