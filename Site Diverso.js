function moverElemento() {
  const elemento = document.getElementById('elementoJS');
  let posicao = 0;
  const intervalo = setInterval(frame, 10);

  function frame() {
    if (posicao == 200) {
      clearInterval(intervalo);
    } else {
      posicao++;
      elemento.style.transform = `translateX(${posicao}px)`;
    }
  }
}

function enableSubmit() {
    // Esta função é chamada automaticamente pelo reCAPTCHA 
    // quando o usuário prova que não é um robô.
    document.getElementById('submitButton').disabled = false;
    console.log("reCAPTCHA concluído, botão de envio ativado.");