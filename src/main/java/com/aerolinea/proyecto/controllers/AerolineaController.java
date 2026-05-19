package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.dto.AerolineaDTO;
import com.aerolinea.proyecto.models.Aerolinea;
import com.aerolinea.proyecto.repository.AerolineaRepository;
import jakarta.validation.Valid;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/api/aerolineas")
public class AerolineaController {

    private final AerolineaRepository repository;

    public AerolineaController(AerolineaRepository repository) {
        this.repository = repository;
    }

    @GetMapping
    public ResponseEntity<List<AerolineaDTO>> listar() {
        List<AerolineaDTO> dtos = repository.findAll().stream().map(a -> {
            AerolineaDTO dto = new AerolineaDTO();
            dto.setIdAerolinea(Long.valueOf(a.getIdAerolinea()));
            dto.setNombreAerolinea(a.getNombreAerolinea());
            dto.setPaisOrigen(a.getPaisOrigen());
            return dto;
        }).collect(Collectors.toList());
        return ResponseEntity.ok(dtos);
    }

    @PostMapping
    public ResponseEntity<AerolineaDTO> guardar(@Valid @RequestBody AerolineaDTO dto) {
        Aerolinea aerolinea = new Aerolinea();
        aerolinea.setNombreAerolinea(dto.getNombreAerolinea());
        aerolinea.setPaisOrigen(dto.getPaisOrigen());

        Aerolinea guardada = repository.save(aerolinea);
        dto.setIdAerolinea(Long.valueOf(guardada.getIdAerolinea()));
        return ResponseEntity.ok(dto);
    }
}