import React from 'React';
import ReactDOM from 'react-dom/client';
import { GoogleOAuthProvider } from '@react-oauth/google';
import AppGoogle from './AppGoogle.jsx';

function AppThirdPartyLogin() {
  const [clientID, setClientID] = React.useState(null);

    React.useEffect(() => {
setClientID(window.themeLinks.gLoginClientId);
    }, [])
  return (
    <>
    {clientID ? <GoogleOAuthProvider clientId={clientID}>
        <AppGoogle clientId={clientID} />
      </GoogleOAuthProvider> : <p className="text-center">Client ID não configurado.</p>}
      
    </>
  );
}
window.addEventListener('load', () => {
  const tplogin_app_root = document.getElementById('thirdPartyLogin');
  if (tplogin_app_root) {
    ReactDOM.createRoot(tplogin_app_root).render(<AppThirdPartyLogin />);
}
});

