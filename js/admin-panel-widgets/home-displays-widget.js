export class CardsLineElement {
  constructor(displayName, type, typeValue){
    this.displayName = displayName;
    this.type = type;
    this.typeValue = typeValue;
  }
  addElement(){
    const refNode = document.querySelector('#home_cards_widget .main-list > li:last-child');
    let newElement = refNode.cloneNode(true);

    //Ajusta o index
    const _index = +newElement.dataset.index + 1
    newElement.dataset.index = _index;
    newElement.querySelector('.type-select').dataset.index = _index;
    newElement.querySelector('.dashicons-trash').dataset.index = _index;

    //Ajusta o nome do display
    newElement.querySelector('input.cards-line-name').value = this.displayName;
    
    //Ajusta o tipo do display
    newElement.querySelector('.type-select').value = this.type; //ok
    if(this.type === 'proximas' || this.type === 'none'){
      newElement.querySelector('input[type="date"]').setAttribute('disabled', '');
      newElement.querySelector('select.cards-line-cat-select').setAttribute('disabled', '');
    }else if(this.type === 'categoria'){
       newElement.querySelector('select.cards-line-cat-select').removeAttribute('disabled');
       newElement.querySelector('input[type="date"]').setAttribute('disabled', '');
    }else if(this.type === 'apos-data'){
      newElement.querySelector('input[type="date"]').removeAttribute('disabled');
      newElement.querySelector('select.cards-line-cat-select').setAttribute('disabled', '');
    } 

    //Ajusta o input de data para o padrão
    newElement.querySelector('input.cards-line-initial-date').value = 0;

    //Adiciona listener de click ao ícone de excluir
    const excluirBtn = newElement.querySelector('.dashicons-trash');
    excluirBtn.addEventListener('click', (_e) => this.removeElement(_e));

    //Adiciona listener de change ao select
    const typeSelect = newElement.querySelector('.type-select');
    typeSelect.addEventListener('change', ({target}) => {
      const dateInput = newElement.querySelector('input[type="date"]');
      const catSelect = newElement.querySelector('select.cards-line-cat-select');
      if(target.value === 'proximas' || target.value === 'none'){
        dateInput.setAttribute('disabled', '');
        catSelect.setAttribute('disabled', '');
      }else if(target.value === 'apos-data'){
        dateInput.removeAttribute('disabled');
        catSelect.setAttribute('disabled', '');
      }else if(target.value === 'categoria'){
        catSelect.removeAttribute('disabled');
        dateInput.setAttribute('disabled', '');
      }
    })



    //Insere no DOM
    const domRef = document.querySelector('#home_cards_widget .main-list');
    domRef.appendChild(newElement)

  };

  removeElement({target}){
    const refIndex = target.dataset.index;
    const targetElement = document.querySelector(`#home_cards_widget li[data-index='${refIndex}']`);
    targetElement.remove();

    document.querySelectorAll('#home_cards_widget .main-list li').forEach(_li => {
      if(+_li.dataset.index > +refIndex){
        const new_index = +_li.dataset.index - 1;
        _li.dataset.index = new_index;
        _li.querySelector('.type-select').dataset.index = new_index;
        _li.querySelector('.dashicons-trash').dataset.index = new_index;
      }
    });
  }
}

export function submitHomeDisplays(){
  const submitData = [];
  const allDisplays = document.querySelectorAll('#home_cards_widget .main-list li');

  const defineTypeValue = (_type, _element) => {
    if(_type === 'proximas') return null;
    else if(_type === 'apos-data') return _element.querySelector('input.cards-line-initial-date').value;
    else if(_type === 'categoria') return _element.querySelector('select.cards-line-cat-select').value;
  }

  allDisplays.forEach((_display, _i) => {
    if(_i > 0){
      let displayData = {}
      displayData.nome = _display.querySelector('input.cards-line-name').value;
      displayData.type = _display.querySelector('select.type-select').value;
      displayData.type_value = defineTypeValue(displayData.type, _display);
      displayData.active = true;

      if(displayData.type !== 'none') submitData.push(displayData);
    }
  })

  jQuery(function($) {
    $.ajax({
      url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      type: 'POST',
      data: {
          'action': 'save_home_cards',
          'submitData': submitData,
      },
      success: async function(response) {
        location.reload();
      },
      error: function(error) {
        console.dir(error);
      }
    });
  })
}

