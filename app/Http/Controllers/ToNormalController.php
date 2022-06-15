<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;


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

    // 正規表現に合う文字を削除
    private function delete_chrs(&$target_array, $target_len, &$idx, $re, $count_chr = '')
    {
        if ($idx >= $target_len) return -1;
        $res_count = 0;
        do {
            $current_chr = $target_array[$idx];
            if ($current_chr == $count_chr) $res_count++;
            if (!preg_match($re, $current_chr)) break;
        } while (++$idx != $target_len);

        return $res_count;
    }

    private function check_next_chr(&$target_array, $target_len, $idx, $re)
    {
        return ($idx + 1 != $target_len and preg_match($re, $target_array[$idx + 1]));
    }

    public function to_normal_code(Request $request)
    {
        if ($request->isMethod(('get'))) {
            return view("mypages.to_normal", [
                "text" => "",
                "result" => "",
                "prev_function" => [1, 1, 1, 0, 0, 1, 0],
                "url" => []
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
        $split_5000_flag = false;

        if (is_array($function)) {
            $change_code_flag =  array_key_exists("0", $function);
            $delete_enter_flag = array_key_exists("1", $function);
            $restore_word_flag = array_key_exists("2", $function);
            $ignore_enters_flag = array_key_exists("3", $function);
            $enter_if_period_flag = array_key_exists("4", $function);
            $split_5000_flag = array_key_exists("5", $function);
        }

        $original_text = $request->target;
        $target = $original_text;

        //対象テキストを1文字ずつ分割した配列
        $target_array = mb_str_split($target);
        $target_len = count($target_array);
        //対象テキストの何文字目を読んでるか
        $idx = 0;

        //5000文字以内の文章を要素に持つ配列
        $result_array = array();
        $result_idx = 0;
        array_push($result_array, "");

        //一時的なバッファ
        $tmp_buffer = "";

        $special_chrs_on_deepl = ['/', '|'];

        //1文字ずつ読んでいく
        while ($idx < $target_len) {
            //現在の文字
            $current_chr = $target_array[$idx];

            //deepLで翻訳する場合は/、|の前に\がいる
            if ($deepl_flag and in_array($current_chr, $special_chrs_on_deepl, true)) {
                $tmp_buffer .= "\\" . $current_chr;
                $idx++;
                continue;
            }

            //単語の復元
            if ($current_chr == "-" and $restore_word_flag and $this->check_next_chr($target_array, $target_len, $idx, "/\r|\n| /")) {
                //改行、空白を読み進める
                $idx++;
                $this->delete_chrs($target_array, $target_len, $idx, "/\r|\n| /");
                continue;
            }

            //連続する改行を削除
            if ($delete_enter_flag and preg_match("/\r|\n/", $current_chr)) {
                $enter_count = $this->delete_chrs($target_array, $target_len, $idx, "/\r|\n/", "\n");

                //2つ以上の改行があった場合は改行を復元
                if ($ignore_enters_flag and $enter_count >= 2) {
                    for ($j = 0; $j < $enter_count; $j++) {
                        $tmp_buffer .= "\n";
                    }
                } else {
                    $tmp_buffer .= " ";
                }
                continue;
            }

            //ピリオド出現時
            if ($current_chr == ".") {
                $tmp_buffer .= ".";
                $tmpidx = ++$idx;

                //tmpidx: 次の文字が出現する位置
                $enter_count = $this->delete_chrs($target_array, $target_len, $tmpidx, "/\r|\n| /", "\n");

                $end_of_sentence_flag = false;
                if ($tmpidx != $target_len) {
                    $tmp_code = mb_ord($target_array[$tmpidx]);
                    if (mb_ord("A") <= $tmp_code and $tmp_code <= mb_ord("Z")) {
                        $end_of_sentence_flag = true;
                        $idx = $tmpidx;
                    }
                }

                //文の終端
                if ($end_of_sentence_flag) {
                    $len = mb_strlen($tmp_buffer);
                    if (mb_strlen($result_array[$result_idx]) + $len >= 4900) {
                        array_push($result_array, "");
                        $result_idx++;
                        $result_array[$result_idx] .= $tmp_buffer;
                        $tmp_buffer = "";
                    } else {
                        if ($ignore_enters_flag and $enter_count >= 2) {
                            for ($j = 0; $j < $enter_count; $j++) {
                                $tmp_buffer .= "\n";
                            }
                        } else if ($enter_if_period_flag) {
                            $tmp_buffer .= "\n";
                        } else {
                            $tmp_buffer .= " ";
                        }
                        $result_array[$result_idx] .= $tmp_buffer;
                        $tmp_buffer = "";
                    }
                }
                continue;
            }


            //英数字記号の変換
            if ($change_code_flag) {
                $current_chr = $this->to_normal($current_chr);
            }

            $tmp_buffer .= $current_chr;
            $idx++;
        }

        $len = mb_strlen($tmp_buffer);
        if (mb_strlen($result_array[$result_idx]) + $len >= 4900) {
            array_push($result_array, "");
            $result_idx++;
        }
        $result_array[$result_idx] .= $tmp_buffer;
        $tmp_buffer = "";


        //結果の配列を結合
        $result = "";
        foreach ($result_array as &$tmp) {
            $result .= $tmp;
        }
        if ($deepl_flag) {
            $url = array();
            if ($split_5000_flag) {
                //5000字以内で分割した文書のURLをそれぞれ生成
                foreach ($result_array as &$tmp) {
                    $tmp_url = "https://www.deepl.com/translator#en/ja/" . rawurlencode($tmp);
                    array_push($url, $tmp_url);
                }
            } else {
                $tmp_url = "https://www.deepl.com/translator#en/ja/" . rawurlencode($result);
                array_push($url, $tmp_url);
            }

            return view("mypages.to_normal", [
                "text" => $original_text,
                "result" => $result,
                "prev_function" => $function,
                "url" => $url
            ]);
        } else {
            return view("mypages.to_normal", [
                "text" => $original_text,
                "result" => $result,
                "prev_function" => $function,
                "url" => []
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
