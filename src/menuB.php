<?php include("head.php"); ?>
<!-- Navbar -->
<?php include("menu.php"); ?> 
<!-- Menu de Botões -->
<section class="bg-gray-100 py-16 mt-16">
  <div class="container mx-auto">
    <div class="flex justify-center">
      <div class="text-center space-y-4">
        <a href="grupo.php" class="bg-[#6a11cb] text-white px-6 py-3 rounded-full text-lg shadow-lg hover:bg-blue-700 transition transform hover:scale-105 animate-bounce">Material da Biblioteca</a>
        <a href="chat.php" class="bg-[#6a11cb] text-white px-6 py-3 rounded-full text-lg shadow-lg hover:bg-blue-700 transition transform hover:scale-105 animate-bounce">Chat da Biblioteca</a>
      </div>
    </div>
  </div>
</section>

<style>
@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}
.animate-bounce {
  animation: bounce 1.5s infinite;
}
</style>
</style>
