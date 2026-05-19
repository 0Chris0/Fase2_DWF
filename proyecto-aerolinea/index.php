<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>airline tickets - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-8">
            <span class="text-4xl text-blue-600">✈</span>
            <h1 class="text-2xl font-bold text-slate-800 mt-2">Bienvenido de nuevo</h1>
            <p class="text-sm text-slate-500">Ingresa tus credenciales de la universidad</p>
        </div>

        <form id="loginForm" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700">Nombre de Usuario</label>
                <input type="text" id="username" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Contraseña</label>
                <input type="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow">Iniciar Sesión</button>
        </form>

        <div class="text-center mt-6 text-sm text-slate-600">
            ¿No tienes una cuenta? <a href="register.php" class="text-blue-600 font-medium hover:underline">Regístrate aquí</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Estructura limpia que mapea con LoginRequestDTO
            const loginPayload = {
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };

            try {
                const res = await fetch('http://localhost:8080/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(loginPayload)
                });

                if (res.ok) {
                    // Recibe el JwtResponseDTO desde Spring Boot
                    const data = await res.json();
                    localStorage.setItem('jwt_token', data.token);
                    localStorage.setItem('user_role', data.role);
                    localStorage.setItem('user_name', data.nombre);
                    window.location.href = 'dashboard.php';
                } else {
                    alert("Credenciales incorrectas. Inténtalo de nuevo.");
                }
            } catch (err) {
                alert("Error crítico: No se pudo establecer conexión con el Backend.");
            }
        });
    </script>
</body>

</html>