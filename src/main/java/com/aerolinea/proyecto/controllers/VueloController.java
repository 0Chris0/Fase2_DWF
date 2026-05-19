package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.dto.VueloDTO;
import com.aerolinea.proyecto.models.Aerolinea;
import com.aerolinea.proyecto.models.Vuelo;
import com.aerolinea.proyecto.repository.AerolineaRepository;
import com.aerolinea.proyecto.repository.VueloRepository;
import jakarta.validation.Valid;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/api/vuelos")
public class VueloController {

    private final VueloRepository repository;
    private final AerolineaRepository aerolineaRepository;

    public VueloController(VueloRepository repository, AerolineaRepository aerolineaRepository) {
        this.repository = repository;
        this.aerolineaRepository = aerolineaRepository;
    }

    @GetMapping
    public ResponseEntity<List<VueloDTO>> listar() {
        List<VueloDTO> dtos = repository.findAll().stream().map(v -> {
            VueloDTO dto = new VueloDTO();
            dto.setIdVuelo(Long.valueOf(v.getIdVuelo()));
            dto.setOrigen(v.getOrigen());
            dto.setDestino(v.getDestino());
            dto.setFechaSalida(v.getFechaSalida());
            dto.setHoraSalida(v.getHoraSalida());
            dto.setTarifa(v.getTarifa());
            if (v.getAerolinea() != null) {
                dto.setIdAerolinea(Long.valueOf(v.getAerolinea().getIdAerolinea()));
                dto.setNombreAerolinea(v.getAerolinea().getNombreAerolinea());
            }
            return dto;
        }).collect(Collectors.toList());
        return ResponseEntity.ok(dtos);
    }

    @PostMapping
    public ResponseEntity<?> guardar(@Valid @RequestBody VueloDTO dto) {
        try {
            // ====== SOLUCIÓN: Le pasamos el Long directo sin el .intValue() ======
            Aerolinea aerolinea = aerolineaRepository.findById(dto.getIdAerolinea())
                    .orElseThrow(() -> new RuntimeException("La aerolínea con ID " + dto.getIdAerolinea() + " no existe."));

            // Mapeamos manualmente del DTO a tu Entidad Vuelo.java
            Vuelo vuelo = new Vuelo();
            vuelo.setOrigen(dto.getOrigen());
            vuelo.setDestino(dto.getDestino());
            vuelo.setFechaSalida(dto.getFechaSalida());
            vuelo.setHoraSalida(dto.getHoraSalida());
            vuelo.setTarifa(dto.getTarifa());
            vuelo.setAerolinea(aerolinea);

            Vuelo guardado = repository.save(vuelo);

            dto.setIdVuelo(Long.valueOf(guardado.getIdVuelo()));
            dto.setNombreAerolinea(aerolinea.getNombreAerolinea());

            return ResponseEntity.ok(dto);
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).body(e.getMessage());
        }
    }
}