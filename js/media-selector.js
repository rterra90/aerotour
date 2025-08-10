jQuery(document).ready(function ($) {
  var file_frame;

  $(document).on('click', '.media-selector', function (e) {
    e.preventDefault();

    var target = $(this).data('target');

    // Se o frame já existe, abra-o novamente.
    if (file_frame) {
      file_frame.open();
      file_frame.target = target;
      return;
    }

    // Cria o frame de seleção de mídia.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: 'Selecione uma Imagem',
      button: {
        text: 'Usar esta imagem',
      },
      multiple: false,
    });

    // Quando uma imagem é selecionada, execute esta função.
    file_frame.on('select', function () {
      var attachment = file_frame.state().get('selection').first().toJSON();
      $('#' + file_frame.target + '_id').val(attachment.id);
      $('#' + file_frame.target + '_preview').attr('src', attachment.url);
    });

    file_frame.target = target;

    // Finalmente, abra o modal.
    file_frame.open();
  });
});
