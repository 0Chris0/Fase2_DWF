package com.aerolinea.proyecto.dto;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Positive;
import lombok.Data;
import java.math.BigDecimal;
import java.time.LocalDate;
import java.time.LocalTime;

@Data
public class VueloDTO {
    private Long idVuelo;

    @NotBlank(message = "El origen es obligatorio")
    private String origen;

    @NotBlank(message = "El destino es obligatorio")
    private String destino;

    @NotNull(message = "La fecha de salida es obligatoria")
    private LocalDate fechaSalida;

    @NotNull(message = "La hora de salida es obligatoria")
    private LocalTime horaSalida;

    @NotNull(message = "La tarifa es obligatoria")
    @Positive(message = "La tarifa debe ser mayor a cero")
    private BigDecimal tarifa;

    @NotNull(message = "El ID de la aerolínea es obligatorio")
    private Long idAerolinea;

    private String nombreAerolinea; // Útil para mostrar el nombre en el frontend sin exponer la entidad
}