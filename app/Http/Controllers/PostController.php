<?php

namespace App\Http\Controllers;
use Storage;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //post create function
    public function create(){
        $posts = Post::when(request('searchKey'),function($query){
            $key = request('searchKey');
            $query->where('title','like','%'.$key.'%')
                   ->orwhere('description','like','%'.$key.'%') ;
        })
        ->orderBy('created_at','desc')
        ->paginate(2);
        // $posts = Post::orderBy('created_at','desc')->paginate(3);
        // $posts = Post::orderBy('created_at','desc')->paginate(3);//can also use get()

        // dd($posts[0]['title']);
        //testing collection
        // $posts = Post::where('address','Yangon')->get()->random();

        //where == && orWhere==||

        // $posts = Post::where('id','<',40)->orwhere('address','Yangon')->get();
        // $posts = Post::select('id','address','price')->
        // where('address','Yangon')->
        // whereBetween('price',[1000,9000])->
        // orderBy('price','asc')->get();

        // $posts = Post::select('rating',DB::raw('COUNT(rating) as count_rating'),DB::raw('sum(price) as total_price'))
        // ->groupBy('rating')
        // ->get()
        // ->toArray();

        // dd($posts);

        // dd($posts[0]);

        // map each through***
        // map each -> data
        //through -> paginate-> pagination + data

        // $posts = Post::get()->map(function($p){
        //     $p->title = strtoupper($p->title);
        //     $p->description = strtoupper($p->description);
        //     $p->price = $p->price * 2 ;

        //     return $p;

        // });

        // dd($posts->toArray());

        // dd($_REQUEST['key']);

        // $searchKey = $_REQUEST['key'];
        // $posts = Post::where('title','like','%'.$searchKey.'%')->get()->toArray();
        // dd($posts);

        // $post = Post::when(request('key'),function($p){
        //     $searchKey = $_REQUEST['key'];
        //     $p->where('title','like','%'.$searchKey.'%');
        // })
        // ->get();
        // dd($post->toArray());

        return view('create',compact('posts'));
    }

    //postCreate
    public function postCreate(Request $request){
            // $data = [
            //     'title' => $request->postTitle,
            //     'description' => $request->postDescription
            // ];
            // dd($data);

            // dd($request->hasFile('postImage') ? 'yes':'no');
            $this->postValidationCheck($request);
            $data =  $this->getPostData($request);

            if($request->hasFile('postImage')){
                $fileName =uniqid(). $request->file('postImage')->getClientOriginalName();
                $request->file('postImage')->storeAs('public',$fileName);
                $data['image'] = $fileName;

            }

           Post::create($data);
        return redirect()->route('post#home')->with(['insertSuccess'=>'post created success']);
        //return redirect('testing');//url
        //return redirect()->route('test');//name
    }

    //Delete post function by get method
    public function postDelete($id){
        //first way
        // Post::where('id',$id)->delete();
        // return redirect()->route('post#home');

        //second way
        $post = Post::find($id)->delete();
        return back();


    }

    //post update function

    public function postUpdate($id){
        $post = Post::where('id',$id)->first();
        return view('update',compact('post'));
    }

    //post edit function
    public function postEdit($id){
        $post = Post::where('id',$id)->first()->toArray();
        return view('edit',compact('post'));
    }


    //post edit done function
    public function posteditDone(Request $request){


            $this->postValidationCheck($request);
            $data = $this->getPostData($request);
            $updateData = $this->getUpdateData($request);//array format
            $id = $request->postId;
            if($request->hasFile('postImage')){

                //delete old image
                $oldImageName = Post::select('image')->where('id',$request->postId)->first()->toArray();
                $oldImageName = $oldImageName['image'];
                if($oldImageName != null){
                    Storage::delete('public/'.$oldImageName);
                }


                //add new image
                $fileName = uniqid().'_'.$request->file('postImage')->getClientOriginalName();
                $request->file('postImage')->storeAs('public',$fileName);
                $updateData['image'] = $fileName;
            }
            Post::where('id',$id)->update($updateData);
            return redirect()->route('post#home')->with(['updateSuccess' => 'Update Success']);

        }

    //get updated data
    public function getUpdateData($request){
        return [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
            'price' => $request->postFee,
            'address' => $request->postAddress,
            'rating' => $request->postRating,
            // 'updated_at' => Carbon::now() // if timestamps it is auto
        ];
    }





//get Post Data
private function getPostData($request){
    $data =[
        'title' => $request->postTitle,
        'description' => $request->postDescription,
    ];
    $data['price'] = $request->postFee == null ? 2000 : $request->postFee;
    $data['address'] = $request->postAddress == null ? 'Yangon' : $request->postAddress;
    $data['rating'] = $request->postRating == null ? 5 : $request->postRating;

    return $data;
    }

    //post validation check
private function postValidationCheck($request){
    $validationRules = [
        'postTitle' => 'required|min:5|unique:posts,title,'.$request->postId,
        'postDescription' => 'required|min:5',
        // 'postFee' => 'required',
        // 'postAddress' => 'required',
        // 'postRating' => 'required',
        'postImage' => 'mimes:jpg,jpeg,png',

    ];


    $validationMessage = [
        'postTitle.required' => 'You have to fill post title ' ,
        'postTitle.min' => 'Post title must be at least five words' ,

        'postDescription.required' => 'You have to fill post description' ,
        'postDescription.min' => 'Post description must be at least five words' ,

        'postTitle.unique' => 'This title is already taken please change title name',
        'postFee.required' => "Fee need to be filled",
        'postAddress.required' => 'Address need to be filled',
        'postRating.required' => 'Please rate',
    ];
    Validator::make($request->all(),$validationRules,$validationMessage)->validate();

}

}



