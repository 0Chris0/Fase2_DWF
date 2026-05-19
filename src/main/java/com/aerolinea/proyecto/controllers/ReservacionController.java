package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.models.Reserva;
import com.aerolinea.proyecto.repository.ReservacionRepository;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.time.LocalDate;

@RestController
@RequestMapping("/api/reservas")
@CrossOrigin(origins = "*")
public class ReservacionController {

    private final ReservacionRepository repository;

    public ReservacionController(ReservacionRepository repository) {
        this.repository = repository;
    }

    @PostMapping
    public ResponseEntity<Reserva> guardar(@RequestBody Reserva reserva) {

        // 🛠️ PARCHE: Si el frontend no manda fecha, le clavamos la de HOY automáticamente
        if (reserva.getFechaReserva() == null) {
            reserva.setFechaReserva(LocalDate.now());
        }

        // 🛠️ PARCHE: Si el estado viene vacío, lo dejamos como "CONFIRMADA" o "PENDIENTE"
        if (reserva.getEstado() == null || reserva.getEstado().trim().isEmpty()) {
            reserva.setEstado("CONFIRMADA");
        }

        Reserva guardado = repository.save(reserva);
        return ResponseEntity.ok(guardado);
    }
}