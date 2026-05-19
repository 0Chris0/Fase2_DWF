package com.aerolinea.proyecto.models;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Positive;
import lombok.Data;
import java.math.BigDecimal;
import java.time.LocalDate;
import java.time.LocalTime;

@Entity
@Table(name = "vuelo")
@Data
public class Vuelo {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_vuelo")
    private Long idVuelo;

    @NotBlank(message = "El origen es obligatorio")
    private String origen;

    @NotBlank(message = "El destino es obligatorio")
    private String destino;

    @NotNull(message = "La fecha de salida es obligatoria")
    @Column(name = "fecha_salida")
    private LocalDate fechaSalida;

    @NotNull(message = "La hora de salida es obligatoria")
    @Column(name = "hora_salida")
    private LocalTime horaSalida;

    @NotNull(message = "La tarifa es obligatoria")
    @Positive(message = "La tarifa debe ser mayor a cero")
    private BigDecimal tarifa;

    @ManyToOne
    @JoinColumn(name = "id_aerolinea", nullable = false)
    private Aerolinea aerolinea;
}