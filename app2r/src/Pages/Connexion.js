import React, { useState } from 'react';
import Login from "../components/Login";
import Navigation from '../components/Navigations';
import Signup from "../components/Signup";

const Connection = () => {
    const [loginPage, setLoginPage] = useState(true);

    return (
      
      <div className="connect-page">
        <Navigation />
        <div className="form-container">
          <button
            style={{  background: loginPage ?  null:"salmon" }}
            onClick={() => setLoginPage(false)}
          >
            S'inscrire
          </button>

          <button
            style={{ background: loginPage ? "salmon":null  }}
            onClick={() => setLoginPage(true)}
          >
            Se connecter
          </button>
  
          {loginPage ? <Login /> :<Signup />}
        </div>
      </div>
    );
};

export default Connection;