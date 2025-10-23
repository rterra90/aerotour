/* eslint-disable no-undef */
/* eslint-disable @typescript-eslint/no-unused-vars */
function fetchAdminAPI(action, _data, _success, type = 'POST') {
  jQuery(function ($) {
    $.ajax({
      url: ajax_url,
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

function adminApiFetch(action, _data, _success, type = 'POST') {
  jQuery(function ($) {
    $.ajax({
      url: ajax_url,
      type: type,
      data: { action: action, ..._data },
      success: async function ({ success, data }) {
        _success(success, data);
      },
      error: async function (error) {
        console.log(error);
      },
    });
  });
}
