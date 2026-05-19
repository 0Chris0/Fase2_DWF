package com.aerolinea.proyecto.models;

import jakarta.persistence.*;
import lombok.Data;
import java.time.LocalDate;

@Entity
@Table(name = "reserva")
@Data
public class Reserva {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_reserva")
    private Long idReserva;

    // Le quitamos las validaciones estrictas de Jakarta para que no rebote el Error 400
    @Column(name = "fecha_reserva")
    private LocalDate fechaReserva;

    @Column(name = "estado")
    private String estado;

    @Column(name = "id_pasajero")
    private Long idPasajero;

    @Column(name = "id_vuelo")
    private Long idVuelo;
}