@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Korisnici koji Vas prate:') }}</div>
                <div class="card-body">
                    @if($users->isEmpty())
                         <h4 class="no-post"><i>NEMA PRONAĐENIH KORISNIKA</i></h4>
                    @endif
@foreach($users as $user)
<div class="card">
  <div class="card-header">
  Pridružio se {{ $user->created_at-> format("d.m.Y") }}
  @if(Auth::user()->follows($user))
  - PRATIM
  @endif
  </div>
  <div class="card-body">
  <img src="{{asset('images/' . $user->image_path)}}" class="profile-image-home">
  <a href="/user/{{$user->id}}"><h3 class="card-title"> <b> {{ $user->name }}</b></a>@if($user->owner == "yes")<i class="ri-verified-badge-fill owner-badge"></i>@elseif($user->role == "admin") <i class="ri-verified-badge-fill admin"></i>@endif</h3>
   <p> {{$user->bio}}</p>
   </div>
</div>
@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection