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

    private $type_list_ALPHA = array(
        '𝚨',
        '𝛢',
        '𝜜',
        '𝝖',
        '𝞐'
    );

    private $type_list_alpha = array(
        '𝛂',
        '𝛼',
        '𝜶',
        '𝝰',
        '𝞪',
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
                "result" => "",
                "prev_function" => [1, 1, 1, 0]
            ]);
        }

        //deeplで翻訳する場合はtrue
        $deepl_flag = true;
        if ($request->has("change")) {
            $deepl_flag = false;
        }

        $function = $request->function;

        $change_code_flag = (is_array($function) and array_key_exists("0", $function));
        $delete_enter_flag = (is_array($function) and array_key_exists("1", $function));
        $restore_word_flag = (is_array($function) and array_key_exists("2", $function));
        $ignore_enters_flag = (is_array($function) and array_key_exists("3", $function));

        $text = $request->target;
        $target = $text;
        $result = "";


        for ($i = 0; $i < mb_strlen($target); $i++) {
            $tmp = mb_substr($target, $i, 1);
            //deepLで翻訳する場合は/の前に\がいる
            if ($deepl_flag and $tmp == '/') {
                $result .= "\\/";
                continue;
            }

            //単語の復元
            if ($tmp == "-" and $restore_word_flag) {
                while (true) {
                    if (($i + 1 != mb_strlen($target)) and (preg_match("/\r|\n| /", mb_substr($target, $i + 1, 1)))) {
                        $i++;
                    } else {
                        break;
                    }
                }
                continue;
            }


            //連続する改行を削除
            $ncount = 0;
            if (preg_match("/\r|\n/", $tmp) and $delete_enter_flag) {
                while (true) {
                    if (mb_substr($target, $i, 1) == "\n") {
                        $ncount++;
                    }
                    if (($i + 1 != mb_strlen($target)) and (preg_match("/\r|\n/", mb_substr($target, $i + 1, 1)))) {
                        $i++;
                    } else {
                        break;
                    }
                }
                if ($ignore_enters_flag and $ncount >= 2) {
                    for ($j = 0; $j < $ncount; $j++) {
                        $result .= "\n";
                    }
                } else {
                    $result .= " ";
                }

                continue;
            }

            //英数字記号の変換
            if ($change_code_flag) {
                $tmp = $this->to_normal($tmp);
            }

            $result .= $tmp;
        }

        if ($deepl_flag) {
            $url = "https://www.deepl.com/ja/translator#en/ja/" . rawurlencode($result);
            return redirect($url);
        } else {
            return view("mypages.to_normal", [
                "text" => $text,
                "result" => $result,
                "prev_function" => $function
            ]);
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

        foreach ($this->type_list_ALPHA as $A) {
            $char = $this->check_and_change($char, $a, 'Α', 26);
        }

        foreach ($this->type_list_alpha as $a) {
            $char = $this->check_and_change($char, $a, 'α', 25);
        }

        foreach ($this->type_list_num as $n) {
            $char = $this->check_and_change($char, $n, '0', 10);
        }

        return $char;
    }
}
