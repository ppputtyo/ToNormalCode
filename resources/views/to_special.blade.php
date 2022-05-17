<h2>英数字→数学用英数字記号変換ツール</h2>
通常の英数字を数学用英数字記号に変換するツールです。<br>
Hello World → 𝓗𝓮𝓵𝓵𝓸 𝓦𝓸𝓻𝓵𝓭 みたいな変換が簡単にできます。(環境によってはうまく表示されない場合があるかもです。)<br>
<form method="POST" action="/to-special-code">
    @csrf
    {{Form::select('code', [
        "𝐀, 𝐚 [セリフ(Bold)]",
        "𝐴, 𝑎 [セリフ(Italic)]",
        "𝑨, 𝒂 [セリフ(Bold italic)]",
        "𝖠, 𝖺 [サンセリフ(Normal)]",
        "𝗔, 𝗮 [サンセリフ(Bold)]",
        "𝘈, 𝘢 [サンセリフ(Italic)]",
        "𝘼, 𝙖 [サンセリフ(Bold Italic)]",
        "𝒜, 𝒶 [筆記体(Normal)]",
        "𝓐, 𝓪 [筆記体(Bold)]",
        "𝔄, 𝔞 [フラクトゥール(Normal)]",
        "𝕬, 𝖆 [フラクトゥール(Bold)]",
        "𝙰, 𝚊 [等幅フォント(Normal)]",
        "𝔸, 𝕒 [黒板太字(Bold)]"
        ],
        ['selected' => $code])
    }}
    <br>
    <textarea name="target" rows=30, cols="60" placeholder="変換前">{{$text}}</textarea>
    <textarea name="result" rows=30, cols="60" placeholder="変換後">{{$result}}</textarea>
    <br>
    <input type="submit" name="change" value="変換">
    <br>
</form>

<a href="/to-normal-code">DeepL用英字論文フォーマッタ<a>