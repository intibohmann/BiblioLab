<?php include('head.php'); ?>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    body {
        font-family: Arial, sans-serif;
        background-color:rgb(255, 255, 255);
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .section1 {
        text-align: center;
        margin-bottom: 40px;
    }

    .title {
        font-size: 2.5rem;
        color: #4a4a4a;
    }

    .subtitle {
        font-size: 1.2rem;
        color: #7a7a7a;
    }

    .columns {
        display: flex;
        gap: 20px;
    }

    .column {
        flex: 1;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .list-item {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #fdfdfd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeIn 0.5s ease-in-out;
    }

    .button-container button {
        margin-right: 5px;
    }

    .button {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .button.is-primary {
        background-color: #3273dc;
        color: #fff;
    }

    .button.is-primary:hover {
        background-color: #275aa8;
    }

    .button.is-danger {
        background-color: #ff3860;
        color: #fff;
    }

    .button.is-danger:hover {
        background-color: #d32f45;
    }

    .button.is-info {
        background-color: #209cee;
        color: #fff;
    }

    .button.is-info:hover {
        background-color: #1778c4;
    }
</style>
<body>
<?php include('menu.php'); ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br><br>
<div class="container">
    <div class="columns">
        <div class="column">
            <h2 class="title is-4">Biblioteca Dirigidas</h2>
            <ul id="lista-biblioteca" class="list">
                <li class="list-item">
                    <span>Biblioteca: Submarinos</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Submarinos')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: Ciências</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Ciências')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: Literatura</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Literatura')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: Tecnologia</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Tecnologia')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: História</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('História')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: Matemática</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Matemática')">Participar</button>
                </li>
                <li class="list-item">
                    <span>Biblioteca: Física</span>
                    <button class="button is-primary" onclick="moverItemParaParticipar('Física')">Participar</button>
                </li>
            </ul>
        </div>

        <div class="column">
            <h2 class="title is-4">Bibliotecas Participando</h2>
            <ul id="lista-participando" class="list"></ul>
        </div>
    </div>
</div>

<script>
    function moverItemParaParticipar(biblioteca) {
        const listaParticipando = document.getElementById('lista-participando');
        const novoItem = document.createElement('li');
        novoItem.classList.add('list-item');
        novoItem.innerHTML = `
            <span>${biblioteca}</span>
            <div class="button-container">
                <button class="button is-danger" onclick="moverItemDeVolta('${biblioteca}')">Deixar de Participar</button>
                <button class="button is-info" onclick="entrarNoGrupo()">Entrar</button>
            </div>
        `;
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
        novoItem.innerHTML = `
            <span>${biblioteca}</span>
            <button class="button is-primary" onclick="moverItemParaParticipar('${biblioteca}')">Participar</button>
        `;
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
<?php include("rodape.php"); ?>
</body>
</html>
