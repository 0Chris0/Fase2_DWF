package com.aerolinea.proyecto.repository;
import org.springframework.data.jpa.repository.JpaRepository;
import com.aerolinea.proyecto.models.*;
import java.util.Optional;

public interface UsuarioRepository extends JpaRepository<Usuario, Long> {
    Optional<Usuario> findByUsername(String username);
}

public interface AerolineaRepository extends JpaRepository<Aerolinea, Long> {}

public interface PasajeroRepository extends JpaRepository<Pasajero, Long> {}

public interface VueloRepository extends JpaRepository<Vuelo, Long> {}

public interface ReservaRepository extends JpaRepository<Reserva, Long> {}

public interface PagoRepository extends JpaRepository<Pago, Long> {}