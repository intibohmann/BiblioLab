function carregarMensagens(bibliotecaId) {
    fetch("chat_biblioteca.php?id=" + bibliotecaId)
        .then(r => r.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");
            document.getElementById("chatBox").innerHTML = doc.getElementById("chatBox").innerHTML;
            document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
        });
}

function iniciarChat(bibliotecaId) {
    document.getElementById("formChat").addEventListener("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch("chat_biblioteca.php?id=" + bibliotecaId, {
            method: "POST",
            body: formData
        }).then(() => {
            document.getElementById("mensagem").value = "";
            carregarMensagens(bibliotecaId);
        });
    });

    setInterval(() => carregarMensagens(bibliotecaId), 3000);
    carregarMensagens(bibliotecaId);
}
