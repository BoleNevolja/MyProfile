<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@if($followedUsers->count() == 0)
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Praćenja:') }}</div>
                    <div class="card-body center">
                        @foreach ($followedUsers as $followedUser)
                        <a href="user/{{$followedUser->id}}">                    
                        <img src="{{asset('images/' . $followedUser->image_path)}}" data-toggle="tooltip" data-placement="right" title="{{$followedUser->name}}" class="profile-image-bar"></a>       
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>

</div>
@endif
