<h2>英数字→数学用英数字記号変換ツール</h2>

<form method="POST" action="/to-special-code">
    @csrf
    {{Form::select('age', [
        "𝐀, 𝐚",
        "𝐴, 𝑎",
        "𝑨, 𝒂",
        "𝖠, 𝖺",
        "𝗔, 𝗮",
        "𝘈, 𝘢",
        "𝘼, 𝙖",
        "𝒜, 𝒶",
        "𝓐, 𝓪",
        "𝔄, 𝔞",
        "𝕬, 𝖆",
        "𝙰, 𝚊",
        "𝔸, 𝕒"
        ])
    }}
    <br>
    <textarea name="target" rows=30, cols="60" placeholder="変換前">{{$text}}</textarea>
    <textarea name="result" rows=30, cols="60" placeholder="変換後">{{$result}}</textarea>
    <br>
    <input type="submit" name="change" value="変換">
    <br>
</form>