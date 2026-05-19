package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.models.Pago;
import com.aerolinea.proyecto.models.Reserva;
import com.aerolinea.proyecto.repository.PagoRepository;
import com.aerolinea.proyecto.repository.ReservacionRepository;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.time.LocalDate;

@RestController
@RequestMapping("/api/pagos")
@CrossOrigin(origins = "*")
public class PagoController {

    private final PagoRepository pagoRepository;
    private final ReservacionRepository reservacionRepository; // Nombre corregido para evitar confusiones

    public PagoController(PagoRepository pagoRepository, ReservacionRepository reservacionRepository) {
        this.pagoRepository = pagoRepository;
        this.reservacionRepository = reservacionRepository;
    }

    @PostMapping
    public ResponseEntity<?> guardar(@RequestBody Pago pago) {

        // 🛠️ PARCHE 1: Si no viene fecha de pago, le ponemos la de HOY
        if (pago.getFechaPago() == null) {
            pago.setFechaPago(LocalDate.now());
        }

        // 🛠️ PARCHE 2: Si el frontend no mandó el id_reserva, lo rescatamos del backend
        if (pago.getIdReserva() == null) {
            // Ahora que ya declaraste el método en ReservacionRepository, esto compilará limpio
            Reserva ultimaReserva = reservacionRepository.findFirstByOrderByIdReservaDesc()
                    .orElse(null);

            if (ultimaReserva != null) {
                pago.setIdReserva(ultimaReserva.getIdReserva());
            } else {
                return ResponseEntity.badRequest().body("{\"error\":\"No se encontró ninguna reservación activa para asociar este pago.\"}");
            }
        }

        Pago guardado = pagoRepository.save(pago);
        return ResponseEntity.ok(guardado);
    }
}