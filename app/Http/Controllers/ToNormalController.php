<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        if ($request->isMethod(('get')) or $request->has("reset")) {
            return view("mypages.to_normal", [
                "text" => "",
                "result" => "",
                "prev_function" => [1, 1, 1, 0, 0]
            ]);
        }

        //deeplで翻訳する場合はtrue
        $deepl_flag = true;
        if ($request->has("change")) {
            $deepl_flag = false;
        }

        $function = $request->function;
        $change_code_flag = false;
        $delete_enter_flag = false;
        $restore_word_flag = false;
        $ignore_enters_flag = false;
        $enter_if_period_flag = false;
        if (is_array($function)) {
            $change_code_flag =  array_key_exists("0", $function);
            $delete_enter_flag = array_key_exists("1", $function);
            $restore_word_flag = array_key_exists("2", $function);
            $ignore_enters_flag = array_key_exists("3", $function);
            $enter_if_period_flag = array_key_exists("4", $function);
        }

        $original_text = $request->target;
        $validator = Validator::make($request->all(), [
            'target' =>  'max:500000'
        ]);
        if ($validator->fails()) {
            return view("mypages.to_normal", [
                "text" => $original_text,
                "result" => "エラー: 入力文字列が長すぎます",
                "prev_function" => $function
            ]);
        }
        $target = $original_text;
        $result = "";





        $idx = 0;


        //対象テキストを1文字ずつ分割して配列に格納
        $target_array = mb_str_split($target);
        $target_len = count($target_array);

        while ($idx < $target_len) {
            $current_chr = $target_array[$idx];

            //deepLで翻訳する場合は/の前に\がいる
            if ($deepl_flag and $current_chr == '/') {
                $result .= "\\/";
                $idx++;
                continue;
            }

            //単語の復元
            if ($current_chr == "-" and $restore_word_flag and ($idx + 1 != $target_len and preg_match("/\r|\n| /", $target_array[$idx + 1]))) {
                while (true) {
                    $idx++;
                    if ($idx == $target_len) break;
                    $current_chr = $target_array[$idx];
                    if (!preg_match("/\r|\n| /", $current_chr)) {
                        break;
                    }
                }
                continue;
            }

            //連続する改行を削除
            $enter_count = 0;
            if ($delete_enter_flag and preg_match("/\r|\n/", $current_chr)) {
                while (true) {
                    if ($current_chr == "\n") {
                        $enter_count++;
                    }
                    $idx++;
                    if ($idx == $target_len) break;

                    $current_chr = $target_array[$idx];
                    if (!preg_match("/\r|\n/", $current_chr)) {
                        break;
                    }
                }

                //2つ以上の改行があった場合は改行を復元
                if ($ignore_enters_flag and $enter_count >= 2) {
                    for ($j = 0; $j < $enter_count; $j++) {
                        $result .= "\n";
                    }
                } else {
                    $result .= " ";
                }
                continue;
            }


            if ($enter_if_period_flag and $current_chr == "." and $idx + 1 != $target_len and preg_match("/\r|\n| /", $target_array[$idx + 1])) {
                $buffer = ".";
                $enter_count = 0;

                while (true) {
                    $idx++;
                    if ($idx == $target_len) break;

                    $current_chr = $target_array[$idx];
                    if ($current_chr == "\n") {
                        $enter_count++;
                    }
                    if (!preg_match("/\r|\n| /", $current_chr)) {
                        break;
                    } else {
                        $buffer .= $current_chr;
                    }
                }

                $tmp_code = mb_ord($current_chr);
                if (mb_ord("A") <= $tmp_code and $tmp_code <= mb_ord("Z")) {
                    $result .= ".";
                    if ($ignore_enters_flag and $enter_count >= 2) {
                        for ($j = 0; $j < $enter_count; $j++) {
                            $result .= "\n";
                        }
                    } else {
                        $result .= "\n";
                    }
                } else {
                    $result .= $buffer;
                }
                continue;
            }


            //英数字記号の変換
            if ($change_code_flag) {
                $current_chr = $this->to_normal($current_chr);
            }

            $result .= $current_chr;
            $idx++;
        }

        if ($deepl_flag) {
            $url = "https://www.deepl.com/ja/translator#en/ja/" . rawurlencode($result);
            return redirect($url);
        } else {
            return view("mypages.to_normal", [
                "text" => $original_text,
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
