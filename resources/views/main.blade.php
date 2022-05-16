<h2>数学用英数字記号→英数字変換ツール</h2>

<form method="POST" action="/">
    @csrf
    <br>
    <textarea name="target" rows=30, cols="60" placeholder="変換前">{{$text}}</textarea>
    <textarea name="result" rows=30, cols="60" placeholder="変換後">{{$result}}</textarea>
    <br>
    <input type="submit" name="change" value="変換">
    <br>
</form>