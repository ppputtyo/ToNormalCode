@extends('layouts.parent')

@section('css')
    <style>
        .normal_button {
            min-width: 12%;
            font-family: inherit;
            appearance: none;
            border: 0;
            border-radius: 5px;
            background: hsl(221, 67%, 55%);
            color: #fff;
            padding: 1% 2%;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .alert_button {
            min-width: 12%;
            font-family: inherit;
            appearance: none;
            border: 0;
            border-radius: 5px;
            background: hsl(0, 67%, 55%);
            color: #fff;
            padding: 1% 2%;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .all_select_button {
            min-width: 3%;
            font-family: inherit;
            appearance: none;
            border: 1px solid hsl(121, 49%, 46%);
            border-radius: 5px;
            background: hsl(121, 49%, 46%);
            color: #ffffff;
            padding: 5px 5px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .all_unselect_button {
            min-width: 3%;
            font-family: inherit;
            appearance: none;
            border: 1px solid #333333;
            border-radius: 5px;
            background: #fff;
            color: #333333;
            padding: 5px 5px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .to_default_button {
            min-width: 3%;
            font-family: inherit;
            border: 1px solid #333333;
            appearance: none;
            border-radius: 5px;
            background: #333333;
            color: #fff;
            padding: 5px 5px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .main {
            margin-left: 15%;
            margin-right: 15%;
            text-align: left;
            background-color: #ffffff;
            height: 100%;
        }

        .header {
            position: relative;
            background-color: #333333;
            color: #fff;
            padding: 2px 3%;
        }

        .textarea {
            resize: none;
            width: max(40%, 250px);
            height: 40vh;
        }
    </style>
@endsection

@section('javascript-head')
    <script>
        function allcheck(tf) {
            for (i = 1; i <= 6; i++) {
                document.form.elements[i].checked = tf; // ON・OFFを切り替え
            }
        }

        window.addEventListener("load", execFunction);

        function execFunction() {
            var urls = @json($url);
            if (urls.length == 0) {
                return;
            }
            let message = urls.length + "個のDeepLタブを表示します。"
            if (confirm(message)) {
                for (const url of urls) {
                    window.open(url);
                }
            }
        }

        function defaultcheck() {
            default_tf = {
                1: true,
                2: true,
                3: true,
                4: false,
                5: false,
                6: true
            }
            for (i = 1; i <= 6; i++) {
                document.form.elements[i].checked =
                    default_tf[i]; // ON・OFFを切り替え
            }
        }
    </script>
@endsection

@section('title')
    <title>英字論文フォーマッタ</title>
@endsection

@section('meta')
    <meta name="google-site-verification" content="q2WA-fehscnQ8J7Xl-2TPgHH-276MnD349Mrcc9exZU" />
@endsection

@section('content')
    <header class="header">
        <h2>英字論文フォーマッタ</h2>
    </header>
    <div class="main">
        <br>
        英字論文を DeepL で正しく翻訳されるようにフォーマットするツールです。
        <br>
        <h3>
            <font color="#ff4500">(注) ブラウザのポップアップ機能のブロックを解除しないと「DeepLで翻訳」機能が使えません。</font>
        </h3>
        <br>
        <p>
            <input type="button" value="全選択" onclick="allcheck(true);" class="all_select_button">
            <input type="button" value="全解除" onclick="allcheck(false);" class="all_unselect_button">
            <input type="button" value="デフォルト" onclick="defaultcheck();" class="to_default_button">
        </p>
        <form method="POST" name="form" action="/to-normal-code">
            @csrf
            <input type="checkbox" name="function[0]" value="1" @if (is_array($prev_function) and array_key_exists('0', $prev_function) and $prev_function['0'] == 1) checked="" @endif>
            数学用英数字記号→普通の英数字 (例: 𝔸→A)
            <br>
            <input type="checkbox" name="function[1]" value="1" @if (is_array($prev_function) and array_key_exists('1', $prev_function) and $prev_function['1'] == 1) checked="" @endif>
            改行→半角スペース
            <br>
            <input type="checkbox" name="function[2]" value="1" @if (is_array($prev_function) and array_key_exists('2', $prev_function) and $prev_function['2'] == 1) checked="" @endif>
            改行で分割された単語の復元 (例:imple-[改行]ment→implement)
            <br>
            <input type="checkbox" name="function[3]" value="1" @if (is_array($prev_function) and array_key_exists('3', $prev_function) and $prev_function['3'] == 1) checked="" @endif>
            2つ以上連続する改行は無視する
            <br>
            <input type="checkbox" name="function[4]" value="1" @if (is_array($prev_function) and array_key_exists('4', $prev_function) and $prev_function['4'] == 1) checked="" @endif>
            文末で改行する
            <br>
            <input type="checkbox" name="function[5]" value="1" @if (is_array($prev_function) and array_key_exists('5', $prev_function) and $prev_function['5'] == 1) checked="" @endif>
            5000文字を超えた場合に分割してDeepLで翻訳する
            <br>

            <textarea name="target" placeholder="変換前" class="textarea" maxlength="300000">{{ $text }}</textarea>
            <textarea name="result" placeholder="変換後" readonly class="textarea">{{ $result }}</textarea>
            <br>

            <p>
                <input type="submit" name="change" value="変換" class="normal_button">
                <input type="submit" name="translate" value="DeepLで翻訳" class="normal_button">
                <input type="submit" name="reset" value="リセット" class="alert_button">
            </p>
        </form>
        <br>
        副産物として普通の英数字を数学用英数字記号に変換するツールもできました。<br>
        <a href="/to-special-code">英数字→数学用英数字記号変換ツール</a>
        <br><br>
        欲しい機能、バグ報告、質問等あれば<a href="https://github.com/ppputtyo/ToNormalCode">GitHub</a>のisuueまでよろしくお願いします。<br>

    </div>
@endsection
