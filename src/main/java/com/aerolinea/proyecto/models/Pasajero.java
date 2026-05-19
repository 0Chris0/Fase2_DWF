package com.aerolinea.proyecto.models;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import java.time.LocalDate;

@Entity
@Table(name = "pasajero")
@Data
public class Pasajero {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_pasajero")
    private Long idPasajero;

    @NotBlank(message = "El nombre completo es obligatorio")
    @Column(name = "nombre_completo")
    private String nombreCompleto;

    @NotNull(message = "La fecha de nacimiento es obligatoria")
    @Column(name = "fecha_nacimiento")
    private LocalDate fechaNacimiento;

    @NotBlank(message = "El número de pasaporte es obligatorio")
    @Column(name = "numero_pasaporte", unique = true)
    private String numeroPasaporte;
}