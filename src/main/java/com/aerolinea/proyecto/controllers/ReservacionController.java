package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.models.Reserva;
import com.aerolinea.proyecto.repository.ReservacionRepository;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.time.LocalDate;
import java.util.List; // <--- ¡ESTA ERA LA QUE FALTABA!

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
        if (reserva.getFechaReserva() == null) {
            reserva.setFechaReserva(LocalDate.now());
        }
        if (reserva.getEstado() == null || reserva.getEstado().trim().isEmpty()) {
            reserva.setEstado("CONFIRMADA");
        }
        Reserva guardado = repository.save(reserva);
        return ResponseEntity.ok(guardado);
    }

    @GetMapping
    public ResponseEntity<List<Reserva>> listar() {
        return ResponseEntity.ok(repository.findAll());
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> eliminar(@PathVariable Long id) {
        if (repository.existsById(id)) {
            repository.deleteById(id);
            return ResponseEntity.ok("{\"mensaje\":\"Reserva eliminada correctamente\"}");
        } else {
            return ResponseEntity.badRequest().body("{\"error\":\"La reserva no existe\"}");
        }
    }
}