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
