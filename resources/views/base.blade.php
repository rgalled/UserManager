<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de Usuarios')</title>
    <!-- Estilos adicionales -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>
<body class="bg-light">
    @if (Auth::User() == null)
        <div class="login-container">
            <div class="login-box">
                <h2>Iniciar Sesión</h2>
                <form action="{{route('usuario.login')}}" method="POST">
                    @csrf
                    <div class="textbox">
                        <input type="email" placeholder="Correo Electrónico" name="email" required>
                    </div>
                    <div class="textbox">
                        <input type="password" placeholder="Contraseña" name="password" required>
                    </div>
                    <button type="submit" class="btn">Iniciar Sesión</button>
                </form>
            </div>
        </div>
        @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
        @endif
    @endif
    @if(!Auth()->User() == null)
        <header class="bg-dark text-white py-3 mb-4">
        <div class="container">
            <h1 class="m-0">Gestión de Usuarios</h1>
            <p class="mt-3">Bienvenido, {{ Auth::user()->name }}</p>
            @if(Auth::User()->verification == 0)
            <h3 class="mt-2">
                Cuenta no verificada
            </h3>
            <form action="{{ route('usuario.verify') }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Verificar Cuenta</button>
            </form>
            @endif
        </div>

        <div class="mt-3">
            <a href="{{ route('usuario.logout') }}" class="btn-logout">Cerrar sesión</a>
        </div>
        </header>
        
        <main class="container">
                @yield('content')
        </main>
    @endif
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts adicionales -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
