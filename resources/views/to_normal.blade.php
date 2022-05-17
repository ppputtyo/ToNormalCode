<h2>英字論文フォーマッタ</h2>
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

<form method="POST" action="/to-normal-code" target="_blank">
    @csrf
    <br>
    <textarea name="target" rows=30, cols="70" placeholder="変換前">{{$text}}</textarea>
    <textarea name="result" rows=30, cols="70" placeholder="変換後">{{$result}}</textarea>
    <br>
    <input type="submit" name="change" value="変換">
    <br>
    <input type="submit" name="translate" value="DeepLで翻訳">
</form>
副産物として普通の英数字を数学用英数字記号に変換するツールもできました。<br>
<a href="/to-special-code">英数字→数学用英数字記号変換ツール</a>
<br><br>
<a href="https://twitter.com/p_kyopro">作者Twitter</a>
<br>