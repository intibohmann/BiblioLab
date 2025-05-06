<?php include("head.php") ?>
<body class="bg-gray-100 text-gray-800">
    <?php include("menuB.php") ?>
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mt-8 ml-8">Introdução:</h1>
        <h2 class="text-lg mt-4 ml-12 leading-relaxed">
            Aqui você encontrará os mais diversos materiais, visando compreender como funciona e porque funciona um submarino.<br>
            Além de compreender o papel, engenharia e história que perpassa pelo tema de Submarino. Bons estudos!
        </h2>

        <h1 class="text-4xl font-bold mt-12 ml-8">Vídeos:</h1>
        <div class="relative w-full max-w-3xl mx-auto mt-6">
            <div class="carousel" id="carousel-videos">
                <div class="carousel-item active">
                    <iframe class="w-full h-64 rounded-lg shadow-lg" src="https://www.youtube.com/embed/EuhCLYb1Gl4?si=IMRme3LEVXotvxSy" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="carousel-item">
                    <iframe class="w-full h-64 rounded-lg shadow-lg" src="https://www.youtube.com/embed/YPY76vB6BB8?si=jPoqQVfv0YGQkGDu" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                </div>
                <!-- Add more video items here -->
            </div>
            <button class="absolute top-1/2 left-0 transform -translate-y-1/2 text-2xl text-gray-600 hover:text-gray-800" onclick="prevSlide('carousel-videos')">&#10094;</button>
            <button class="absolute top-1/2 right-0 transform -translate-y-1/2 text-2xl text-gray-600 hover:text-gray-800" onclick="nextSlide('carousel-videos')">&#10095;</button>
        </div>

        <h1 class="text-4xl font-bold mt-12 ml-8">Artigos/Documentos:</h1>
        <div class="relative w-full max-w-3xl mx-auto mt-6">
            <div class="carousel" id="carousel-documents">
                <div class="carousel-item active">
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <a href="https://doi.org/10.1590/S0102-85292011000200002" class="text-blue-600 hover:underline">O projeto do submarino nuclear brasileiro</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <a href="https://core.ac.uk/download/pdf/287360724.pdf" class="text-blue-600 hover:underline">A engenharia mecânica na concepção de um submarino</a>
                    </div>
                </div>
                <!-- Add more document items here -->
            </div>
            <button class="absolute top-1/2 left-0 transform -translate-y-1/2 text-2xl text-gray-600 hover:text-gray-800" onclick="prevSlide('carousel-documents')">&#10094;</button>
            <button class="absolute top-1/2 right-0 transform -translate-y-1/2 text-2xl text-gray-600 hover:text-gray-800" onclick="nextSlide('carousel-documents')">&#10095;</button>
        </div>
    </div>

    <style>
        .carousel-item {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }

        .carousel-item.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

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
        showSlide('carousel-documents', 0);
    </script>

    <?php include("rodape.php"); ?>
</body>
</html>
