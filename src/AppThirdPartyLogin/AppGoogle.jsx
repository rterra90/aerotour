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

  const onSuccess = async (res) => {
    // Mostra um loading simples
    const container = document.getElementById('thirdPartyLogin');
    container.innerHTML = '<span>Autenticando...</span>';

    try {
      const response = await fetch('/wp-json/aerotour/v1/google-login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: res.credential }) // Envia o JWT íntegro
      });

      const data = await response.json();

      if (data.success) {
        window.location.href = data.redirect; // Redireciona para /minha-conta
      } else {
        alert('Erro no login: ' + data.message);
      }
    } catch (error) {
      console.error('Erro na requisição:', error);
    }
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
