@extends('layouts.parent')

@section('css')
@endsection

@section('javascript-head')
    <script>
        window.addEventListener("load", init);

        function init() {
            const prefunc = @json($prev_function);

            //前のチェック状態を復元
            for (i = 0; i < 7; i++) {
                if (prefunc[i] == 1) {
                    document.form.elements[i + 1].checked = true;
                }
            }

            const urls = @json($url);
            if (urls.length == 0) {
                return;
            }

            let message = urls.length + "個のDeepLタブを表示します。";
            if (prefunc[6] == 1) {
                for (const url of urls) {
                    window.open(url);
                }
            } else if (confirm(message)) {
                for (const url of urls) {
                    window.open(url);
                }
            }
        }

        function allcheck(tf) {
            // 0: csrf
            for (i = 1; i <= 7; i++) {
                document.form.elements[i].checked = tf; // ON・OFFを切り替え
            }
        }

        function defaultcheck() {
            // 0: csrf
            default_tf = {
                1: true,
                2: true,
                3: true,
                4: false,
                5: false,
                6: true,
                7: false
            }
            for (i = 1; i <= 7; i++) {
                document.form.elements[i].checked =
                    default_tf[i]; // ON・OFFを切り替え
            }
        }

        function clear_textarea() {
            let textareas = document.getElementsByTagName("textarea")
            for (const ta of textareas) {
                ta.value = "";
            }
        }
    </script>
@endsection

@section('title')
    <title>英字論文フォーマッタ</title>
@endsection

@section('meta')
    <meta name="google-site-verification" content="fTXRHHLMbPc_Jomx6uKpCe4pzc7cMqb76otQ2Wwk2Fs" />
@endsection

@section('content')
    <header class="header">
        <a href="/"><img src="/images/logo.png" class="icon"></a>
        <hr size="2" color=#646464>
    </header>
    <div class="main">
        改行やハイフネーション、特殊記号などの問題からDeepLで正しく翻訳できない英字論文を正しく翻訳できるようにフォーマットするツールです。
        <br>
        5000文字以上の長い文章を自動で分割して翻訳する機能もあります。
        <h3>
            <font color="#ff4500">※ブラウザのポップアップ機能のブロックを解除しないと「DeepLで翻訳」機能が使えません。</font>
        </h3>
        <p>
            <input type="button" value="全選択" onclick="allcheck(true);" class="all_select_button">
            <input type="button" value="全解除" onclick="allcheck(false);" class="all_unselect_button">
            <input type="button" value="デフォルト" onclick="defaultcheck();" class="to_default_button">
        </p>
        <form method="POST" name="form" action="/to-normal-code">
            @csrf
            <label for="cb0">
                <input type="checkbox" name="function[0]" value="1" id="cb0">
                数学用英数字記号→普通の英数字 (例: 𝔸→A)
            </label>
            <br>
            <label for="cb1">
                <input type="checkbox" name="function[1]" value="1" id="cb1">
                改行→半角スペース
                <br>
            </label>
            <label for="cb2">
                <input type="checkbox" name="function[2]" value="1" id="cb2">
                改行で分割された単語の復元 (例:imple-[改行]ment→implement)
            </label>
            <br>
            <label for="cb3">
                <input type="checkbox" name="function[3]" value="1" id="cb3">
                2つ以上連続する改行は無視する
            </label>
            <br>
            <label for="cb4">
                <input type="checkbox" name="function[4]" value="1" id="cb4">
                文末で改行する
            </label>
            <br>
            <label for="cb5">
                <input type="checkbox" name="function[5]" value="1" id="cb5">
                5000文字を超えた場合に分割してDeepLで翻訳する
            </label>
            <br>
            <label for="cb6">
                <input type="checkbox" name="function[6]" value="1" id="cb6">
                DeepLで翻訳時に新規タブを開くことを確認しない<font color="#ff4500">(※翻訳後にリロードを行うと確認無しでタブが開きます)</font>
            </label>
            <br>
            <textarea name="target" placeholder="変換前" maxlength="300000">{{ $text }}</textarea>
            <textarea name="result" placeholder="変換後" readonly>{{ $result }}</textarea>
            <br>
            <p>
                <input type="submit" name="change" value="変換" class="normal_button">
                <input type="submit" name="translate" value="DeepLで翻訳" class="normal_button">
                <input type="button" value="リセット" onclick="clear_textarea();" class="alert_button">
            </p>
        </form>
        <h3>更新情報</h3>
        <ul>
            <li><b>2022/11/02</b> Heroku有料化に伴いRender.comへ移行</li>
            <li><b>2022/06/20</b> 変換されない特殊文字が存在するバグの修正</li>
            <li><b>2022/06/11</b> 5000文字を超えた場合に分割してDeepLで翻訳する機能の追加</li>
        </ul>
        <br>
        欲しい機能、バグ報告、質問等あれば<a href="https://github.com/ppputtyo/ToNormalCode">GitHub</a>のissueまでよろしくお願いします。<br>
        <br>
        副産物として普通の英数字を数学用英数字記号に変換するツールもできました。<br>
        <a href="/to-special-code">英数字→数学用英数字記号変換ツール</a>
    </div>
@endsection
