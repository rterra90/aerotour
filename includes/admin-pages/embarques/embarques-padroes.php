<script>
  class PadraoHorariosComponent{
    constructor(padraoName, padraoRef, padraoIntervalos){
      this.nome = padraoName;
      this.ref = padraoRef;
      this.intervalos = padraoIntervalos
    }
    addElement(){
      const refNode = document.querySelector('.padroes-container > .padrao-horarios:last-child');
      let newElement = refNode.cloneNode(true);
      function handleLiToggle(refValue){
        newElement.querySelectorAll('.intervalos-li').forEach(_embLi => {
          _embLi.dataset.status = _embLi.dataset.emb == refValue ? 'disabled' : 'enabled';
          if(_embLi.dataset.emb == refValue) _embLi.querySelector('input[type="time"]').setAttribute('disabled', '');
          else _embLi.querySelector('input[type="time"]').removeAttribute('disabled', '')
        });
      }
      //Ajusta o index
      const _index = +newElement.dataset.index + 1
      newElement.dataset.index = _index;

      //Ajusta os inputs
      const embsLi = newElement.querySelectorAll('.intervalos-li');
      embsLi.forEach((embLi, _i)=> {
        const _label = embLi.querySelector('.nome-label');
        const _timeInput = embLi.querySelector('input[type="time"]');
        const _tgInput = embLi.querySelector('input[type="checkbox"]');
        const _tgLabel = embLi.querySelector('label.tgl-btn');
        _label.htmlFor = '_' + _index + '_' + _i;
        _timeInput.id = '_' + _index + '_' + _i;
        _tgInput.id = 'tgl_' + _index + '_' + _i;
        _tgLabel.htmlFor = 'tgl_' + _index + '_' + _i;
        _tgInput.checked = false;
        _timeInput.value = null;
      })

      //Ajusta o nome do display
      newElement.querySelector('input[type="text"]').value = this.nome ? this.nome : '';

      //Ajusta a referência
      const refSelect = newElement.querySelector('select.ref-select');
      refSelect.value = this.ref;

      Array.from(refSelect.options).forEach(opt => {
        if(opt.value === this.ref) opt.setAttribute('selected', '');
      })


      if(this.ref != 'none') handleLiToggle(this.ref);

      //LISTENER DO SELECT DE REFERÊNCIA
      refSelect.addEventListener('change', ({target}) => handleLiToggle(target.value));

      //Ajusta os inputs de horário para padrões já existentes
      if(this.intervalos && this.intervalos.length > 0){
        const timeInputs = newElement.querySelectorAll('input[type="time"]:not([disabled])');
        timeInputs.forEach(timeInput => {
          const _emb_ref = timeInput.parentElement.parentElement.dataset.emb;
          const targetIterval = this.intervalos.flatMap((_int) => _int.embarque == _emb_ref ? _int : [])[0];

          if(targetIterval){
            let fullTimestamp = new Date(+targetIterval.timestamp + 270000000);
            let _hh = fullTimestamp.getHours();
            _hh = _hh.toString().length == 1 ? '0' + _hh : _hh;
            let _mm = fullTimestamp.getMinutes();
            _mm = _mm.toString().length == 1 ? '0' + _mm : _mm;
            timeInput.setAttribute('value', _hh + ":" + _mm)
            timeInput.value = _hh + ":" + _mm;

            const tgCheckbox = timeInput.parentElement.querySelector('input[type="checkbox"]')
            tgCheckbox.checked = targetIterval.rel === 'minus' ? true : false
          } 
        })
      }


      //Insere no DOM
      const domRef = document.querySelector('#embarques-settings-modal .padroes-container');
      domRef.appendChild(newElement);
    }
  }

  // ADICIONA LISTENER AO BOTAO DE ADICIONAR PADRÃO
  document.addEventListener('DOMContentLoaded', () =>{
    document.querySelector('button#add-padrao').addEventListener('click', () => {
      const novoPadrao = new PadraoHorariosComponent(null, 'none', null);
      novoPadrao.addElement();
    });
  })

  function submitSalvarPadrao(){
    const submitData = [];
    const allPadroes = document.querySelectorAll('#embarques-settings-modal .padrao-horarios');

    allPadroes.forEach((_padrao, _i) => {
      if(_i > 0){
        let padraoData = {};
        padraoData.nome = _padrao.querySelector('input.padrao-horarios-nome').value;
        padraoData.referencia = _padrao.querySelector('select.ref-select').value;
        padraoData.embarques = [];

        _padrao.querySelectorAll('.intervalos-li[data-status="enabled"]').forEach(_emb => {
          let _interval = {};
          const timeInputValue = _emb.querySelector('input[type="time"]').value;
          if(timeInputValue !== '' && timeInputValue !== '00:00'){
            _interval.embarque = _emb.dataset.emb;
          _interval.rel = _emb.querySelector('input.tgl').checked ? 'minus' : 'plus';
          _interval.timestamp = getTimestampFromZero(timeInputValue);

          padraoData.embarques.push(_interval);
          }
        })

        if(padraoData.embarques.length > 0 && padraoData.nome != '' && padraoData.referencia != 'none'){
          submitData.push(padraoData);
        }
      }
    })

    fetchAdminAPI('save_padroes_horarios', submitData, (status, data) => {
      if(status) location.reload();
      else console.log(data)
    })
  }
  document.addEventListener('DOMContentLoaded', () => {
    const padroesString = document.querySelector('#embarques-settings-modal .padroes-container').dataset.json;
    const padroesArray = JSON.parse(padroesString);
    
    // ADICIONA UM COMPONENTE PARA CADA DISPLAY JÁ EXISTENTE
    if(padroesArray != false){
      padroesArray.forEach(_padrao => {
      const newPadrao = new PadraoHorariosComponent(_padrao.nome, _padrao.referencia, _padrao.embarques);
      newPadrao.addElement();
    })
    }
    
  })
