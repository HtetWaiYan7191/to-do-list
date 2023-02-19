@extends('master')

@section('content')

<div class="container ">
    <div class="row mt-3" >
        <div class="col-6 offset-3 ">
            <div class="my-3">
                <a href="{{route('post#update',$post['id'])}}" class="text-decoration-none text-black ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>back
                </a>
            </div>

            {{-- <h3>{{$post[0]['title']}}</h3>
            <p class=" text-muted">
                {{  $post[0]['description']    }}
            </p> --}}

            <form action="{{route('post#edit#done')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="" class="my-3" >Post Title</label>
                <input type="hidden" name="postId" value="{{$post['id']}}">
                <input type="text" name="postTitle" class="form-control mb-3 @error('postTitle') is-invalid

                @enderror" value="{{old('$postTitle',$post['title'])}}" placeholder="Enter post Title" >
                @error('postTitle')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                @enderror

                {{-- image --}}

                <label for="">Image</label>
                <div class="">
                    @if ($post['image']==null)
                        <img src="{{asset('storage/imageNotFound.png')}}"  class="img-thumbnail my-4 shadow-sm" alt="">
                    @else
                        <img src="{{asset('storage/'.$post['image'])}}" class="img-thumbnail my-4 shadow-sm" alt="">
                    @endif
                </div>
                <input type="file" name="postImage" class="form-control my-3 @error('postImage') is-invalid

                @enderror" value="{{old('postImage',$post['image'])}}">
            @error('postImage')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror

                 {{-- post description --}}
                <label for="" class="  my-3 ">Post Description</label>
                <textarea name="postDescription"  class="form-control @error('postDescription')

                @enderror " id="" cols="30" rows="10" placeholder="" >
                    {{old('$postDescription',$post['description'])}}
                </textarea>

                @error('postDescription')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                 @enderror



                <label for="" class="my-3">Post Fee</label>
                <input type="text" name="postFee" class="form-control " value="{{old('postFee',$post['price'])}}" placeholder="">

                <label for="" class="my-3">Post Address</label>
                <input type="text" name="postAddress" class="form-control " value="{{old('postAddress',$post['address'])}}" placeholder="">

                <label for="" class="my-3">Post Rating</label>
                <input type="text" name="postRating" class="form-control " value="{{old('postRating',$post['rating'])}}" placeholder="">

                {{-- submit button --}}
                <input type="submit" value="Update" class="btn bg-dark text-light float-end my-3">
            </form>
        </div>
    </div>


    {{-- Edit button --}}
    {{-- <div class="row my-3">
        <div class="col-3 offset-8">
            <a href="{{route('post#edit',$post['id'])}}">
                <button class="btn bg-dark text-white">Edit</button>
            </a>
        </div>
    </div> --}}
</div>



@endsection
