/* eslint-disable no-undef */
/* eslint-disable @typescript-eslint/no-unused-vars */
function fetchAdminAPI(action, _data, _success, type = 'POST') {
  jQuery(function ($) {
    $.ajax({
      url: theme_links.adminAjaxUrl,
      type: type,
      data: {
        action: action,
        data: _data,
      },
      success: async function ({ success, data }) {
        _success(success, data);
      },
      error: async function (error) {
        console.log(error);
      },
    });
  });
}

//FUNÇÃO APRIMORADA
function adminApiFetch(action, data = {}, callback = () => {}, type = 'POST') {
  // Garantir que o jQuery já esteja disponível
  if (typeof jQuery === 'undefined') {
    console.error('jQuery não carregado.');
    callback(false, { message: 'Erro interno: jQuery não disponível.' });
    return;
  }

  jQuery(function ($) {
    $.ajax({
      url: theme_links.adminAjaxUrl,
      type: type,
      dataType: 'json',
      data: {
        action,
        _ajax_nonce: window?.wpApiSettings?.nonce || null, // inclui nonce se disponível
        ...data,
      },
      success: function (response) {
        // Garante estrutura esperada do retorno
        const isSuccess = !!response?.success;
        const payload = response?.data || null;
        callback(isSuccess, payload);
      },
      error: function (xhr, status, errorThrown) {
        console.error('Erro na requisição AJAX:', status, errorThrown);
        callback(false, {
          message: 'Erro de comunicação com o servidor.',
          status,
          errorThrown,
          responseText: xhr?.responseText || null,
        });
      },
      timeout: 15000, // 15 segundos de limite (evita hang)
    });
  });
}
