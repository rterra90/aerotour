function insertReloadAlert() {
  const detalhesGateway = document.querySelector('.detalhes-gateway');
  const detalhesGatewayRef = document.querySelector('.mp-details-pix');
  const alertaHeader = document.createElement('div');
  alertaHeader.innerHTML =
    '<p class="alerta-refresh-header">Após o pagamento, <span role="button" onclick="window.location.reload();">atualize esta página</span> ou acesse sua área de pedidos para verificar o status do pedido.</p>';
  detalhesGateway.insertBefore(alertaHeader, detalhesGatewayRef);
}
