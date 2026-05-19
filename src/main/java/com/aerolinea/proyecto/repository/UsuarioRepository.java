package com.aerolinea.proyecto.repository;
import org.springframework.data.jpa.repository.JpaRepository;
import com.aerolinea.proyecto.models.*;
import java.util.Optional;

public interface UsuarioRepository extends JpaRepository<Usuario, Long> {
    Optional<Usuario> findByUsername(String username);
}
