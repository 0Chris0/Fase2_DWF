package com.aerolinea.proyecto.controllers;

import com.aerolinea.proyecto.dto.LoginRequestDTO;
import com.aerolinea.proyecto.dto.JwtResponseDTO;
import com.aerolinea.proyecto.dto.RegisterRequestDTO; // Asegúrate de tener este DTO creado en tu carpeta dto
import com.aerolinea.proyecto.models.Usuario;
import com.aerolinea.proyecto.models.Rol;
import com.aerolinea.proyecto.repository.UsuarioRepository;
import com.aerolinea.proyecto.repository.RolRepository; // Tu interfaz corregida
import com.aerolinea.proyecto.security.JwtUtil;
import jakarta.validation.Valid;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;
import java.util.Map;

@RestController
@RequestMapping("/api/auth")
public class AuthController {

    private final UsuarioRepository usuarioRepository;
    private final RolRepository rolRepository; // Agregado para el registro de nuevos usuarios
    private final PasswordEncoder passwordEncoder;
    private final JwtUtil jwtUtil;

    // Constructor único actualizando todas las dependencias requeridas
    public AuthController(UsuarioRepository usuarioRepository, RolRepository rolRepository, PasswordEncoder passwordEncoder, JwtUtil jwtUtil) {
        this.usuarioRepository = usuarioRepository;
        this.rolRepository = rolRepository;
        this.passwordEncoder = passwordEncoder;
        this.jwtUtil = jwtUtil;
    }

    @PostMapping("/login")
    public ResponseEntity<?> login(@Valid @RequestBody LoginRequestDTO request) {
        // 1. Buscamos al usuario por su username
        Usuario usuario = usuarioRepository.findByUsername(request.getUsername())
                .orElseThrow(() -> new RuntimeException("El usuario ingresado no existe"));

        // 2. Validamos la contraseña encriptada
        if (!passwordEncoder.matches(request.getPassword(), usuario.getPassword())) {
            return ResponseEntity.status(HttpStatus.UNAUTHORIZED)
                    .body(Map.of("mensaje", "Contraseña de acceso incorrecta"));
        }

        // Extraemos la propiedad String 'nombre' desde la entidad relacionada Rol
        String nombreRol = usuario.getRol().getNombre();

        // 3. Generamos el token pasando el String del rol obtenido de la BD
        String token = jwtUtil.generateToken(usuario.getUsername(), nombreRol);

        // 4. Retornamos la respuesta mapeada con el DTO estructurado
        JwtResponseDTO response = new JwtResponseDTO(
                token,
                "Bearer",
                usuario.getUsername(),
                nombreRol,
                usuario.getNombre()
        );

        return ResponseEntity.ok(response);
    }

    @PostMapping("/register")
    public ResponseEntity<?> register(@Valid @RequestBody RegisterRequestDTO request) {
        // 1. Validar que el username no esté duplicado en la base de datos
        if (usuarioRepository.findByUsername(request.getUsername()).isPresent()) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST)
                    .body(Map.of("mensaje", "El nombre de usuario ya está en uso"));
        }

        // 2. Buscar la entidad del Rol por defecto 'USER' usando tu RolRepository (interfaz)
        Rol rolUsuario = rolRepository.findByNombre("USER")
                .orElseThrow(() -> new RuntimeException("Error crítico: El rol USER no se encuentra configurado en la base de datos"));

        // 3. Construir la entidad Usuario mapeando los datos del DTO y codificando la contraseña
        Usuario nuevoUsuario = new Usuario();
        nuevoUsuario.setNombre(request.getNombre());
        nuevoUsuario.setEmail(request.getEmail());
        nuevoUsuario.setUsername(request.getUsername());
        nuevoUsuario.setPassword(passwordEncoder.encode(request.getPassword())); // Encriptación obligatoria con BCrypt
        nuevoUsuario.setRol(rolUsuario); // Asignación de la entidad del rol

        // 4. Persistir el nuevo registro en la base de datos
        usuarioRepository.save(nuevoUsuario);

        return ResponseEntity.ok(Map.of("mensaje", "Usuario registrado exitosamente bajo el rol USER"));
    }
}