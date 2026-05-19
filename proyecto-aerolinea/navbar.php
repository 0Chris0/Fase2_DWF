<div class="w-64 bg-slate-900 text-white flex flex-col justify-between p-4 min-h-screen shadow-lg">
    <div>
        <div class="flex items-center space-x-2 px-2 py-4 border-b border-slate-800 mb-6">
            <span class="text-blue-500 text-2xl">✈</span>
            <span class="text-lg font-bold tracking-wider">airline tickets</span>
        </div>

        <nav class="space-y-1">
            <a href="dashboard.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm text-slate-300 hover:text-white">
                <span>📊</span> <span>Vuelos</span>
            </a>
            <a href="aerolineas.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm text-slate-300 hover:text-white">
                <span>🏢</span> <span>Aerolíneas</span>
            </a>
            <a href="reservas.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm text-slate-300 hover:text-white">
                <span>🎟️</span> <span>Reservas y Pagos</span>
            </a>
            <a href="gestionar_reservas.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm text-slate-300 hover:text-white">
                <span>📋</span> <span>Gestionar Reservas</span>
            </a>
        </nav>
    </div>

    <div class="border-t border-slate-800 pt-4">
        <div class="px-2 py-1 mb-3">
            <div id="nav-user-name" class="text-sm font-semibold text-white">Cargando...</div>
            <div id="nav-user-role" class="text-xs text-blue-400 font-medium uppercase mt-0.5 tracking-wider">Rol</div>
        </div>
        <button onclick="logout()" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg bg-red-950/30 text-red-400 hover:bg-red-900/40 transition text-sm font-medium">
            <span>🚪</span> <span>Cerrar sesión</span>
        </button>
    </div>
</div>

<script>
    const token = localStorage.getItem('jwt_token');
    if (!token) {
        window.location.href = 'index.php';
    }

    document.getElementById('nav-user-name').innerText = localStorage.getItem('user_name') || 'Usuario';
    document.getElementById('nav-user-role').innerText = localStorage.getItem('user_role') || 'USER';

    function logout() {
        localStorage.clear();
        window.location.href = 'index.php';
    }
</script>