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

@section('title')
    <title>数学用英数字記号変換ツール</title>
    <header class="header">
        <h2>英数字→数学用英数字記号変換ツール</h2>
    </header>
@endsection


@section('content')
    <div class="main">
        <br>
        通常の英数字を数学用英数字記号に変換するツールです。<br>
        Hello World → 𝓗𝓮𝓵𝓵𝓸 𝓦𝓸𝓻𝓵𝓭 みたいな変換が簡単にできます。(環境によってはうまく表示されない場合があるかもです。)<br><br>
        <form method="POST" action="/to-special-code">
            @csrf
            {{ Form::select(
                'code',
                [
                    '𝐀, 𝐚 [セリフ(Bold)]',
                    '𝐴, 𝑎 [セリフ(Italic)]',
                    '𝑨, 𝒂 [セリフ(Bold italic)]',
                    '𝖠, 𝖺 [サンセリフ(Normal)]',
                    '𝗔, 𝗮 [サンセリフ(Bold)]',
                    '𝘈, 𝘢 [サンセリフ(Italic)]',
                    '𝘼, 𝙖 [サンセリフ(Bold Italic)]',
                    '𝒜, 𝒶 [筆記体(Normal)]',
                    '𝓐, 𝓪 [筆記体(Bold)]',
                    '𝔄, 𝔞 [フラクトゥール(Normal)]',
                    '𝕬, 𝖆 [フラクトゥール(Bold)]',
                    '𝙰, 𝚊 [等幅フォント(Normal)]',
                    '𝔸, 𝕒 [黒板太字(Bold)]',
                ],
                ['selected' => $code],
            ) }}
            <br>
            <textarea name="target" rows=30, cols="60" placeholder="変換前" class="textarea">{{ $text }}</textarea>
            <textarea name="result" rows=30, cols="60" placeholder="変換後" readonly class="textarea">{{ $result }}</textarea>
            <br>
            <input type="submit" name="change" value="変換" class="normal_button">
            <br>
        </form>

        <br>
        <a href="/to-normal-code">英字論文フォーマッタ</a>
        <br><br>
        欲しい機能、バグ報告、質問等あれば<a href="https://github.com/ppputtyo/ToNormalCode">GitHub</a>のisuueまでよろしくお願いします。<br>
    </div>
@endsection
