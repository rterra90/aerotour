<div class="search-input user-search-area">
  <label>
    <input type="text" name="q_value" id="user_search_input" placeholder="Informe o CPF do usuário"/>
  </label>
  <span onclick="performUserSearch(this, 'login', document.querySelector('#user_search_input').value)" class="user_search_btn">Buscar</span>

  <script>
    function performUserSearch(search_btn, q_type, q_value){
      event.preventDefault();
      search_btn.innerText = 'Aguarde...';
      jQuery(function($) {
        $.ajax({
          url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'POST',
          data: {
              'action': 'busca_usuario',
              'type': q_type,
              'value': q_value,
          },
          success: async function(response) {
            search_btn.innerText = 'Buscar';
            updateReactiveValues('user_search', response.data);
          },
          error: function(error) {
            console.log('response error:  ' + error);
          }
        });
      })
    }
  </script>
  
  <!-- Resultado da busca por usuário -->
  <div class="user-search-area_result" data-react="user_search" <?= isset($coupon) ? "data-code='".$coupon -> code."'" : "data-variation-id='".$variacao["variation_id"]."'"; ?>><div class="result_name"></div><div class="result_options"></div></div>
</div>