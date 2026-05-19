package com.aerolinea.proyecto.repository;

import com.aerolinea.proyecto.models.Reserva;
import org.springframework.data.jpa.repository.JpaRepository;
import java.util.Optional;

public interface ReservacionRepository extends JpaRepository<Reserva, Long> {

    // Al declarar esto aquí, Spring Boot creará la consulta SQL automáticamente
    Optional<Reserva> findFirstByOrderByIdReservaDesc();
}