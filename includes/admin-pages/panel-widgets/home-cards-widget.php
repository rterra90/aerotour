<?php
function home_cards_widget(){

$currentDisplays = get_option('aer_home_displays');
$categories = get_terms( ['taxonomy' => 'product_cat', 'fields' => 'id=>name'] );

  ?>
    <script>
      class CardsLineElement {
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
          if(this.type === 'apos-data')newElement.querySelector('input.cards-line-initial-date').value = this.typeValue;
          else if(this.type === 'categoria')newElement.querySelector('select.cards-line-cat-select').value = this.typeValue;
          

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

      function submitHomeDisplays(_e){
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
        _e.innerText = 'Aguarde...';
        _e.setAttribute('disabled', '');
        
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

      // RENDERIZA OS PRIMEIROS COMPONENTES AO CARREGAR O DOM
      document.addEventListener('DOMContentLoaded', () => {
        const homeDisplaysString = document.querySelector('#home_cards_widget .main-list').dataset.json;
        const homeDisplaysArray = JSON.parse(homeDisplaysString);

        // ADICIONA UM COMPONENTE PARA CADA DISPLAY JÁ EXISTENTE
        homeDisplaysArray.forEach(_display => {
          const newLine = new CardsLineElement(_display.nome, _display.type, _display.type_value);
          newLine.addElement();
        })

        // ADICIONA LISTENER AO BOTAO DE ADICIONAR DISPLAY
        document.querySelector('button#add-cards-line').addEventListener('click', () => {
          const lineToAdd = new CardsLineElement("Insira o nome da seção...", 'none', null);
          lineToAdd.addElement();
        });
      })

    </script>
    <div id="home_cards_widget">
      <div id="boxes-container">
        <ul class="main-list" data-json='<?= json_encode($currentDisplays, JSON_UNESCAPED_UNICODE); ?>'>
          <li data-index=0>
            <div class="cards-line">
              <div class="body">
                <input type="text" name="cards-line-name" class="cards-line-name" value="Disabled...">
                <div class="type-select-container">
                  <select class="type-select" data-index=0>
                    <option value="none">Selecione...</option>
                    <option value="proximas">Próximas</option>
                    <option value="apos-data">Após data...</option>
                    <option value="categoria">Por categoria...</option>
                  </select>
                  <input type="date" name="cards-line-initial-date" class="cards-line-initial-date">
                  <select name="cards-line-cat-select" class="cards-line-cat-select">
                  <?php
                    foreach($categories as $_cat){
                      ?>
                      <option value="<?= $_cat; ?>"><?= $_cat; ?></option>
                      <?php
                    }
                  ?>
                  </select>
                </div>
              </div>
              <div class="icons">
                
                <span class="excluir-btn dashicons dashicons-trash" data-index=0 onclick=""></span>
                    
              </div>
            </div>  
          </li>
        </ul>
        
        <button id="add-cards-line" class="button button-small button-secondary">Adicionar linha</button>
        <div class="widget-footer">
          <button class="button button-primary button-hero" onclick="submitHomeDisplays(this)">Salvar</button>
        </div>
      </div>
    </div>

  <?php
}

?>