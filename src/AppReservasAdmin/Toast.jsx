/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const Toast = ({ message, setToast }) => {
  React.useEffect(() => {
    setTimeout(() => {
      setToast(false);
    }, 3000);
  }, []);

  return <span className="toast">{message}</span>;
};

Toast.propTypes = {
  message: PropTypes.string.isRequired,
  setToast: PropTypes.func,
};

export default Toast;
