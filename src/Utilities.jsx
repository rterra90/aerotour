export function convertDate(inputDate, action) {
  // Função auxiliar para detectar o formato
  function detectFormat(dateStr) {
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) return 'ISO';
    if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr)) return 'DMY';
    return 'UNKNOWN';
  }

  // Função auxiliar para converter DMY para ISO
  function dmyToIso(dmy) {
    const [day, month, year] = dmy.split('/');
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
  }

  // Função auxiliar para converter ISO para DMY
  function isoToDmy(iso) {
    const [year, month, day] = iso.split('-');
    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
  }

  const format = detectFormat(inputDate);

  if (format === 'UNKNOWN') {
    throw new Error(
      'Formato de data não reconhecido. Use "dd/mm/aaaa" ou "aaaa-mm-dd".',
    );
  }

  switch (action.toLowerCase()) {
    case 'iso':
      return format === 'ISO' ? inputDate : dmyToIso(inputDate);
    case 'dmy':
      return format === 'DMY' ? inputDate : isoToDmy(inputDate);
    case 'dateobject': {
      const isoDate = format === 'ISO' ? inputDate : dmyToIso(inputDate);
      return new Date(isoDate);
    }
    default:
      throw new Error(
        `Ação "${action}" não reconhecida. Use "iso", "dmy" ou "dateObject".`,
      );
  }
}

// Função que obtém o dia 30 dias antes da data da excursão
export function dataTrintaDiasAntes(data_excursao_iso) {
  // calcular a data limite do desconto (30 dias antes do evento)
  const dataEvento = new Date(data_excursao_iso);
  const dataLimite = new Date(dataEvento);
  dataLimite.setDate(dataEvento.getDate() - 30);

  // formatar no padrão yyyy-mm-dd
  const dataLimiteDesconto = dataLimite.toISOString().split('T')[0];

  return dataLimiteDesconto;
}

export function dataTemDescontoHoje(data_excursao_iso) {
  // obter diferença em dias
  const agora = new Date();
  const diffEmMs = new Date(data_excursao_iso) - agora;
  const diffEmDias = diffEmMs / (1000 * 60 * 60 * 24);

  return diffEmDias > 29; // deve ser 29 para 30 dias ou mais
}
