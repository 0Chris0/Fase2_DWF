<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reservas - Aerolínea</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col justify-between p-4 shrink-0">
            <div class="space-y-6">
                <div class="px-3 py-2 flex items-center space-x-2">
                    <span class="text-xl">✈️</span>
                    <span class="font-bold text-lg tracking-wider bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">airline tickets</span>
                </div>

                <nav class="space-y-1.5">
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

            <div class="border-t border-slate-800 pt-4 px-3 text-xs text-slate-500">
                Sistema Aerolínea v1.0
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-6xl mx-auto">

                <div class="flex justify-between items-center mb-8 border-b border-slate-800 pb-4">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight flex items-center gap-2">📋 Panel de Reservaciones</h1>
                        <p class="text-sm text-slate-400 mt-1">Consulta el listado general de reservas y elimina registros.</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 px-4 py-2 rounded-lg text-sm">
                        Total Registros: <span id="total-reservas" class="font-bold text-cyan-400">0</span>
                    </div>
                </div>

                <div id="alerta-vacia" class="hidden bg-slate-900 border border-amber-500/30 text-amber-400 p-4 rounded-xl text-center my-6 text-sm">
                    ✨ No se encontraron reservaciones registradas en la base de datos.
                </div>

                <div id="contenedor-tabla" class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-800/50 border-b border-slate-700 text-slate-300 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold">ID Reserva</th>
                                    <th class="px-6 py-4 font-semibold">Pasajero (ID / Nombre)</th>
                                    <th class="px-6 py-4 font-semibold">ID Vuelo</th>
                                    <th class="px-6 py-4 font-semibold">Fecha Reserva</th>
                                    <th class="px-6 py-4 font-semibold">Estado</th>
                                    <th class="px-6 py-4 font-semibold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-cuerpo" class="divide-y divide-slate-800 text-sm text-slate-300">
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500 animate-pulse">
                                        Cargando datos desde Spring Boot...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        const API_URL = "http://localhost:8080/api/reservas";

        // 1. Cargar y listar las reservas automáticamente
        function cargarReservas() {
            fetch(API_URL)
                .then(response => {
                    if (!response.ok) throw new Error("Error en la respuesta del servidor central.");
                    return response.json();
                })
                .then(data => {
                    const tbody = document.getElementById("tabla-cuerpo");
                    const totalBadge = document.getElementById("total-reservas");
                    const alertaVacia = document.getElementById("alerta-vacia");
                    const contenedorTabla = document.getElementById("contenedor-tabla");

                    tbody.innerHTML = "";
                    totalBadge.textContent = data.length;

                    if (data.length === 0) {
                        alertaVacia.classList.remove("hidden");
                        contenedorTabla.classList.add("hidden");
                        return;
                    }

                    alertaVacia.classList.add("hidden");
                    contenedorTabla.classList.remove("hidden");

                    data.forEach(reserva => {
                        // Mapeo adaptado tanto a nombres camelCase como snake_case de las tablas de BD
                        const id = reserva.idReserva || reserva.id_reserva;

                        // Si viene el objeto Pasajero mapeamos su nombre_completo, si no, mostramos el ID directo
                        const infoPasajero = reserva.pasajero?.nombreCompleto || reserva.pasajero?.nombre_completo || `ID Pasajero: ${reserva.idPasajero || reserva.id_pasajero || 'N/A'}`;

                        const vuelo = reserva.idVuelo || reserva.id_vuelo || 'N/A';
                        const fecha = reserva.fechaReserva || reserva.fecha_reserva || 'N/A';
                        const estado = (reserva.estado || 'PENDIENTE').toUpperCase();

                        const claseEstado = estado === 'CONFIRMADA' || estado === 'PAGADO' ?
                            'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' :
                            'bg-amber-500/10 text-amber-400 border-amber-500/20';

                        const filaHtml = `
                            <tr id="fila-${id}" class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-cyan-400">#${id}</td>
                                <td class="px-6 py-4 font-medium text-slate-200">${infoPasajero}</td>
                                <td class="px-6 py-4"><span class="bg-slate-800 border border-slate-700 px-2 py-1 rounded text-xs">🛫 V-${vuelo}</span></td>
                                <td class="px-6 py-4 text-slate-400">${fecha}</td>
                                <td class="px-6 py-4">
                                    <span class="border px-2.5 py-0.5 rounded-full text-xs font-medium ${claseEstado}">
                                        ${estado}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="eliminarReserva(${id})" class="bg-red-500/10 hover:bg-red-600 border border-red-500/20 text-red-400 hover:text-white text-xs px-4 py-1.5 rounded-lg transition-all duration-150">
                                        🗑️ Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML("beforeend", filaHtml);
                    });
                })
                .catch(error => {
                    document.getElementById("tabla-cuerpo").innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-red-400 font-medium">
                                ❌ Error de comunicación. Asegúrate de que el backend de Spring Boot esté encendido.
                            </td>
                        </tr>
                    `;
                });
        }

        // 2. Acción para eliminar la reserva (DELETE)
        function eliminarReserva(id) {
            if (confirm(`¿Estás seguro de que deseas eliminar permanentemente la reserva #${id}?`)) {
                fetch(`${API_URL}/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => {
                        if (!response.ok) throw new Error("El servidor no pudo procesar la eliminación.");

                        // Remueve visualmente la fila con efecto suave y refresca el listado
                        const fila = document.getElementById(`fila-${id}`);
                        if (fila) {
                            fila.classList.add("opacity-0", "transition-opacity", "duration-200");
                            setTimeout(() => {
                                cargarReservas();
                            }, 200);
                        }
                    })
                    .catch(error => alert("Error al eliminar: " + error.message));
            }
        }

        // Ejecutar carga de datos al inicializar la vista
        document.addEventListener("DOMContentLoaded", cargarReservas);
    </script>
</body>

</html>