@extends('layouts.parent')

@section('css')
@endsection

@section('javascript-head')
    <script>
        function clear_textarea() {
            let textareas = document.getElementsByTagName("textarea")
            console.log(textareas);
            for (const ta of textareas) {
                ta.value = "";
            }
        }
    </script>
@endsection

@section('title')
    <title>数学用英数字記号変換ツール</title>
@endsection


@section('content')
    <header class="header">
        <a href="/to-special-code"><img src="/images/logo_to_special.png" class="icon"></a>
        <hr size="2" color=#646464>
    </header>
    <div class="main">
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
            <textarea name="target" placeholder="変換前" maxlength="300000">{{ $text }}</textarea>
            <textarea name="result" placeholder="変換後" readonly>{{ $result }}</textarea>
            <br>
            <input type="submit" name="change" value="変換" class="normal_button">
            <input type="button" value="リセット" onclick="clear_textarea();" class="alert_button">
        </form>

        <br>
        <a href="/to-normal-code">英字論文フォーマッタ</a>
        <br><br>
        欲しい機能、バグ報告、質問等あれば<a href="https://github.com/ppputtyo/ToNormalCode">GitHub</a>のisuueまでよろしくお願いします。<br>
    </div>
@endsection
