<section class="sugestao-cta py-3 py-sm-0 container-md">
    <div class="sugestao-cta-wrapper">
    <div class="text-area">
    <strong>Não encontrou sua excursão?</strong>
    <span>Envie-nos sua sugestão de excursão para show ou evento! É só enviar detalhes como nome, data e local de realização.</span>
    </div>
    <?= do_shortcode("[contact-form-7 id='ea3f327' title='Sugestões']"); ?>
    
    </div>
</section>
<script>
if(window.location.hash.startsWith('#wpcf7')){
    document.querySelector('.sugestao-cta .input-area').remove()
}
document.querySelector('.sugestao-cta input.wpcf7-submit').setAttribute('data-btn-reactive', 'input')
    
</script>