</script>

<dialog id="embarques-settings-modal" data-dialog="padroes-horarios">

  <?php $currentPadroes = get_option('padroes_horarios'); ?>

  <span class="dashicons dashicons-exit" style="float:right; z-index: 1000"></span>
  <div>
    <h3>PADRÕES DE HORÁRIOS</h3>
    <p>Defina padrões de horários para as excursões</p>
    <button id="add-padrao" class="button button-small button-secondary">Adicionar padrão</button>
    <button id="save-padroes" class="button button-primary button-small" onclick="submitSalvarPadrao(this)">Salvar padrões</button>
    <div class="padroes-container" data-json='<?= json_encode($currentPadroes, JSON_UNESCAPED_UNICODE); ?>'>

      <div class="padrao-horarios" data-index=0>
        <label class="heading">
          Nome do padrão
          <input type="text" placeholder="Digite..." name="padrao-horarios-nome" class="padrao-horarios-nome merged-text-input" value="Disabled...">
        </label>
        <div>
          <span class="heading">Ponto de referência</span>
          <select name="padrao-horario-referencia" class="ref-select">
            <option value="none" selected>Selecione...</option>
            <?php
              foreach($embarques_db as $embarque_db){
                ?>
                <option value="<?= $embarque_db -> id; ?>"><?= $embarque_db -> nome; ?></option>
                <?php
              }
            ?>
          </select>
        </div>

        <div>
          <span class="heading">Intervalos</span>
          <ul class="intervalos">
            <?php
            $_ind_interval = 0;
            foreach($embarques_db as $embarque_db){
              ?>
              <li class="intervalos-li" data-emb="<?= $embarque_db -> id; ?>">
                <div><label for="<?= '_' . 0 . '_' . $_ind_interval; ?>" class="nome-label"><?= $embarque_db -> nome; ?></label></div>
                <div class="inputs-wrapper">
                  <div>
                    <input class="tgl tgl-skewed" id="tgl<?= '_0_' . $_ind_interval; ?>" type="checkbox" name="maisoumenos" />
                    <label class="tgl-btn" data-tg-off="+" data-tg-on="-" for="tgl<?= '_0_' . $_ind_interval; ?>"></label>
                  </div>
                  <input type="time" name="ponto_intervalo" id="<?= '_' . 0 . '_' . $_ind_interval; ?>">
                </div>
              </li>

              <?php
              $_ind_interval = $_ind_interval + 1;
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <?php 
      if($currentPadroes == false){
        echo '<div id="sem-padroes-placeholder"><p>Nenhum padrão de horários registrado.</p></div>';
      }
    ?>
  </div>
</dialog>