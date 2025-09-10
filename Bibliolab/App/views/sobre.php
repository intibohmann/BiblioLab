<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0dcaf0, #000000ff);
            color: #fff;
            animation: fadeIn 1.5s ease-in-out;
        }
        header {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            animation: slideDown 1s ease-in-out;
        }
        header h1 {
            font-size: 2.5em;
            margin: 0;
            color: #fff;
        }
        main {
            padding: 20px;
            animation: fadeIn 2s ease-in-out;
        }
        section {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            animation: zoomIn 1.5s ease-in-out;
        }
        section h2 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #fff;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: rgba(0, 0, 0, 0.3);
            position: fixed;
            bottom: 0;
            width: 100%;
            animation: fadeIn 2s ease-in-out;
        }
        p {
            color: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <header>
        <h1>Sobre a Biblioteca Dirigida</h1>
    </header>
    <main>
        <section>
            <h2>Bem-vindo!</h2>
            <p>A Biblioteca Dirigida é uma plataforma criada para facilitar o acesso a materiais educacionais de qualidade. Nosso objetivo é ajudar estudantes a encontrar livros, vídeos e artigos relevantes para seus estudos, utilizando recomendações personalizadas e avaliações da comunidade.</p>
            <p>O projeto foi desenvolvido por Inti e Emanoel como parte do PPO, buscando promover autonomia, criatividade e eficiência no aprendizado.</p>
            <p>Explore, aprenda e compartilhe conhecimento com a gente!</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PPO - Biblioteca Dirigida. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
