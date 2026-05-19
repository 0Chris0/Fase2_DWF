package com.aerolinea.proyecto.models;

import jakarta.persistence.*;
import lombok.Data;

@Entity
@Table(name = "rol")
@Data
public class Rol {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_rol")
    private Long idRol;

    @Column(unique = true, nullable = false)
    private String nombre; // Ejemplo: "ADMIN", "USER"
}
