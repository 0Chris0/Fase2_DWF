<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>airline tickets - Reservas y Pagos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex min-h-screen">

    <?php include 'navbar.php'; ?>

    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Módulo de Reservaciones y Pagos</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-semibold text-slate-700 mb-4">Paso 1: Datos del Pasajero</h2>
                <form id="pasajeroForm" class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Nombre</label>
                            <input type="text" id="p_nombre" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Emerson">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Apellido</label>
                            <input type="text" id="p_apellido" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Arévalo">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Documento Único de Identidad (DUI)</label>
                        <input type="text" id="p_dui" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. 00000000-0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Fecha de Nacimiento</label>
                        <input type="date" id="p_fechaNacimiento" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Teléfono</label>
                        <input type="text" id="p_tel" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Correo Electrónico</label>
                        <input type="email" id="p_email" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow">Guardar Pasajero</button>
                </form>
                <div id="pasajeroStatus" class="mt-3 text-xs font-bold text-emerald-600 hidden">✓ Pasajero seleccionado ID: <span id="selectedPasajeroId">0</span></div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 opacity-50 pointer-events-none" id="step2Container">
                <h2 class="text-lg font-semibold text-slate-700 mb-4">Paso 2: Crear Reservación</h2>
                <form id="reservaForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Seleccionar Vuelo Disponible</label>
                        <select id="r_vuelo" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Cargando vuelos...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Estado de la Reserva</label>
                        <input type="text" id="r_estado" value="CONFIRMADA" readonly class="mt-1 block w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-lg text-sm font-bold text-slate-700">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-indigo-700 transition shadow">Confirmar Reserva</button>
                </form>
                <div id="reservaStatus" class="mt-3 text-xs font-bold text-indigo-600 hidden">✓ Reservación Creada ID: <span id="selectedReservaId">0</span></div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 opacity-50 pointer-events-none" id="step3Container">
                <h2 class="text-lg font-semibold text-slate-700 mb-4">Paso 3: Registrar Pago</h2>
                <form id="pagoForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Monto a Cancelar ($)</label>
                        <input type="number" step="0.01" id="pg_monto" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm font-extrabold text-blue-600 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Método de Pago</label>
                        <select id="pg_tipo" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Tarjeta de Credito/Debito">Tarjeta de Crédito / Débito</option>
                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                            <option value="Efectivo">Efectivo (Punto de Venta)</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-emerald-700 transition shadow">Procesar Transacción</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const tk = localStorage.getItem('jwt_token');

        // Inicializar: Cargar vuelos disponibles en el selector del Paso 2
        async function cargarVuelosDisponibles() {
            try {
                const res = await fetch('http://localhost:8080/api/vuelos', { headers: { 'Authorization': `Bearer ${tk}` } });
                const vuelos = await res.json();
                const select = document.getElementById('r_vuelo');
                select.innerHTML = '<option value="">Seleccione el vuelo de destino...</option>';
                vuelos.forEach(v => {
                    select.innerHTML += `<option value="${v.idVuelo}" data-tarifa="${v.tarifa}">${v.origen} ➔ ${v.destino} ($${v.tarifa})</option>`;
                });
            } catch (err) {
                console.error("Error al cargar rutas aéreas", err);
            }
        }

        // PASO 1: Guardar Pasajero (CON TODOS LOS CAMPOS UNIFICADOS PARA EVITAR EL ERROR 500)
        document.getElementById('pasajeroForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const nombreVal = document.getElementById('p_nombre').value.trim();
            const apellidoVal = document.getElementById('p_apellido').value.trim();
            const duiVal = document.getElementById('p_dui').value.trim();

            // Seteamos absolutamente todo para satisfacer a Spring Boot Y a la Base de Datos vieja
            const payload = {
                // Atributos requeridos por la base de datos vieja
                nombre: nombreVal,
                apellido: apellidoVal,
                dui: duiVal,
                
                // Atributos requeridos por las nuevas validaciones DTO de Java
                nombreCompleto: `${nombreVal} ${apellidoVal}`, 
                numeroPasaporte: duiVal, 
                fechaNacimiento: document.getElementById('p_fechaNacimiento').value,
                
                // Atributos comunes
                telefono: document.getElementById('p_tel').value,
                email: document.getElementById('p_email').value
            };

            try {
                const res = await fetch('http://localhost:8080/api/pasajeros', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${tk}`, 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    const pasajeroGuardado = await res.json();
                    const idObtenido = pasajeroGuardado.idPasajero || pasajeroGuardado.id_pasajero || pasajeroGuardado.id;
                    
                    document.getElementById('selectedPasajeroId').innerText = idObtenido;
                    document.getElementById('pasajeroStatus').classList.remove('hidden');
                    
                    // Desbloquear Paso 2
                    document.getElementById('step2Container').classList.remove('opacity-50', 'pointer-events-none');
                    alert("Pasajero registrado exitosamente en la base de datos.");
                } else {
                    const textoError = await res.text();
                    alert(`Error del Backend en Pasajeros (${res.status}): ${textoError}`);
                }
            } catch (error) {
                alert("Error de conexión con el servidor de Spring Boot.");
            }
        });

        // Detectar cambio de vuelo elegido para autollenar la tarifa en el Paso 3
        document.getElementById('r_vuelo').addEventListener('change', (e) => {
            const option = e.target.options[e.target.selectedIndex];
            const tarifa = option.getAttribute('data-tarifa') || "";
            document.getElementById('pg_monto').value = tarifa;
        });

        // PASO 2: Guardar Reserva en BD
        document.getElementById('reservaForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {
                idPasajero: parseInt(document.getElementById('selectedPasajeroId').innerText),
                idVuelo: parseInt(document.getElementById('r_vuelo').value),
                estado: document.getElementById('r_estado').value
            };

            try {
                const res = await fetch('http://localhost:8080/api/reservas', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${tk}`, 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    const reservaGuardada = await res.json();
                    const idReservaObtenido = reservaGuardada.idReserva || reservaGuardada.id_reserva || reservaGuardada.id;
                    
                    document.getElementById('selectedReservaId').innerText = idReservaObtenido;
                    document.getElementById('reservaStatus').classList.remove('hidden');
                    
                    // Desbloquear Paso 3
                    document.getElementById('step3Container').classList.remove('opacity-50', 'pointer-events-none');
                    alert("Reserva vinculada y guardada con éxito.");
                } else {
                    const textoError = await res.text();
                    alert(`Error del Backend en Reservas (${res.status}): ${textoError}`);
                }
            } catch (error) {
                alert("Error al conectar para guardar la reserva.");
            }
        });

        // PASO 3: Guardar Pago en BD
        document.getElementById('pagoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const hoy = new Date().toISOString().split('T')[0];

            const payload = {
                idReserva: parseInt(document.getElementById('selectedReservaId').innerText),
                monto: parseFloat(document.getElementById('pg_monto').value),
                tipoPago: document.getElementById('pg_tipo').value,
                fechaPago: hoy
            };

            try {
                const res = await fetch('http://localhost:8080/api/pagos', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${tk}`, 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    alert("¡Flujo completado con éxito! Pasajero, Reserva y Pago asentados en la Base de Datos.");
                    location.reload(); 
                } else {
                    const textoError = await res.text();
                    alert(`Error del Backend en Pagos (${res.status}): ${textoError}`);
                }
            } catch (error) {
                alert("Error de red al procesar la transacción.");
            }
        });

        cargarVuelosDisponibles();
    </script>
</body>
</html>