/* eslint-disable react/react-in-jsx-scope */
import { utils, writeFileXLSX } from 'xlsx';
import PropTypes from 'prop-types';

const BotaoExportarXLS = ({ _ref }) => {
  return (
    <button
      onClick={() => {
        // generate workbook from table element
        const wb = utils.table_to_book(_ref.current);
        // write to XLSX
        writeFileXLSX(wb, 'SheetJSReactExport.xlsx');
      }}
      id="exportSheetBtn"
    >
      Exportar XLS
    </button>
  );
};

BotaoExportarXLS.propTypes = {
  _ref: PropTypes.object.isRequired,
};

export default BotaoExportarXLS;
