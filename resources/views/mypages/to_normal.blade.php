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

        .body {
            text-align: center;
            background-color: #333333;
            margin: 0px;
            padding: 0px;
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

@endsection

@section('title', '英字論文フォーマッタ')


@section('content')

    <head>
        <header class="header">
            <h2>英字論文フォーマッタ</h2>
        </header>
    </head>
    <div class="main">

        <body>
            <br>
            英字論文を DeepL で正しく翻訳されるようにフォーマットするツールです。
            <br>
            現在機能は以下の通り。
            <ul>
                <li>数学用英数字記号→普通の英数字 (例: 𝔸→A)</li>
                <li>/n(改行)→半角スペース</li>
                <li>-/nの削除 (例: imple-/nment→implement)</li>
                <li>ワンクリックでフォーマットしたものを DeepL で翻訳</li>
            </ul>
            <br>
            <form method="POST" action="/to-normal-code">
                @csrf
                <textarea name="target" placeholder="変換前" class="textarea">{{ $text }}</textarea>
                <textarea name="result" placeholder="変換後" readonly class="textarea">{{ $result }}</textarea>
                <br>
                <input type="submit" name="change" value="変換" class="normal_button">
                <input type="submit" name="translate" value="DeepLで翻訳" class="normal_button">
                <input type="submit" name="reset" value="リセット" class="alert_button">
            </form>
            <br>
            副産物として普通の英数字を数学用英数字記号に変換するツールもできました。<br>
            <a href="/to-special-code">英数字→数学用英数字記号変換ツール</a>
            {{-- <br><br>
            <a href="https://twitter.com/p_kyopro">作者Twitter</a>
            <br> --}}
        </body>
    </div>
@endsection
