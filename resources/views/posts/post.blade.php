@extends('layouts.app')
<title>MyProfile ┃ {{$post->title}}</title>
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <div class="card">
                    <div class="card-header">
                        {{ $post->created_at->format('d.m.Y')}} ┃ {{$post->user->name}}
                        @if(Auth::user()->likes($post)->exists())
                        ┃ LAJKOVANO
                        @endif 
                    </div>
                    <div class="card-body">
                        <h1 class="card-title"><b> {{ $post->title }}</b>
                            @if ($post->verified == 'yes')
                                <i class="ri-verified-badge-line verified"></i>
                            @endif
                        </h1>
                        <p class="bio">{{ $post->content }}</p>
                        @if($post->image_path != null)
                        <img src="{{ asset('data/' . $post->image_path) }}" style="max-width:100%">
                        @endif
                        @if(Auth::user()->id != $post->user->id)
        @if(!Auth::user()->likes($post)->exists())
            <button class="btn btn-primary like-btn" id="likeb" onclick="like({{$post->id}})" action="submit"><i class="ri-heart-fill"></i> : <span id="n-1">{{$post->likes()->count()}}</span></button>
            <button class="d-none btn btn-danger like-btn" onclick="unlike({{$post->id}})" id="unlikeb" action="submit"><i class="ri-dislike-fill"></i> :  <span id="n-2">{{$post->likes()->count()}}</span></button>
        @elseif(Auth::user()->likes($post)->exists())
            <button id="unlikeb" class="btn btn-danger like-btn" onclick="unlike({{$post->id}})" action="submit"><i class="ri-dislike-fill"></i> :  <span id="n-1">{{$post->likes()->count()}}</span></button>
            <button id="likeb" class="d-none btn btn-primary like-btn" onclick="like({{$post->id}})" action="submit"><i class="ri-heart-fill"></i> :  <span id="n-2">{{$post->likes()->count()}}</span></button>
        @endif
        @else
        <a href="/likes/{{$post->id}}"><h5>Lajkova : {{$post->likes()->count()}}</h5></a>
        @endif
                        </div>
                        @if (Auth::user()->id == $post->user->id || Auth::user()->role == 'admin')
                        <div class="card-footer">
                            <form style="float:left; margin-right:10px"method="POST"
                                action="{{ url('/post/delete/' . $post->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Obriši <i
                                        class="ri-delete-bin-6-fill"></i></button>
                            </form>
                            <a href="{{ url('/post/' . $post->id) . '/edit' }}">
                                <button type="submit" style="float:left; margin-right:10px"
                                    class="btn btn-primary">Uredi <i
                                        class="ri-edit-2-fill"></i></button></a>
                    @endif


                    @if (Auth::user()->role == 'admin' && $post->verified == 'no')
                        <form method="POST" action="{{ url('/post/verify/' . $post->id) }}">
                            {{ method_field('PUT') }}
                            @csrf
                            <button type="submit" class="btn btn-success">Verifikuj <i
                                    class="ri-verified-badge-fill"></i></button>
                        </form>
                    @elseif(Auth::user()->role == 'admin' && $post->verified == 'yes' && $post->user->owner != 'yes')
                        <form method="POST" action="{{ url('/post/unverify/' . $post->id) }}">
                            {{ method_field('PUT') }}
                            @csrf
                            <button type="submit" class="btn btn-danger">Odverifikuj <i
                                    class="ri-close-line"></i></button>
                        </form>
                    @endif
                </div>
                </div>
            </div>
        </div>
        <br>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">


                        <div class="card">
                            <div class="card-header">
                                Dodaj komentar:
                            </div>
                            <div class="card-body">
                                <form action="/post/{{$post->id}}/comment" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" style="width:95%; float:left; height:35px" class="form-control" id="content" name="content"
                                            placeholder="Komentar...">
                                    </div>
                                    <button type="submit" class="btn btn-primary search-button"><i class="ri-chat-new-fill"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Komentari:') }}</div>
                        <div class="card-body">
                            @if($comments->isEmpty())
                            <h4 class="no-post"><i>NEMA KOMENTARA</i></h4>
                            @endif
                            @foreach ($comments as $comment)
                                <div class="card">
                                    <div class="card-header">
                                        Objavljeno {{ $comment->created_at->format('d.m.Y') }} u {{ $comment->created_at->format('H:i') }}
                                        ({{ $comment->created_at->diffForHumans() }})
                                    </div>
                                    <div class="card-body">
                                        <img src="{{asset('images/' . $comment->user->image_path)}}" class="profile-image-home">
                                        <a href="{{ url('/user/' . $comment->user_id) }}"><h4><b>{{$comment->user->name}}</b></a>@if($comment->user->owner == "yes")<i class="ri-verified-badge-fill owner-badge"></i>@elseif($comment->user->role == "admin") <i class="ri-verified-badge-fill admin"></i>@endif</h4>
                                        <p style="font-size:14px"> {{ $comment->content }}</p>
                                    </div>
                                    @if(Auth::user()->role == "admin" or Auth::user()->id == $comment->user->id)
                                    <div class="card-footer">
                                        
                                            <form style="float:left; margin-right:10px"method="POST"
                                                action="{{ url('/comment/delete/' . $comment->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">Obriši <i
                                                        class="ri-delete-bin-6-fill"></i></button>
                                            </form>
                                            <a href="{{ url('/comment/' . $comment->id) . '/edit' }}">
                                                <button type="submit" style="float:left; margin-right:10px"
                                                    class="btn btn-primary">Uredi <i
                                                        class="ri-edit-2-fill"></i></button></a>
                                    </div>
                                    @endif
                        </div>
                        @endforeach
                    @endsection