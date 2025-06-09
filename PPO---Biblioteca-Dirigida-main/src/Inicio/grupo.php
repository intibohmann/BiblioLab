<?php include("head.php")?>
<body>
    <?php include("menuB.php")?>
    <h1 style="margin-left: 200px; font-size: 50px;">Introdução:</h1>
    <h2 style="margin-left: 240px;"class="subtitle">
        Aqui você encontrará os mais diversos materiais, visando compreender como funciona e porque funciona um submarino.<br> Além de compreender o papel, engenharia e história que perpassa pelo tema de Submarino. Bons estudos!
    </h2>

    <br>
    <h1 style="margin-left: 200px; font-size: 50px;">Videos:</h1>

    <div class="carousel" id="carousel-videos">
        <div class="carousel-item active">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/EuhCLYb1Gl4?si=IMRme3LEVXotvxSy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="carousel-item">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/YPY76vB6BB8?si=jPoqQVfv0YGQkGDu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="carousel-item">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/EEuh3-HuYVU?si=vONjQ79PbmSd3XIt" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="carousel-item">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/zycu_yDCqTE?si=NnmgPXSWzqpBUxa0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="carousel-item">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/7bAaBL6CKV4?si=StwxSix27qoJBpkR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="carousel-control carousel-control-prev" onclick="prevSlide('carousel-videos')">&#10094;</div>
        <div class="carousel-control carousel-control-next" onclick="nextSlide('carousel-videos')">&#10095;</div>
    </div>

    <script>
        function showSlide(carouselId, index) {
            const items = document.querySelectorAll(`#${carouselId} .carousel-item`);
            items.forEach((item, i) => {
                item.classList.toggle('active', i === index);
            });
        }

        function nextSlide(carouselId) {
            const items = document.querySelectorAll(`#${carouselId} .carousel-item`);
            let currentIndex = [...items].findIndex(item => item.classList.contains('active'));
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(carouselId, currentIndex);
        }

        function prevSlide(carouselId) {
            const items = document.querySelectorAll(`#${carouselId} .carousel-item`);
            let currentIndex = [...items].findIndex(item => item.classList.contains('active'));
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            showSlide(carouselId, currentIndex);
        }


        showSlide('carousel-videos', 0); 
    </script>

    <br>
    <h1 style="margin-left: 200px; font-size: 50px;">Artigos/documentos:</h1>

    <div class="carousel" id="carousel-documents">
        <div class="carousel-item active">
            <div class="document-content">
                <a href="https://doi.org/10.1590/S0102-85292011000200002">O projeto do submarino nuclear brasileiro</a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="document-content">
                <a href="https://core.ac.uk/download/pdf/287360724.pdf">A engenharia mecânica na concepção de um submarino</a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="document-content">
                <a href="https://acervo-digital.espm.br/Artigos/Estudos%20de%20caso/2010/10%20-%20Submarino.com%20(A)%20801350-PDF-ENG.pdf">Submarino.com (A)</a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="document-content">
                <a href="https://www.scielo.br/j/rbef/a/ZcVPW9SKk5xMkCmnVqw7ztb/?lang=pt&format=html">Ludião versus princípio do submarino</a>
            </div>
        </div>
        <div class="carousel-item">
            <div class="document-content">
                <a href="https://www.proquest.com/openview/6c4a5fd132736a176d20015c37d2a098/1?pq-origsite=gscholar&cbl=2026366&diss=y">Escape livre submarino</a>
            </div>
        </div>
        <div class="carousel-control carousel-control-prev" onclick="prevSlide('carousel-documents')">&#10094;</div>
        <div class="carousel-control carousel-control-next" onclick="nextSlide('carousel-documents')">&#10095;</div>
    </div>

    <script>
        showSlide('carousel-documents', 0); 
    </script>

    <br><br>

</body>
</html>
