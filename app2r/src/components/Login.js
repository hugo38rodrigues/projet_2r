import React from "react";
// ! ecrire le code pour envoyer le log https://ichi.pro/fr/creons-un-formulaire-de-connexion-moderne-sur-react-01-259159134165587

const Login = () => {
  return (
    <div className="login">
    <form method="post">
      <h2>Connexion</h2>
      <br/> <br/>
      <label>Pseudo</label>
      <br />
      <input type="text" />
      <br />
      <br/>
      <label>Mot de passe</label>
      <br />
      <input type="password" name="" id="" />
      <br/>
      <br/>

      <button type="submit">Connexion</button>
    </form>
    </div>
  );
};

export default Login;