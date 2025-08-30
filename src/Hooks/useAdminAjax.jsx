const useAdminAjax = (adminAjaxUrl) => {
  function adminFetch(data, ajaxType = 'GET', ajaxSuccess) {
    // eslint-disable-next-line no-undef
    jQuery(function ($) {
      $.ajax({
        url: adminAjaxUrl,
        type: ajaxType,
        data: data,
        success: async function (response) {
          ajaxSuccess(response.data);
        },
        error: function (error) {
          console.log('response error:  ' + error);
        },
      });
    });
  }

  function get_reservas(setReservas, setExcDetails) {
    function success(data) {
      setReservas(data[0].reverse());

      setExcDetails(data[1]);
    }
    adminFetch({ action: 'get_reservas' }, 'GET', success);
  }

  function update_reserva(res_id, _action, setUpdateDone) {
    const postData = {
      action: 'update_reserva',
      to: _action,
      res_id: res_id,
    };
    adminFetch(postData, 'POST', (data) => {
      // Atualiza as novas informações no DOM
      const domElement = document.querySelector(
        `tr[data-reserva-id="${res_id}"]`,
      );
      if (domElement) {
        domElement.querySelector('td[data-coluna="status"]').innerText =
          data[0].status;
        domElement.querySelector('td[data-coluna="embarque"]').innerText =
          data[0].embarque;
        domElement.querySelector('td[data-coluna="horario"]').innerText =
          data[0].horario.substring(0, 5);
      }
      setUpdateDone(_action);
    });
  }

  return {
    get_reservas,
    update_reserva,
  };
};

export default useAdminAjax;
