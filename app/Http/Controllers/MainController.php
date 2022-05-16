<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    private $type_list_A = array(
        '𝐀',
        '𝐴',
        '𝑨',
        '𝖠',
        '𝗔',
        '𝘈',
        '𝘼',
        '𝒜',
        '𝓐',
        '𝔄',
        '𝕬',
        '𝙰',
        '𝔸',
    );
    private $type_list_a = array(
        '𝐚',
        '𝑎',
        '𝒂',
        '𝖺',
        '𝗮',
        '𝘢',
        '𝙖',
        '𝒶',
        '𝓪',
        '𝔞',
        '𝖆',
        '𝚊',
        '𝕒'
    );


    public function main()
    {
        return view('main');
    }


    public function check_and_change($char, $type, $normal)
    {
        $target_ord = mb_ord($char);
        $type_ord = mb_ord($type);
        $normal_ord = mb_ord($normal);
        if ($type_ord <= $target_ord and $target_ord <= $type_ord + 25) {
            $target_ord = $normal_ord + $target_ord - $type_ord;
        }

        return mb_chr($target_ord);
    }

    public function to_normal($char)
    {
        foreach ($this->type_list_A as $A) {
            $char = $this->check_and_change($char, $A, 'A');
        }

        foreach ($this->type_list_a as $a) {
            $char = $this->check_and_change($char, $a, 'a');
        }


        return $char;
    }

    public function change(Request $request)
    {
        $target = $request->target;

        $result = "";
        for ($i = 0; $i < mb_strlen($target); $i++) {
            $tmp = mb_substr($target, $i);
            $tmp = $this->to_normal($tmp);
            $result .= $tmp;
        }

        return view("changed", [
            "result" => $result
        ]);
    }
}
