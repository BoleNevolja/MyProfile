@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="/post/edited/{{$post->id}}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Naslov</label>
                        <input class="form-control" name="title" value="{{$post->title}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sadržaj</label>
                        <input class="form-control" name="content" value="{{$post->content}}"><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Gotovo</button>
                </form>
            </div>
        </div>
    </div>
@endsection