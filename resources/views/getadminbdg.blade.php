<head>
    <title>GET ADMIN BADGE</title>
</head>
<body>
    <form method="POST" action="/admin-bdg/{{Auth::user()->id}}">
    @csrf
    {{ method_field('PUT') }}
    <div class="form-group">
        <input class="form-control" name="submit" placeholder="**************"><br>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>