const chatBody = document.getElementById("chat-body");

let historico = [];

// Função para formatar Markdown básico
function formatarMarkdown(texto) {
  return texto
    .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>")
    .replace(/\*(.*?)\*/g, "<i>$1</i>")
    .replace(/`(.*?)`/g, "<code>$1</code>")
    .replace(/\n/g, "<br>");
}

// Função para adicionar mensagens no chat
function adicionarMensagem(texto, tipo, loading = false) {
  const msg = document.createElement("div");
  msg.classList.add("chat-message", tipo === "user" ? "user-message" : "bot-message");
  msg.innerHTML = loading ? `<span class="loading">Gerando resposta...</span>` : formatarMarkdown(texto);
  chatBody.appendChild(msg);
  chatBody.scrollTop = chatBody.scrollHeight;
  return msg;
}

// Bot já se apresenta sozinho ao carregar a página
window.onload = () => {
  const msg = "Olá! Eu sou o **Pingo**, seu assistente virtual 😃 Como posso ajudar hoje?";
  adicionarMensagem(msg, "bot");
  historico.push({ role: "model", parts: [{ text: msg }] });
};

// Função principal de envio de mensagens
async function perguntar() {
  const input = document.getElementById("pergunta");
  const pergunta = input.value.trim();
  if (!pergunta) return;

  adicionarMensagem(pergunta, "user");
  historico.push({ role: "user", parts: [{ text: pergunta }] });
  input.value = "";

  const loadingMsg = adicionarMensagem("", "bot", true);

  try {
    const response = await fetch("api.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ historico })
    });
    const data = await response.json();
    let resposta = data.candidates?.[0]?.content?.parts?.[0]?.text || "Não consegui responder.";

    historico.push({ role: "model", parts: [{ text: resposta }] });

    // Animação "digitando"
    loadingMsg.innerHTML = "";
    let i = 0;
    function digitar() {
      if (i < resposta.length) {
        loadingMsg.innerHTML += resposta[i] === "\n" ? "<br>" : resposta[i];
        i++;
        chatBody.scrollTop = chatBody.scrollHeight;
        setTimeout(digitar, 20);
      }
    }
    digitar();
  } catch (e) {
    loadingMsg.innerHTML = "Erro ao obter resposta.";
  }
}
