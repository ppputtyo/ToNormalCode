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


<style>
    .button {
        min-width: 150px;
        font-family: inherit;
        appearance: none;
        border: 0;
        border-radius: 5px;
        background: #4676d7;
        color: #fff;
        padding: 12px 20px;
        font-size: 1.1rem;
        cursor: pointer;
    }
</style>
<form method="POST" action="/to-normal-code">
    @csrf
    <br>
    <textarea name="target" rows=30, cols="70" placeholder="変換前">{{$text}}</textarea>
    <textarea name="result" rows=30, cols="70" placeholder="変換後">{{$result}}</textarea>
    <br>
    <input type="submit" name="change" value="変換" class="button">
    <input type="submit" name="translate" value="DeepLで翻訳" class="button">
</form>
副産物として普通の英数字を数学用英数字記号に変換するツールもできました。<br>
<a href="/to-special-code">英数字→数学用英数字記号変換ツール</a>
<br><br>
<a href="https://twitter.com/p_kyopro">作者Twitter</a>
<br>