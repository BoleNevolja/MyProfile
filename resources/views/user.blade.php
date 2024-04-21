@extends('layouts.app')
<title>MyProfile ┃ {{$users->name}}</title>
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <div class="card">
                    <div class="card-header">
                        Pridružio se {{ $users->created_at->diffForHumans() }}
                        @if(Auth::user()->follows($users))
                          - PRATIM
                        @endif
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('images/' . $users->image_path) }}" class="profile-image">
                        <h1 class="card-title"><b> {{ $users->name }}</b>
                            @if ($users->owner == 'yes')
                                <i class="ri-verified-badge-fill owner-badge"></i>
                            @elseif($users->role == 'admin')
                                <i class="ri-verified-badge-fill admin"></i>
                            @endif
                        </h1>
                        <p class="bio">{{ $users->bio }}</p>
                        @if(Auth::user()->id == $users->id)
                        <a href="/followers/{{ $users->id }}"><h5>Pratilaca: <span id="count">{{ $users->followers()->count() }}</span></a></h5>
                        @else
                          <h5>Pratilaca: <span id="count">{{ $users->followers()->count() }}</span></h5>
                        @endif
                        
                    </div>
                    <div class="card-footer button-container">
                      @if(Auth::user()->follows($users))
                          <button id="ufb" type="submit" onclick="unfollow({{$users->id}})" class="btn btn-danger buttones">Odprati <i class="ri-user-unfollow-fill"></i></action>
                          <button id="fb" type="submit" onclick="follow({{$users->id}})" class="d-none btn btn-primary buttones">Zaprati <i class="ri-user-follow-fill"></i></action>
                        @elseif(Auth::user()->id != $users->id)
                          <button id="fb" type="submit" onclick="follow({{$users->id}})" class="btn btn-primary buttones">Zaprati <i class="ri-user-follow-fill"></i></action>
                          <button id="ufb" type="submit" onclick="unfollow({{$users->id}})" class="d-none btn btn-danger buttones">Odprati <i class="ri-user-unfollow-fill"></i></action>
                        @endif
                        @if (Auth::user() && Auth::user()->id === $users->id or Auth::user()->role == "admin")
                            <a href="{{ url('/user/' . $users->id . '/edit') }}"><button class="btn btn-primary">Uredi profil</button></a>
                        @endif
                        @if (Auth::user()->owner == 'yes' && $users->role != 'admin')
                            <form method="POST" action="{{ url('/addadmin/' . $users->id) }}">
                                {{ method_field('PUT') }}
                                @csrf
                                <button type="submit" class="btn btn-success buttones">Dodaj admina <i
                                        class="ri-admin-fill"></i></button>
                            </form>
                        @elseif(Auth::user()->owner == 'yes' && $users->owner != 'yes' && $users->role == 'admin')
                            <form method="POST" action="{{ url('/removeadmin/' . $users->id) }}">
                                {{ method_field('PUT') }}
                                @csrf
                                <button type="submit" class="btn btn-danger buttones">Ukloni admina <i
                                        class="ri-user-unfollow-fill"></i></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        @if (Auth::user()->id == $users->id)
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">


                        <div class="card">
                            <div class="card-header">
                                Dodaj objavu:
                            </div>
                            <div class="card-body">
                                <form action="/post" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Naslov</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Naslov..." required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Sadržaj</label>
                                        <input type="text" class="form-control" id="content" name="content"
                                            placeholder="Sadržaj...">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Naslov</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Objavi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
        @endif



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Objave:') }}</div>
                        <div class="card-body">
                            @if($posts->isEmpty())
                            <h4 class="no-post"><i>NEMA OBJAVA</i></h4>
                            @endif
                            @foreach ($posts as $post)
                               @include("posts.post-card")
                        @endforeach
                    @endsection
