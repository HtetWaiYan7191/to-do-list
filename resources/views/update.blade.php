@extends('master')

@section('content')

<div class="container ">
    <div class="row mt-3" >
        <div class="col-6 offset-3 ">
            <div class="my-3">
                <a href="{{route('post#home')}}" class="text-decoration-none text-black ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>back
                </a>
            </div>
            <h3 class="col-7">{{$post['title']}}</h3>

               {{-- price ,address,rating--}}
                <div class="d-flex">
                    <div class="btn btn-sm bg-primary text-white   me-2 my-3"><i class="fa-solid fa-money-bill text-black"></i> {{$post['price']}} Kyats</div>
                    <div class="btn btn-sm bg-primary text-white   me-2 my-3"><i class="fa-solid fa-location-dot text-danger"></i> {{$post['address']}}</div>
                    <div class="btn btn-sm bg-primary text-white   me-2 my-3"><i class="fa-solid fa-star text-warning"></i> {{$post['rating']}}</div>
                    <div class="btn btn-sm bg-primary text-white me-2 my-3"><i class="fa-regular fa-calendar text-info"></i> {{$post['created_at']->format("j-F-Y")}}</div>
                    <div class="btn btn-sm bg-primary text-white me-2 my-3"><i class="fa-regular fa-clock text-info"></i>   {{$post->created_at->format("h:m:s:A   ")}}</div>


                </div>

                    {{-- image --}}

                        <div class="">
                            @if ($post['image'] == null)
                                <img src="{{asset('storage/imageNotFound.png')}}" class="img-thumbnail shadow-sm" alt="">

                            @else
                            <img src="{{asset('storage/'.$post['image'])}}" class="img-thumbnail shadow-sm" alt="">
                            @endif
                        </div>

            <p class=" text-muted">
                {{  $post['description']    }}
            </p>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-3 offset-8">
            <a href="{{route('post#edit',$post['id'])}}">
                <button class="btn bg-dark text-white">Edit</button>
            </a>
        </div>
    </div>
</div>



@endsection
