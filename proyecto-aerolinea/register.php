<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>airline tickets - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-6">
            <span class="text-4xl text-blue-600">✈</span>
            <h1 class="text-2xl font-bold text-slate-800 mt-2">Crear Cuenta</h1>
            <p class="text-sm text-slate-500">Registrate para gestionar tus boletos aéreos</p>
        </div>
        
        <form id="registerForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Nombre Completo</label>
                <input type="text" id="nombre" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
                <input type="email" id="email" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Nombre de Usuario</label>
                <input type="text" id="username" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Contraseña</label>
                <input type="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow">Registrarme</button>
        </form>

        <div class="text-center mt-6 text-sm text-slate-600">
            ¿Ya tienes una cuenta? <a href="index.php" class="text-blue-600 font-medium hover:underline">Inicia sesión aquí</a>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const payload = {
                nombre: document.getElementById('nombre').value,
                email: document.getElementById('email').value,
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };

            try {
                const res = await fetch('http://localhost:8080/api/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (res.ok) {
                    alert("¡Registro exitoso! Ya puedes iniciar sesión.");
                    window.location.href = 'index.php';
                } else {
                    alert(data.mensaje || "Error al intentar registrar el usuario.");
                }
            } catch (err) {
                alert("Error de red: No se pudo conectar con el Backend.");
            }
        });
    </script>
</body>
</html>