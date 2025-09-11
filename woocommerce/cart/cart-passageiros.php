<div class="passageiros">
	<?php
	if($passageiros){
		foreach($passageiros as $passageiro){
			if($passageiro !== false){
				?>
				<div class="cart-passageiro d-flex gap-2">
					<div class="person-icone"><i><?= aer_icons("user_black", 16, 16)?></i></div>
					<div class="dados">
						<p class="nome"><?= $passageiro -> nome_completo; ?></p>
						<div class="d-flex">
							<p>CPF: <?= $passageiro -> cpf; ?></p>
							<p>Cel: <?= $passageiro -> celular; ?></p>
						</div>
					</div>
				</div>
			<?php
			}										
		}									
	}
	?>
</div>