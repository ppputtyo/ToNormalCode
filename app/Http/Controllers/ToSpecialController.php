<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToSpecialController extends Controller
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

    private $type_list_num = array(
        '𝟎',
        '𝟘',
        '𝟢',
        '𝟬',
        '𝟶'
    );



    public function to_special_code(Request $request)
    {
        $text = $request->target;
        $target = $text;
        $code = $request->code;
        $result = "";

        for ($i = 0; $i < mb_strlen($target); $i++) {
            $tmp = mb_substr($target, $i, 1);
            $tmp = $this->to_special($tmp, $code);
            $result .= $tmp;
        }

        return view("mypages.to_special", [
            "code" => $code,
            "text" => $text,
            "result" => $result
        ]);
    }


    public function to_special($char, $code)
    {
        $ord_A = mb_ord('A');
        $ord_a = mb_ord('a');
        $ord_1 = mb_ord('1');
        $target_ord = mb_ord($char);

        if ($ord_A <= $target_ord and $target_ord <= $ord_A + 25) {
            $target_ord += mb_ord($this->type_list_A[$code]) - $ord_A;
        } elseif ($ord_a <= $target_ord and $target_ord <= $ord_a + 25) {
            $target_ord += mb_ord($this->type_list_a[$code]) - $ord_a;
        }

        return mb_chr($target_ord);
    }
}
