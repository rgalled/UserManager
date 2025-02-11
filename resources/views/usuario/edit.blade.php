@extends('base')

@section('content')
<div class="container">
    <h2>Editar Usuario</h2>

    <!-- Mostrar posibles errores -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario para editar el usuario -->
    <form action="{{ route('usuario.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
        </div>

        @if (Auth::User()->role == 'SuperAdmin' || (Auth::User()->role == 'Admin' && Auth::id() !== $usuario->id))
        <div class="form-group">
            <label for="role">Rol</label>
            <select id="role" name="role" class="form-control" required>
                <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        @endif
        
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
