package com.aerolinea.proyecto.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository; // <-- OJO CON ESTA IMPORTACIÓN
import com.aerolinea.proyecto.models.Rol;
import java.util.Optional;

@Repository // <-- ESTA ANOTACIÓN ES OBLIGATORIA PARA QUE SPRING ENCUENTRE EL BEAN
public interface RolRepository extends JpaRepository<Rol, Long> {
    Optional<Rol> findByNombre(String nombre);
}