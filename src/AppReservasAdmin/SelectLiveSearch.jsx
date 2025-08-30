/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const SelectLiveSearch = ({ srcArray, setFilter, filter }) => {
  const [status, setStatus] = React.useState('próximas');
  const selectFormRef = React.useRef();
  React.useEffect(() => {
    if (srcArray) {
      const form = document.querySelector('.live-search-form');
      const dropdowns = document.querySelectorAll('.live-search-dropdown');

      // Check if Dropdowns are Exist
      // Loop Dropdowns and Create Custom Dropdown for each Select Element
      if (dropdowns.length > 0) {
        dropdowns.forEach((dropdown) => {
          createCustomDropdown(dropdown);
        });
      }

      // Check if Form Element Exist on Page
      if (form !== null) {
        form.addEventListener('submit', (e) => {
          e.preventDefault();
        });
      }

      function createCustomDropdown(dropdown) {
        // Get All Select Options
        // And Convert them from NodeList to Array
        const options = dropdown.querySelectorAll('option');
        const optionsArr = Array.prototype.slice.call(options);

        // Create Custom Dropdown Element and Add Class Dropdown
        const customDropdown = document.createElement('div');
        customDropdown.classList.add('live-search-dropdown');
        dropdown.insertAdjacentElement('afterend', customDropdown);

        // Create Element for Selected Option
        const selected = document.createElement('div');
        selected.classList.add('dropdown-select');
        selected.textContent = optionsArr[0].textContent;
        customDropdown.appendChild(selected);

        // Create Element for Dropdown Menu
        // Add Class and Append it to Custom Dropdown
        const menu = document.createElement('div');
        menu.classList.add('dropdown-menu');
        customDropdown.appendChild(menu);
        selected.addEventListener('click', toggleDropdown.bind(menu));

        // Create Search Input Element
        const search = document.createElement('input');
        search.placeholder = 'Search...';
        search.type = 'text';
        search.classList.add('dropdown-menu-search');
        menu.appendChild(search);

        // Create Wrapper Element for Menu Items
        // Add Class and Append to Menu Element
        const menuInnerWrapper = document.createElement('div');
        menuInnerWrapper.classList.add('dropdown-menu-inner');
        menu.appendChild(menuInnerWrapper);

        // Loop All Options and Create Custom Option for Each Option
        // And Append it to Inner Wrapper Element
        optionsArr.forEach((option) => {
          const item = document.createElement('div');

          item.addEventListener('click', ({ target }) => {
            const _filter =
              target.dataset.varId == 'undefined' ? 0 : +target.dataset.varId;
            setFilter(_filter);
          });

          item.classList.add('dropdown-menu-item');
          item.dataset.value = option.value;
          item.dataset.varId = option.dataset.varId;
          item.dataset.dia = option.dataset.dia;
          item.textContent = option.textContent;
          menuInnerWrapper.appendChild(item);

          item.addEventListener(
            'click',
            setSelected.bind(item, selected, dropdown, menu),
          );
        });

        // Add Selected Class to First Custom Select Option
        menuInnerWrapper.querySelector('div').classList.add('selected');

        // Add Input Event to Search Input Element to Filter Items
        // Add Click Event to Element to Close Custom Dropdown if Clicked Outside
        // Hide the Original Dropdown(Select)
        search.addEventListener(
          'input',
          filterItems.bind(search, optionsArr, menu),
        );
        document.addEventListener(
          'click',
          closeIfClickedOutside.bind(customDropdown, menu),
        );
        dropdown.style.display = 'none';
      }

      // Toggle for Display and Hide Dropdown
      function toggleDropdown() {
        if (this.offsetHeight === 0) {
          this.style.display = 'block';
          this.querySelector('input.dropdown-menu-search').focus();
        } else {
          this.style.display = 'none';
          this.querySelector('input').focus();
        }
      }

      // Set Selected Option
      function setSelected(selected, dropdown, menu) {
        // Get Value and Label from Clicked Custom Option
        const value = this.dataset.value;
        const label = this.textContent;

        // Change the Text on Selected Element
        // Change the Value on Select Field
        selected.textContent = label;
        dropdown.value = value;

        // Close the Menu
        // Reset Search Input Value
        // Remove Selected Class from Previously Selected Option
        // And Show All Div if they Were Filtered
        // Add Selected Class to Clicked Option
        menu.style.display = 'none';
        menu.querySelector('input').value = '';
        menu.querySelectorAll('div').forEach((div) => {
          if (div.classList.contains('is-select')) {
            div.classList.remove('is-select');
          }
          if (div.offsetParent === null) {
            div.style.display = 'block';
          }
        });
        this.classList.add('is-select');
      }

      // Filter the Items
      function filterItems(itemsArr, menu) {
        // Get All Custom Select Options
        // Get Value of Search Input
        // Get Filtered Items
        // Get the Indexes of Filtered Items
        const customOptions = menu.querySelectorAll('.dropdown-menu-inner div');
        const value = this.value.toLowerCase();
        const filteredItems = itemsArr.filter((item) =>
          item.value.toLowerCase().includes(value),
        );
        const indexesArr = filteredItems.map((item) => itemsArr.indexOf(item));

        // Check if Option is not Inside Indexes Array
        // And Hide it and if it is Inside Indexes Array and it is Hidden Show it
        itemsArr.forEach((option) => {
          if (!indexesArr.includes(itemsArr.indexOf(option))) {
            customOptions[itemsArr.indexOf(option)].style.display = 'none';
          } else {
            if (customOptions[itemsArr.indexOf(option)].offsetParent === null) {
              customOptions[itemsArr.indexOf(option)].style.display = 'block';
            }
          }
        });
      }

      // Close Dropdown if Clicked Outside Dropdown Element
      function closeIfClickedOutside(menu, e) {
        if (
          e.target.closest('.live-search-dropdown') === null &&
          e.target !== this &&
          menu.offsetParent !== null
        ) {
          menu.style.display = 'none';
        }
      }
    }
  }, [srcArray]);

  //Reordena as excursões
  const sortedData = srcArray.sort((a, b) => {
    // Converte as strings de data para objetos de data
    const dateA = new Date(a[1].split('/').reverse().join('/'));
    const dateB = new Date(b[1].split('/').reverse().join('/'));
    // Compara as datas
    return dateA - dateB;
  });

  function alternaProxPass(proxOuPass) {
    const currentTimestamp = new Date();
    const allOptions = selectFormRef.current.querySelectorAll(
      '.dropdown-menu-item',
    );
    allOptions.forEach((_option) => {
      const _diaStr = _option.dataset.dia;
      const _diaTimestamp = new Date(
        _diaStr.split('/').reverse().join('/'),
      ).getTime();
      if (_diaTimestamp + 172800 < currentTimestamp) {
        //excursão passada
        if (proxOuPass === 'próximas') _option.style.display = 'none';
        else _option.style.display = 'block';
      } else if (_diaTimestamp > currentTimestamp) {
        //excursão futura
        if (proxOuPass === 'passadas') _option.style.display = 'none';
        else _option.style.display = 'block';
      }
    });

    setStatus(proxOuPass);
  }

  React.useEffect(() => {
    alternaProxPass(status);
  }, [filter]);

  return (
    <>
      <form
        ref={selectFormRef}
        name="countries"
        className="live-search-form"
        id="form"
      >
        <div className="form-group">
          <span className="form-arrow">
            <i className="bx bx-chevron-down"></i>
          </span>
          <select name="country" id="country" className="live-search-dropdown">
            <option disabled>Filtre por excursão...</option>
            {sortedData
              ? sortedData.map((item) => {
                  return (
                    <option
                      key={item[2]}
                      value={item[0]}
                      data-dia={item[1]}
                      data-var-id={item[2]}
                    >
                      {item[0]} - {item[1]}
                    </option>
                  );
                })
              : null}
          </select>
        </div>
      </form>
      <div className="selec-prox-pass">
        <span
          className={status === 'próximas' ? 'ativo' : ''}
          onClick={({ currentTarget }) =>
            alternaProxPass(currentTarget.innerText)
          }
        >
          próximas
        </span>{' '}
        |{' '}
        <span
          className={status === 'passadas' ? 'ativo' : ''}
          onClick={({ currentTarget }) =>
            alternaProxPass(currentTarget.innerText)
          }
        >
          passadas
        </span>
      </div>
    </>
  );
};

SelectLiveSearch.propTypes = {
  srcArray: PropTypes.array.isRequired,
  setFilter: PropTypes.func.isRequired,
  filter: PropTypes.number.isRequired,
};
export default SelectLiveSearch;
