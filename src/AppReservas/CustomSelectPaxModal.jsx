/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const CustomSelectPaxModal = ({ setFormData, tripType }) => {
  const [isOpen, setIsOpen] = React.useState(false);
  const [selected, setSelected] = React.useState(null);
  const listRef = React.useRef(null);
  const buttonRef = React.useRef(null);

  const optionsData = [
    { value: 'ida-e-volta', label: 'Ida e volta' },
    { value: 'ida', label: 'Apenas ida' },
    { value: 'volta', label: 'Apenas volta' },
  ];

  const handleSelect = (option) => {
    setSelected(option);
    setIsOpen(false);
    if (onChange) onChange(option.value);
  };

  const handleKeyDown = (e) => {
    if (e.key === 'Escape') setIsOpen(false);
    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
      e.preventDefault();
      const items = listRef.current?.querySelectorAll('[role="option"]');
      const currentIndex = Array.from(items).findIndex(
        (item) => item === document.activeElement,
      );
      const nextIndex =
        e.key === 'ArrowDown'
          ? Math.min(currentIndex + 1, items.length - 1)
          : Math.max(currentIndex - 1, 0);
      items[nextIndex]?.focus();
    }
    if (
      e.key === 'Enter' &&
      document.activeElement.getAttribute('role') === 'option'
    ) {
      const value = document.activeElement.getAttribute('data-value');
      const label = document.activeElement.textContent;
      handleSelect({ value, label });
    }
  };

  React.useEffect(() => {
    const initialOption = optionsData.filter(
      (_op) => _op.value === tripType,
    )[0];

    if (initialOption) setSelected(initialOption);
    else setSelected(optionsData[0]);

    const handleClickOutside = (e) => {
      if (buttonRef.current && listRef.current) {
        if (
          !buttonRef.current.contains(e.target) &&
          !listRef.current.contains(e.target)
        ) {
          setIsOpen(false);
        }
      }
    };
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, [tripType]);

  //Atualiza o formData ao selecionar
  const onChange = (_value) => {
    setFormData((_current) => {
      return { ..._current, tripType: _value };
    });
  };
  return (
    <div className="custom-select">
      <button
        ref={buttonRef}
        aria-haspopup="listbox"
        aria-expanded={isOpen}
        aria-labelledby="custom-select-label"
        onClick={(e) => {
          e.preventDefault();
          setIsOpen((prev) => !prev);
        }}
        onKeyDown={handleKeyDown}
        className="selected"
      >
        {selected ? selected.label : 'Selecione uma opção'}
      </button>

      {isOpen && (
        <ul
          ref={listRef}
          role="listbox"
          tabIndex="-1"
          aria-activedescendant={selected?.value}
          className="options"
        >
          {optionsData.map((option) => (
            <li
              key={option.value}
              role="option"
              data-value={option.value}
              tabIndex="0"
              aria-selected={selected?.value === option.value}
              onClick={() => handleSelect(option)}
              onKeyDown={handleKeyDown}
            >
              {option.label}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

CustomSelectPaxModal.propTypes = {
  setFormData: PropTypes.func,
  tripType: PropTypes.string,
};

export default CustomSelectPaxModal;
