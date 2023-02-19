@extends('/master')

@section('content')

<div class="container">
    <div class="row mt-4">
        <div class=" col-5 bg-white">
            {{-- create message --}}
            @if(session('insertSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('insertSuccess')}}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif

            {{-- update message --}}
            @if(session('updateSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{session('updateSuccess')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            @endif

            {{-- validation message --}}

            {{--  --}}

            <div class="p-3">
                <form action="{{route('post#create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="text-group my-2">
                        <label for="" class="fw-semibold mb-2">Post Title</label>
                        <input type="text"  name="postTitle"class="form-control @error('postTitle') is-invalid

                        @enderror" value="{{old('postTitle')}}"placeholder="Enter Post Title..." >
                        @error('postTitle')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="text-group my-2">
                        <label for="" class="fw-semibold mb-2">Post Description</label>
                        <textarea name="postDescription" class="form-control @error('postDescription') is-invalid

                        @enderror" id="" placeholder="Enter Post Description"  cols="30" rows="10">{{old('postDescription')}}</textarea>
                        @error('postDescription')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                     </div>
                     {{-- Image --}}
                    <div class="image-container text-group mb-3 ">
                        <label for="image">Image</label>
                        <input type="file" name="postImage" class="form-control @error('postImage') is-invalid @enderror">
                        @error('postImage')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>

                      @enderror
                     </div>
                     {{-- Post fees --}}
                     <div class="fee-container text-group mb-3 ">
                        <label for="fee">Fee</label>
                        <input type="number" placeholder="Enter "  name="postFee" class="form-control @error('postFee') is-invalid @enderror">
                        @error('postFee')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                     </div>
                     {{-- address --}}
                     <div class="address-container text-group mb-3 ">
                        <label for="address">Address</label>
                        <input type="text"  name="postAddress" class="form-control @error('postAddress') is-invalid @enderror" placeholder="Enter Post Address">
                        @error('postAddress')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                     </div>
                     {{-- rating --}}
                     <div class="rating-container text-group mb-3 ">
                        <label for="rating">Rating</label>
                        <input type="number" name="postRating" placeholder="Enter Rating" min="0" max="5" class="form-control @error('postRating') is-invalid @enderror">
                        @error('postRating')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                     </div>

                    <input type="submit" value="Create" class="btn btn-danger text-white my-2">
                </form>
            </div>
        </div>
        <div class=" col-7">
            <h3 class="mb-3">
                <div class="row">
                    <div class="col-5">
                        Total-{{$posts->total()}}
                    </div>

                    <div class="col-5 offset-2 ">
                       <form action="{{route('post#createPage')}}" method="GET">
                        <div class="row">
                            <input type="text" name="searchKey" class="form-control col" value="{{request('searchKey')}}" placeholder="Enter search Key">
                            <button class="btn btn-danger col-2 " type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                       </form>
                    </div>
                </div>
            </h3>
            <div class="data-container">
                @if(count($posts) != 0)
                    @foreach ($posts as $item)
                    <div class="post p-3 shadow-sm mb-3">
                        <div class="row">
                            <h5 class="col-7">{{$item->title}}</h5>
                            <h5 class="col-4 offset-1">{{$item->created_at->format("j-F-Y")}}</h5>
                        </div>

                        <p class="text-muted">{{Str::words($item->description,30,'...')}}</p>

                        <span>
                            <small><i class="fa-solid fa-money-bill text-primary"></i> {{$item->price}} Kyats</small>
                        </span>
                        |
                        <span>
                            <i class="fa-solid fa-location-dot text-danger"></i> {{$item->address}}
                        </span>
                        |
                        <span>
                            {{$item->rating}}<i class="fa-solid fa-star text-warning"></i>
                        </span>


                        <div class="text-end">
                            <a href="{{url('post/delete'.$item->id)}}">
                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                            </a>
                            <a href="{{route('post#update',$item->id)}}">
                                <button class="btn btn-sm btn-primary"><i class="fa-regular fa-file-lines"></i> See More</button>
                            </a>
                        </div>
                    </div>
                @endforeach
                 @else
                    <h3 class="text-danger text-center mt-5">There is no data...</h3>
                @endif
            </div>
            {{$posts->appends(request()->query())->links()}}

        </div>
    </div>
</div>




@endsection
