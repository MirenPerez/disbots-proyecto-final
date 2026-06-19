<?php require_once 'header.php'; ?>
<main class="contenedor form-page">
    <h1>Contacto</h1>
    <p>Solicita un bot personalizado para tu servidor.</p>
    <form id="formContacto" class="formulario">
        <label>Nombre</label><input type="text" id="contactoNombre" required>
        <label>Email</label><input type="email" id="contactoEmail" required>
        <label>Mensaje</label><textarea id="contactoMensaje" required></textarea>
        <button type="submit" class="btn">Enviar</button>
    </form>
    <div id="mensajeContacto"></div>
</main>
<?php require_once 'footer.php'; ?>
