import React from 'React';
import ReactDOM from 'react-dom/client';
import { GoogleOAuthProvider } from '@react-oauth/google';
import AppGoogle from './AppGoogle.jsx';

function AppThirdPartyLogin() {
  const clientId =
    '131198865017-ohp88m555fk17nj5c744au3k8vogu332.apps.googleusercontent.com';
  return (
    <>
      <GoogleOAuthProvider clientId={clientId}>
        <AppGoogle clientId={clientId} />
      </GoogleOAuthProvider>
    </>
  );
}

const tplogin_app_root = document.getElementById('thirdPartyLogin');
if (tplogin_app_root) {
  ReactDOM.createRoot(tplogin_app_root).render(<AppThirdPartyLogin />);
}
