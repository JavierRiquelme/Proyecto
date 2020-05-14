<?php

namespace App\Http\Controllers\front;

use App\Clase;
use App\Category;
use App\Contact;
use App\User;
use App\PostComment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactPost;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clases = Clase::paginate(5);
        return view('frontblog.blog.index', ['clases' => $clases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('id');
        $contact = new Contact();
        return view('frontblog.blog.contact', ['contact' => $contact]);
    }

    public function createComment(Request $request, Clase $clase){
//falta validar los datos

        $comment = new PostComment();
        $comment->title = $request->get('title');
        $comment->message = $request->get('descripcion');
        $comment->clase_id = $clase->id;
        $comment->user_id = \Auth::user()->id;
        
        $comment->save();

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactPost $request)
    {
        Contact::create($request->validated());
        return back()->with('status', 'Contacto creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clase = Clase::findOrFail($id);
        return view('frontblog.blog.post', ['clase' => $clase]);
    }

    public function listClaseCategory(Category $category)
    {
        $clases = Clase::where('category_id','=',$category->id);
        $clases = $clases->paginate(5);

        return view('frontblog.blog.clases-category', compact('clases', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function about()
    {
        return view('frontblog.blog.about');
    }

    public function contact()
    {
        return view('frontblog.blog.contact');
    }

    public function categories(Category $categories)
    {
        $categories = Category::get();
        return view('frontblog.blog.categories', ['categories' => $categories]);
    }
}
