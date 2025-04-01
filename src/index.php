<?php include('head.php'); ?>
    <style>
        .column {
            padding: 20px;
        }
        .list-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .button-container {
            margin-top: 10px;
        }
        .button-container button {
            margin-right: 5px;
        }
        .title {
            margin-bottom: 20px;
        }
        .list {
            padding: 0;
        }
    </style>
<body>
<?php include('menu.php'); ?>

  <section class="section1">
    <h1 class="title">Bibliotecas</h1>
    <h2 class="subtitle">
      Aqui você encontrará bibliotecas dirigidas de diversos assuntos, como também as que você já participa!<br> Fique à vontade para participar de quantas bibliotecas você quiser, e caso queira pode sair de bibliotecas que já participa. <br> Se divirta!
    </h2>
    <br>
  </section>

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
