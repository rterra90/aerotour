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

  function update_reserva(res_id, _action, updateReservaDom) {
    const postData = {
      action: 'update_reserva',
      to: _action,
      res_id: res_id,
    };
    adminFetch(postData, 'POST', (data) => {
      updateReservaDom(data[0], res_id);
    });
  }

  return {
    get_reservas,
    update_reserva,
  };
};

export default useAdminAjax;
