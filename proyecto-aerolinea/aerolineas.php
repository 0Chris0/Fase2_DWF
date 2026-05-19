<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>airline tickets - Aerolíneas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex min-h-screen">

    <?php include 'navbar.php'; ?>

    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Módulo de Aerolíneas</h1>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8">
            <h2 class="text-lg font-semibold text-slate-700 mb-4">Registrar Nueva Aerolínea</h2>
            <form id="aerolineaForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600">Nombre de la Aerolínea</label>
                    <input type="text" id="nombreAerolinea" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">País de Origen</label>
                    <input type="text" id="paisOrigen" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow">Guardar Aerolínea</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-700">Compañías Aéreas Registradas</h2>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 uppercase text-xs font-bold border-b border-slate-200">
                        <th class="px-6 py-3">ID Aerolínea</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">País de Origen</th>
                    </tr>
                </thead>
                <tbody id="tabla-aerolineas" class="text-sm divide-y divide-slate-100 text-slate-700"></tbody>
            </table>
        </div>
    </div>

    <script>
        async function cargarAerolineas() {
            const tk = localStorage.getItem('jwt_token');
            try {
                const res = await fetch('http://localhost:8080/api/aerolineas', {
                    headers: { 'Authorization': `Bearer ${tk}` }
                });
                const data = await res.json();
                const tbody = document.getElementById('tabla-aerolineas');
                tbody.innerHTML = '';
                
                data.forEach(a => {
                    tbody.innerHTML += `
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-500 font-medium">${a.idAerolinea}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">${a.nombreAerolinea}</td>
                            <td class="px-6 py-4 text-slate-600">${a.paisOrigen}</td>
                        </tr>
                    `;
                });
            } catch (err) {
                console.error("Error al cargar aerolíneas:", err);
            }
        }

        document.getElementById('aerolineaForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const tk = localStorage.getItem('jwt_token');
            
            const payload = {
                nombreAerolinea: document.getElementById('nombreAerolinea').value,
                paisOrigen: document.getElementById('paisOrigen').value
            };

            const res = await fetch('http://localhost:8080/api/aerolineas', {
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${tk}`, 
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify(payload)
            });

            if (res.ok) {
                alert("Aerolínea registrada con éxito.");
                document.getElementById('aerolineaForm').reset();
                cargarAerolineas();
            } else {
                alert("Hubo un problema al guardar la aerolínea.");
            }
        });

        cargarAerolineas();
    </script>
</body>
</html>