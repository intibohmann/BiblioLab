<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <?php include("head.php"); ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<?php include("Menu.php"); ?>
<body>
    <header>
        <h1>Sobre a Biblioteca</h1>
    </header>
    <main>
        <section>
            <h2>O Projeto PPO - Biblioteca Dirigida</h2>
            <p>Projeto de PPO desenvolvido por Inti e Emanoel, a Biblioteca Dirigida é uma plataforma inteligente voltada para o apoio a estudos dirigidos, com foco em recomendações personalizadas de materiais educacionais como livros, vídeos e artigos.</p>
            <p>A proposta do projeto é criar uma biblioteca digital inteligente que auxilie estudantes a encontrar conteúdos relevantes, confiáveis e de qualidade. O sistema será capaz de sugerir materiais de estudo com base no perfil e nos interesses do usuário, utilizando algoritmos de recomendação, além de contar com avaliações e feedbacks da comunidade para qualificar ainda mais as indicações.</p>
            <p>Em uma era com excesso de informações, encontrar bons conteúdos pode ser uma tarefa difícil. O projeto busca solucionar isso, facilitando o acesso a materiais organizados, relevantes e aprofundados, promovendo a autonomia e a criatividade no processo de aprendizagem.</p>
            <p>A Biblioteca Dirigida é uma ferramenta inovadora que visa transformar a forma como os estudantes acessam e consomem conhecimento, tornando o aprendizado mais eficiente e prazeroso.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> PPO - Biblioteca Dirigida. Todos os direitos reservados.</p>
    </footer>
</body>
</html>