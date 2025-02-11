@extends ('base')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="table-container">
        <h2 class="mb-4">Lista de Usuarios</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Verificado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario) 
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->role }}</td>
                        @if($usuario->verification == 0)
                            <td>NO</td>
                        @endif
                        @if($usuario->verification == 1)
                            <td>SI</td>
                        @endif
                        <td>
                        @if(!Auth::User()->verification == 0)
                            @if (Auth::id() == $usuario->id || Auth::user()->role !== 'User')
                                @if ($usuario->role !== 'SuperAdmin')
                                    @if (Auth::id() == $usuario->id || (Auth::user()->role == 'Admin' && $usuario->role == 'User') || $usuario->role == 'SuperAdmin' || Auth::user()->role == 'SuperAdmin')
                                    <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn-edit">Editar</a>
                                    @endif
                                    @if (Auth::User()->role == 'SuperAdmin' ||(Auth::user()->role == 'Admin' && $usuario->role == 'User'))
                                        @if (Auth::id() !== $usuario->id)
                                        <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST" style="display: inline;" onsubmit="return confirmarEliminacion(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                        <td colspan="5" class="no-data">No hay más usuarios registrados.</td>
                </tr>
            </tbody>
        </table>
        @if (Auth::User()->role == 'SuperAdmin')
        <a href="{{ route('usuario.create')}}" class="btn-new">Nuevo</a>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault(); 
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>

@endsection
