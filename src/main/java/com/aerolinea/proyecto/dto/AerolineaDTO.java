package com.aerolinea.proyecto.dto;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class AerolineaDTO {
    private Long idAerolinea;

    @NotBlank(message = "El nombre de la aerolínea es requerido")
    private String nombreAerolinea;

    @NotBlank(message = "El país de origen es requerido")
    private String paisOrigen;
}