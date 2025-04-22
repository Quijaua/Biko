import './handleFIlters.js';

$(document).ready(function () {
  $('.open-modal-btn').click(function () {
    $('#modalOverlay').css('display', 'flex').fadeIn();

    if ($(this).attr('id') === 'modal-importar-alunos') {
      const formModal = $('#modalOverlay').find('form');
      formModal.attr('action', $(this).data('url'));
    }
  });

  $('#closeModal, #modalOverlay').click(function (e) {
    if (e.target.id === 'modalOverlay' || e.target.id === 'closeModal') {
      $('#modalOverlay').fadeOut();
    }
  });
});
