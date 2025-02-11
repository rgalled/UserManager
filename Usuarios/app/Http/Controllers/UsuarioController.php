<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function base(){
        return view('base');
     }


    public function index()
    {
        $usuarios = User::all(); 
        return view('usuario.index', compact('usuarios'));
    }

    public function login(Request $request){
        $creadentials = $request->only('email','password');
        if(Auth::attempt($creadentials)){
            return redirect('usuario');
        }else{
            return back()->with('error','Error al iniciar sesión, porfavor intente de nuevo');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    // Validación de los datos
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8',
        'role' => 'string|in:User,Admin',
    ]);

    try{
        $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),  
        'role' => $validated['role'] ?? 'User',
        'verification' => $validated['verification'] ?? 0,  
        ]); 

        return redirect()->route('usuario.index')->with('success', 'Usuario creado con éxito.');
    }catch(Exception $e){
        return back()->withInput()->withErrors(['message' => 'Error al crear al usuario']);
    }
    

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuario.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'in:User,Admin',
        ]);
        $usuario = User::findOrFail($id);
        if ($usuario->email !== $validated['email']) {
            $usuario->verification = 0;
        }
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->role = $validated['role'] ?? $usuario->role;;
        try{
            $usuario->save();
            return redirect()->route('usuario.index')->with('success', 'Usuario actualizado con éxito.');
        }catch(Exception $e){
            return redirect()->route('usuario.index')->with('error', 'No se pudo actualizado al usuario');
        }
        
    }

    public function verify(){
            try {
                $id = Auth::id();
                $usuario = User::findOrFail($id);
                $usuario->update(['verification' => 1]);
                return redirect()->route('usuario.index')->with('success', 'Usuario verificado con éxito.');
            } catch (Exception $e) {
                return redirect()->route('usuario.index')->with('error', 'No se pudo verificar al usuario.');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $id)
    {
        try{

            User::find($id->id)->delete();
            return redirect()->route('usuario.index')->with('success', 'Usuario borrado con éxito');
        }catch(Exception $ex){
            return redirect()->route('usuario.index')->with('error', 'No se pudo borrar al usuario');
        }
        
    }
}
