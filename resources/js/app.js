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

window.modalShow = function modalShow(title, description, type, fn = null) {
  const modal = new bootstrap.Modal(modalInfo);
  const modalData = {
    type: {
      danger: {
        classButton: 'btn-danger',
      },
      confirm: {
        classButton: 'btn-primary',
      },
    },
  };
  let modalTitle = modalInfo.querySelector('.modal-title');
  let modalBody = modalInfo.querySelector('.modal-body');
  let modalButton = modalInfo.querySelector('#modalConfirm');
  modalButton.addEventListener('click', (e) => {
    modal.hide();
    if (typeof fn == 'function') {
      fn(e);
    }
  });
  let classButtons = Object.keys(modalData.type).map(
    (type) => modalData.type[type].classButton,
  );
  modalTitle.innerText = title;
  modalBody.innerText = description;
  classButtons.map((classButton) => {
    modalButton.classList.remove(classButton);
  });
  modalButton.classList.add(modalData.type[type].classButton);
  modal.show();
};

// Tem filhos
(() => {
  const temFilhos = document.querySelectorAll('input[name="temFilhos"]');
  if (temFilhos) {
    temFilhos.forEach((el) => {
      if (el.checked && el.value == '0') {
        document.querySelector('#filhosQt').closest('div').style.display =
          'none';
      }
    });
    temFilhos.forEach((el) =>
      el.addEventListener('change', function (e) {
        console.log(this.value);
        if (this.value == '0') {
          document.querySelector('#filhosQt').closest('div').style.display =
            'none';
        } else {
          document.querySelector('#filhosQt').closest('div').style.display =
            'block';
        }
      }),
    );
  }
})();
