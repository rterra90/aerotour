import React from 'React';
import ReactDOM from 'react-dom/client';
// import axios from 'axios';
import { gapi } from 'gapi-script';
import { jwtDecode } from 'jwt-decode';
import {
  GoogleOAuthProvider,
  GoogleLogin,
  googleLogout,
  useGoogleLogin,
} from '@react-oauth/google';

const AppGoogle = ({ clientId }) => {
  const [user, setUser] = React.useState([]);
  const [profile, setProfile] = React.useState([]);

  const onSuccess = (res) => {
    const decoded = jwtDecode(res.credential);

    document.querySelector('form.register').style.display = 'none';

    const loading = document.createElement('span');
    loading.classList.add('loadingElement');


    document.querySelector('.login-box#cadastro #thirdPartyLogin').innerHTML = '';
    document.querySelector('.login-box#cadastro #thirdPartyLogin').appendChild(loading);

    const registerForm = document.querySelector('form.register');

    registerForm[7].setAttribute('value', '_google_register');

    registerForm[0].setAttribute('value', decoded.given_name);
    registerForm[1].setAttribute('value', decoded.family_name);
    registerForm[2].setAttribute('value', decoded.email);
    registerForm[3].setAttribute('value', decoded.email);
    registerForm[5].checked = true;
    registerForm.submit();
  };
  const onFailure = (res) => {
    console.log('LOGIN ERROR! res: ', res);
  };

  React.useEffect(() => {
    function start() {
      gapi.client.init({
        clientId: clientId,
        scope: '',
      });
    }

    gapi.load('client:auth2', start);
  });
  return (
    <GoogleLogin
      clientId={clientId}
      onSuccess={onSuccess}
      onError={onFailure}
      buttonText="Teste GLogin"
    />
  );
};
export default AppGoogle;
