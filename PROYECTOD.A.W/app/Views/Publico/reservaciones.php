<style>
    .card {
        max-width: 320px;
        border-width: 1px;
        border-color: rgba(219, 234, 254, 1);
        border-radius: 1rem;
        background-color: rgba(255, 255, 255, 1);
        padding: 1rem;
    }

    .header {
        display: flex;
        align-items: center;
        grid-gap: 1rem;
        gap: 1rem;
    }

    .icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
        background-color: rgba(96, 165, 250, 1);
        padding: 0.5rem;
        color: rgba(255, 255, 255, 1);
    }

    .icon svg {
        height: 1rem;
        width: 1rem;
    }

    .alert {
        font-weight: 600;
        color: rgba(107, 114, 128, 1);
    }

    .message {
        margin-top: 1rem;
        color: rgba(107, 114, 128, 1);
    }

    .actions {
        margin-top: 1.5rem;
    }

    .actions a {
        text-decoration: none;
    }

    .mark-as-read,
    .read {
        display: inline-block;
        border-radius: 0.5rem;
        width: 100%;
        padding: 0.75rem 1.25rem;
        text-align: center;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 600;
    }

    .read {
        background-color: rgba(59, 130, 246, 1);
        color: rgba(255, 255, 255, 1);
    }

    .mark-as-read {
        margin-top: 0.5rem;
        background-color: rgba(249, 250, 251, 1);
        color: rgba(107, 114, 128, 1);
        transition: all .15s ease;
    }

    .mark-as-read:hover {
        background-color: rgb(230, 231, 233);
    }
</style>
<img src="\icons\logo.png" width="300" style="position:absolute;left:790px">
<div class="card" style="position:absolute; top:35%;left:41%">
    <div class="header">
        <span class="icon">
            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                    d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"
                    fill-rule="evenodd"></path>
            </svg>
        </span>
        <h5>Registrarse</h5>
        
    </div>

    <p class="message">
        Para poder hacer una reservación debes crear una cuenta de usuario, puedes crear una dando clic en el
        siguiente botón:
    </p>

    <div class="actions">
        <a class="read" href="/registrar">
            <strong style="font-size:25px">+</strong> Registrarse
        </a>
        <a href="/" class="mark-as-read">Tengo una cuenta, iniciar sesión</a>
    </div>
</div>