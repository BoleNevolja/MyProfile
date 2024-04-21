@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">BROJ KORISNIKA: <b>{{$TotalUsers}}</b><br>
                                         BROJ NOVIH KORISNIKA U ZADNJIH 24h: <b>{{$NewUsers}}</b></div>
                <div class="card-body">
@foreach($users as $user)
<div class="card cardic">
  <div class="card-header">
 {{$user->created_at->diffForHumans()}}
  </div>
  <div class="card-body">
  <img src="{{asset('images/' . $user->image_path)}}" class="profile-image-home">
  <a href="/user/{{$user->id}}"><h3 class="card-title"> <b> {{ $user->name }}</b></a>@if($user->owner == "yes")<i class="ri-verified-badge-fill owner-badge"></i>@elseif($user->role == "admin") <i class="ri-verified-badge-fill admin"></i>@endif</h3>
   <p> {{$user->bio}}</p>
   
  </div>
  <div class="card-footer">
    @if($user->owner == "yes")
    VLASNIK
    @else
  <a href="{{ url('/user/' . $user->id . '/edit') }}"><button class="btn btn-primary buttones">Uredi profil</button></a>
   @if($user->role != "admin" && Auth::user()->owner == "yes")
                              <form method="POST" action="{{ url('/addadmin/' . $user->id) }}">
                                  {{ method_field('PUT') }}
                                  @csrf
                                  <button type="submit" class="btn btn-success buttones">Dodaj admina <i
                                          class="ri-admin-fill"></i></button>
                                  </form>
  @elseif($user->role == "admin" && Auth::user()->owner == "yes")
                              <form method="POST" action="{{ url('/removeadmin/' . $user->id) }}">
                                  {{ method_field('PUT') }}
                                  @csrf
                                  <button type="submit" class="btn btn-danger buttones">Ukloni admina <i
                                          class="ri-user-unfollow-fill"></i></button>
                              </form>
                              @endif
                              @endif
  </div>
</div>
@endforeach
                </div>
            </div>
        </div>
    </div>
    @endsection