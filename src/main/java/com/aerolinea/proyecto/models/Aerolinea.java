package com.aerolinea.proyecto.models;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Entity
@Table(name = "aerolinea")
@Data
public class Aerolinea {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_aerolinea")
    private Long idAerolinea;

    @NotBlank(message = "El nombre de la aerolínea es obligatorio")
    @Column(name = "nombre_aerolinea")
    private String nombreAerolinea;

    @NotBlank(message = "El país de origen es obligatorio")
    @Column(name = "pais_origen")
    private String paisOrigen;
}