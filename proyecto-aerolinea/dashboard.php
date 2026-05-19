<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>airline tickets - Vuelos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex min-h-screen">

    <?php include 'navbar.php'; ?>

    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Módulo de Gestión de Vuelos</h1>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8">
            <h2 class="text-lg font-semibold text-slate-700 mb-4">Registrar Nuevo Vuelo</h2>
            <form id="vueloForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600">Origen</label>
                    <input type="text" id="origen" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Destino</label>
                    <input type="text" id="destino" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Aerolínea Operadora</label>
                    <select id="idAerolinea" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cargando aerolíneas...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Fecha de Salida</label>
                    <input type="date" id="fechaSalida" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Hora de Salida</label>
                    <input type="time" id="horaSalida" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Tarifa ($)</label>
                    <input type="number" step="0.01" id="tarifa" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow">Guardar Vuelo</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-700">Listado de Rutas Activas</h2>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 uppercase text-xs font-bold border-b border-slate-200">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Origen</th>
                        <th class="px-6 py-3">Destino</th>
                        <th class="px-6 py-3">Aerolínea</th>
                        <th class="px-6 py-3">Fecha / Hora</th>
                        <th class="px-6 py-3">Tarifa</th>
                    </tr>
                </thead>
                <tbody id="tabla-vuelos" class="text-sm divide-y divide-slate-100 text-slate-700"></tbody>
            </table>
        </div>
    </div>

    <script>
        async function inicializarModulo() {
            const tk = localStorage.getItem('jwt_token');
            
            // 1. Bloquear selección de fechas anteriores a hoy
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            let mm = hoy.getMonth() + 1;
            let dd = hoy.getDate();
            if (mm < 10) mm = '0' + mm;
            if (dd < 10) dd = '0' + dd;
            document.getElementById('fechaSalida').setAttribute('min', `${yyyy}-${mm}-${dd}`);

            // 2. Cargar select de aerolíneas disponibles
            const resA = await fetch('http://localhost:8080/api/aerolineas', { headers: { 'Authorization': `Bearer ${tk}` } });
            const aeros = await resA.json();
            const select = document.getElementById('idAerolinea');
            select.innerHTML = '<option value="">Seleccione una aerolínea...</option>';
            aeros.forEach(a => { select.innerHTML += `<option value="${a.idAerolinea}">${a.nombreAerolinea}</option>`; });

            // 3. Cargar listado en la tabla utilizando VueloDTO
            const resV = await fetch('http://localhost:8080/api/vuelos', { headers: { 'Authorization': `Bearer ${tk}` } });
            const vuelos = await resV.json();
            const tbody = document.getElementById('tabla-vuelos');
            tbody.innerHTML = '';
            vuelos.forEach(v => {
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-slate-500 font-medium">${v.idVuelo}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">${v.origen}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">${v.destino}</td>
                        <td class="px-6 py-4 text-slate-600 font-medium">${v.nombreAerolinea || 'No asignada'}</td>
                        <td class="px-6 py-4">${v.fechaSalida} a las ${v.horaSalida}</td>
                        <td class="px-6 py-4 font-extrabold text-blue-600">$${v.tarifa}</td>
                    </tr>
                `;
            });
        }

        document.getElementById('vueloForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const tk = localStorage.getItem('jwt_token');
            
            const vueloDTO = {
                origen: document.getElementById('origen').value,
                destino: document.getElementById('destino').value,
                fechaSalida: document.getElementById('fechaSalida').value,
                horaSalida: document.getElementById('horaSalida').value + ":00", // Asegura formato HH:mm:ss
                tarifa: parseFloat(document.getElementById('tarifa').value),
                idAerolinea: parseInt(document.getElementById('idAerolinea').value)
            };

            const res = await fetch('http://localhost:8080/api/vuelos', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${tk}`, 'Content-Type': 'application/json' },
                body: JSON.stringify(vueloDTO)
            });

            if (res.ok) {
                alert("Vuelo guardado exitosamente a través de VueloDTO.");
                document.getElementById('vueloForm').reset();
                inicializarModulo();
            } else {
                const errMsg = await res.text();
                alert("Error al registrar vuelo: " + errMsg);
            }
        });

        inicializarModulo();
    </script>
</body>
</html>