<?php

namespace App\Http\Controllers\dashboard;

use App\Clase;
use App\Category;
use App\User;
//use App\ClaseImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClasePost;
use Illuminate\Support\Facades\URL;

class ClaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'rol.admin']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clases = Clase::with('category')->orderBy('start', request('start', 'DESC'));

        if ($request->has('search')) {
            $clases = $clases->where('title', 'like', '%' . request('search') . '%');
        }
        
        $clases = $clases->paginate(5);
        return view('dashboard.clase.index', ['clases' => $clases]);
    }

    public function indexCalendario()
    {
        $clase = Clase::get();
        $categories = Category::pluck('id', 'title');
        
        return view('calendario.index-calendario', compact('clase', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('id', 'title');
        return view('dashboard.clase.create', ['clase' => new Clase(), 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClasePost $request)
    {
        $filename = time().".".$request->image->extension();

        $request->image->move(public_path('images'), $filename);

        Clase::create(
            [
                'title' => $request->title,
                'descripcion' => $request->descripcion,
                'image' => $filename,
                'category_id' => $request->category_id,
                'hora' => $request->hora,
                'posted' => $request->posted,
                'color' => $request->color,
                'textcolor' => $request->textcolor,
                'start' => $request->start,
                'end' => $request->end
            ]
        );
        return back()->with('status', 'Clase creado con exito');
    }

    public function storeCalendario(Request $request)
    {
        //insertamos en la BB.DD los datos de la clase
        $datosClase = request()->except(['_token', '_method']);
        Clase::insert($datosClase);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clase $clase)
    {
        return view('dashboard.clase.show', ['clase' => $clase]);
    }

    public function showCalendario(Clase $clase)
    {
        $data['clases'] = Clase::all();
        return response()->json($data['clases']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clase $clase)
    {
        $categories = Category::pluck('id', 'title');
        return view('dashboard.clase.edit', compact('clase', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClasePost $request, Clase $clase)
    {
        $filename = time().".".$request->image->extension();

        $request->image->move(public_path('images'), $filename);

        $clase->update(
            [
                'title' => $request->title,
                'descripcion' => $request->descripcion,
                'image' => $filename,
                'category_id' => $request->category_id,
                'hora' => $request->hora,
                'posted' => $request->posted,
                'color' => $request->color,
                'textcolor' => $request->textcolor,
                'start' => $request->start,
                'end' => $request->end
            ]
        );
        return back()->with('status', 'Clase actualizada correctamente');
    }

    public function updateCalendario(Request $request, Clase $clase)
    {
        $datosClase = request()->except(['_token', '_method']);
        $claseModificada = Clase::where('id', '=', $clase->id)->update($datosClase);

        return response()->json($claseModificada);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clase $clase)
    {
        $clase->delete();
        return back()->with('status', 'Clase eliminada eliminado con exito');
    }

    public function destroyCalendario(Clase $clase)
    {
        $clases = Clase::findOrFail($clase->id);
        Clase::destroy($clase->id);

        return response()->json($clase->id);
    }

    public function inicio(Request $request){

        $clases = Clase::with('category')->orderBy('start', request('start', 'ASC'));

        if ($request->has('search')) {
            $clases = $clases->where('title', 'like', '%' . request('search') . '%');
        }

        $clases = $clases->paginate(5);
        $user = User::pluck('name');
        $categories = Category::pluck('id', 'title');
        
        return view('dashboard.clase.inicio', compact('clases', 'user', 'categories'));
    }

    /*public function image(Request $request, Clase $clase){

        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240'//10Mb
        ]);

        $filename = time().".".$request->image->extension();

        $request->image->move(public_path('images'), $filename);

        /*if(!isset($clase->id) || $clase->id == '' || $clase->id == null){
            $clase->id = $request->clase_id;
        }*/

        /*Clase::create(['image' => $filename, 'clase_id' => $clase_id]);
        return back()->with('status', 'Imagen cargada con exito');
    }*/

    public function descripcionImage(Request $request){

        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240'//10Mb
        ]);

        $filename = time().".".$request->image->extension();

        $request->image->move(public_path('images_clase'), $filename);

        return response()->json(["default" => URL::to('/').'/images_clase/'.$filename]);
    }
}
