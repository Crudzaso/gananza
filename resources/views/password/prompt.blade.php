<form method="POST" action="{{ route('password.verify') }}">
    @csrf
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Verificar</button>
</form>
