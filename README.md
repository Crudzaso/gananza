# 📱 Gananza

## 🌟 Visión
**Gananza** busca convertirse en la plataforma líder para la organización y participación en rifas, ofreciendo una experiencia segura, intuitiva y accesible para todos los usuarios. Nuestra visión es facilitar el acceso a rifas en cualquier formato, ya sea virtual, presencial o híbrido, promoviendo la interacción y el entretenimiento.

## 🎯 Misión
Nuestra misión es empoderar a los organizadores de rifas y a los participantes al proporcionar una plataforma confiable que simplifique la creación, gestión y participación en rifas. Queremos que cada usuario tenga una experiencia sin fricciones, donde pueda concentrarse en lo que realmente importa: la emoción de ganar.

## 📅 Objetivos

### A Corto Plazo (0-6 meses)
- Lanzar la plataforma con funciones básicas como creación de rifas y compra de tickets.
- Implementar un sistema de autenticación seguro para usuarios.
- Garantizar la legalidad de las rifas a través de verificaciones y requisitos establecidos.

### A Mediano Plazo (6-12 meses)
- Ampliar las funcionalidades de la plataforma, incluyendo la integración de pagos y notificaciones.
- Introducir rifas híbridas y facilitar la participación de usuarios no registrados.
- Iniciar campañas de marketing para atraer a organizadores y participantes.

### A Largo Plazo (1-3 años)
- Expandir la plataforma a nivel internacional, permitiendo rifas en diferentes países.
- Implementar características avanzadas como gamificación y análisis de datos para mejorar la experiencia del usuario.
- Explorar la integración de tecnologías innovadoras, como blockchain, para mayor transparencia y seguridad en las transacciones.

## 🛠️ Guía de Instalación y Configuración

### Requisitos Previos
- PHP ^8.2
- Composer
- Node.js y npm
- MySQL

### Pasos de Instalación

1. **Clonar el Repositorio**
   ```bash
   git clone https://github.com/Crudzaso/gananza.git
   cd gananza
   ```

2. **Instalar Dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configuración del Entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar Base de Datos**
   Edita el archivo `.env` con tus credenciales de base de datos:
   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gananzaapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Ejecutar Migraciones**
   ```bash
   php artisan migrate
   ```

6. **Iniciar el Servidor**
   Abre dos terminales y ejecuta:
   ```bash
   # Terminal 1
   php artisan serve

   # Terminal 2
   npm run dev
   ```

7. **Acceder a la Aplicación**
   Visita [http://127.0.0.1:8000](http://127.0.0.1:8000) en tu navegador.

### Dependencias Principales
   ```json
   {
       "php": "^8.2",
       "inertiajs/inertia-laravel": "^1.0",
       "laravel/framework": "^11.9",
       "laravel/jetstream": "^5.3",
       "laravel/sanctum": "^4.0",
       "laravel/tinker": "^2.9",
       "tightenco/ziggy": "^2.0"
   }
   ```

## 🚀 Únete a la Aventura
¡Te invitamos a ser parte de Gananza! Ya seas un organizador de rifas o un entusiasta de la suerte, aquí encontrarás un espacio para hacer realidad tus sueños.

Para más información y detalles técnicos, puedes consultar la [documentación completa](https://www.notion.so/General-Documentation-Mi-Rifa-12a84226c7a480448ff5e71fc322215c?pvs=21).

---

## 👨‍💻 Equipo de Desarrollo
- **Alejandro Velasquez** (Fullstack)
- **Diego Ramirez** (Fullstack)
- **Jafet Lozano** (Fullstack)
