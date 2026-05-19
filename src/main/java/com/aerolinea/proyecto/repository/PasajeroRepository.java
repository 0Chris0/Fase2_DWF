package com.aerolinea.proyecto.repository;

import com.aerolinea.proyecto.models.Pasajero;
import org.springframework.data.jpa.repository.JpaRepository;

public interface PasajeroRepository extends JpaRepository<Pasajero, Long> {

}
