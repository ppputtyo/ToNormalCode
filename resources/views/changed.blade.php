<h2>変換後</h2>


<form method="POST" action="/change">
    @csrf
    <br>
    <textarea name="contents" rows=20, cols="40">{{$result}}</textarea>
    <br>
</form>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <font color="#ff0000">{{$error}}</font><br>
    @endforeach
</div>
@endif