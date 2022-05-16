<h2>変換前</h2>


<form method="POST" action="/change">
    @csrf
    <br>
    <textarea name="target" rows=20, cols="40" placeholder="変換前"></textarea>
    <br>
    <input type="submit" name="change" value="変換">
    <br>
</form>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <font color="#ff0000">{{$error}}</font><br>
    @endforeach
</div>
@endif