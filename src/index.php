<?php include('head.php'); ?>
<style>
    :root {
        --primary-purple: #7C3AED;
        --primary-purple-dark: #5B21B6;
        --secondary-purple: #A78BFA;
        --background: #181825;
        --white: #232136;
        --gray-light: #2a273f;
        --gray: #393552;
        --text: #e0def4;
        --navbar-bg: #7C3AED;
        --navbar-text: #fff;
    }
    body {
        background: var(--background);
        min-height: 100vh;
        color: var(--text);
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .navbar {
        width: 100%;
        background: var(--navbar-bg);
        color: var(--navbar-text);
        padding: 18px 0;
        margin-bottom: 32px;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.15);
        font-size: 1.2rem;
        font-weight: 600;
        text-align: center;
        letter-spacing: 1px;
    }
    .main-content-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .container {
        background: var(--white);
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(124, 58, 237, 0.10);
        padding: 40px 30px;
        max-width: 900px;
        width: 100%;
        border: 1.5px solid var(--secondary-purple);
    }
    .columns {
        display: flex;
        gap: 40px;
        justify-content: center;
    }
    .column {
        flex: 1;
        padding: 0 10px;
    }
    .list-item {
        margin-bottom: 15px;
        padding: 12px;
        border: 1px solid var(--gray);
        border-radius: 10px;
        background: var(--gray-light);
        transition: box-shadow 0.2s, border-color 0.2s;
        color: var(--text);
    }
    .list-item:hover {
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.12);
        border-color: var(--primary-purple);
    }
    .button-container {
        margin-top: 10px;
    }
    .button-container button {
        margin-right: 5px;
    }
    .title {
        margin-bottom: 20px;
        text-align: center;
        color: var(--primary-purple);
        font-weight: 700;
    }
    .list {
        padding: 0;
        list-style: none;
    }
    .button {
        padding: 7px 18px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }
    .button.is-primary {
        background: var(--primary-purple);
        color: var(--white);
    }
    .button.is-primary:hover {
        background: var(--primary-purple-dark);
    }
    .button.is-danger {
        background: #F87171;
        color: var(--white);
    }
    .button.is-danger:hover {
        background: #DC2626;
    }
    .button.is-info {
        background: var(--secondary-purple);
        color: var(--primary-purple-dark);
    }
    .button.is-info:hover {
        background: var(--primary-purple);
        color: var(--white);
    }
</style>
<body>
<div class="navbar">
    Biblioteca Dirigida
</div>
<?php include('Menu.php'); ?>
<div class="main-content-wrapper">
    <div class="container">
        <div class="columns">

            <div class="column is-half">
                <h2 class="title is-4">Biblioteca Dirigidas</h2>
                <ul id="lista-biblioteca" class="list">
                    <li class="list-item">
                        <div class="is-flex is-justify-content-space-between">
                            <span>Biblioteca: Submarinos</span>
                            <button class="button is-primary" onclick="moverItemParaParticipar('Submarinos')">Participar</button>
                        </div>
                    </li>
                    <li class="list-item">
                        <div class="is-flex is-justify-content-space-between">
                            <span>Biblioteca: Ciências</span>
                            <button class="button is-primary" onclick="moverItemParaParticipar('Ciências')">Participar</button>
                        </div>
                    </li>
                    <li class="list-item">
                        <div class="is-flex is-justify-content-space-between">
                            <span>Biblioteca: Literatura</span>
                            <button class="button is-primary" onclick="moverItemParaParticipar('Literatura')">Participar</button>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="column is-half">
                <h2 class="title is-4">Bibliotecas Participando</h2>
                <ul id="lista-participando" class="list">

                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function moverItemParaParticipar(biblioteca) {
        const listaParticipando = document.getElementById('lista-participando');
        const novoItem = document.createElement('li');
        novoItem.classList.add('list-item');
        novoItem.innerHTML = `<div class="is-flex is-justify-content-space-between">
                <span>${biblioteca}</span>
                <div class="button-container">
                    <button class="button is-danger" onclick="moverItemDeVolta('${biblioteca}')">Deixar de Participar</button>
                    <button class="button is-info" onclick="entrarNoGrupo()">Entrar</button>
                </div>
            </div>`;
        listaParticipando.appendChild(novoItem);

        const listaBiblioteca = document.getElementById('lista-biblioteca');
        const itens = listaBiblioteca.getElementsByTagName('li');
        for (let item of itens) {
            if (item.innerText.includes(biblioteca)) {
                listaBiblioteca.removeChild(item);
                break;
            }
        }
    }

    function moverItemDeVolta(biblioteca) {
        const listaBiblioteca = document.getElementById('lista-biblioteca');
        const novoItem = document.createElement('li');
        novoItem.classList.add('list-item');
        novoItem.innerHTML = `<div class="is-flex is-justify-content-space-between">
                <span>${biblioteca}</span>
                <button class="button is-primary" onclick="moverItemParaParticipar('${biblioteca}')">Participar</button>
            </div>`;
        listaBiblioteca.appendChild(novoItem);

        const listaParticipando = document.getElementById('lista-participando');
        const itens = listaParticipando.getElementsByTagName('li');
        for (let item of itens) {
            if (item.innerText.includes(biblioteca)) {
                listaParticipando.removeChild(item);
                break;
            }
        }
    }

    function entrarNoGrupo() {
        window.location.href = 'grupo.php'; 
    }
</script>

<?php include("rodape.php");  ?>
</body>
</html>
