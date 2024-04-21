@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="/user/{{$user->id}}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ime</label>
                        <input class="form-control" name="name" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Opis</label>
                        <input class="form-control" name="bio" value="{{$user->bio}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Profilna slika</label>
                        <input class="form-control" name="image" type="file">
                        <p style="color:red"> Preporučuje se slika kvadratnog oblika</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Gotovo</button>
                </form>
            </div>
        </div>
    </div>
@endsection