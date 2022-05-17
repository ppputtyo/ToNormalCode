<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToNormalController extends Controller
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



    public function to_normal_code(Request $request)
    {
        if ((!$request->has("change") and !$request->has("translate")) or $request->has("reset")) {
            return view("mypages.to_normal", [
                "text" => "",
                "result" => ""
            ]);
        }
        $text = $request->target;
        $target = $text;
        $result = "";
        for ($i = 0; $i < mb_strlen($target); $i++) {
            $tmp = mb_substr($target, $i, 1);

            if (
                ($tmp == "-") and ($i + 1 != mb_strlen($target)) and (preg_match("/\r\n|\r|\n| /", mb_substr($target, $i + 1, 1)))
            ) {
                $i += 2;
                continue;
            }

            if (preg_match("/\r\n|\r|\n/", $tmp)) {
                $tmp = " ";
            }
            $tmp = $this->to_normal($tmp);

            $result .= $tmp;
        }

        if ($request->has("change")) {
            return view("mypages.to_normal", [
                "text" => $text,
                "result" => $result
            ]);
        } else {
            $url = "https://www.deepl.com/ja/translator#en/ja/" . rawurlencode($result);
            return redirect($url);
        }
    }

    public function check_and_change($char, $type, $normal, $num)
    {
        $target_ord = mb_ord($char);
        $type_ord = mb_ord($type);
        $normal_ord = mb_ord($normal);
        if ($type_ord <= $target_ord and $target_ord <= $type_ord + $num - 1) {
            $target_ord = $normal_ord + $target_ord - $type_ord;
        }

        return mb_chr($target_ord);
    }

    public function to_normal($char)
    {
        foreach ($this->type_list_A as $A) {
            $char = $this->check_and_change($char, $A, 'A', 26);
        }

        foreach ($this->type_list_a as $a) {
            $char = $this->check_and_change($char, $a, 'a', 26);
        }

        foreach ($this->type_list_num as $n) {
            $char = $this->check_and_change($char, $n, '0', 10);
        }


        return $char;
    }
}
