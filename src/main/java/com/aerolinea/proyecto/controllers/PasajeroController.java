package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.models.Pasajero;
import com.aerolinea.proyecto.repository.PasajeroRepository;
import jakarta.validation.Valid;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/api/pasajeros")
@CrossOrigin(origins = "*")
public class PasajeroController {

    private final PasajeroRepository repository;

    public PasajeroController(PasajeroRepository repository) {
        this.repository = repository;
    }

    @GetMapping
    public ResponseEntity<List<Pasajero>> listar() {
        return ResponseEntity.ok(repository.findAll());
    }

    @PostMapping
    public ResponseEntity<Pasajero> guardar(@Valid @RequestBody Pasajero pasajero) {
        // Guarda directo y limpio, ya que la BD y la entidad son idénticas ahora
        Pasajero guardado = repository.save(pasajero);
        return ResponseEntity.ok(guardado);
    }
}