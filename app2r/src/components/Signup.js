import React, { useState } from "react";

const Signup = () => {
  const [password, setPassword] = useState("");
  const [confirmPass, setConfirmPass] = useState("");

  return (

    <div className="signup">
      <form method="post">
        <h2>Inscrivez-vous</h2>

        <label>Nom</label>
        <br />
        <input type="text" required/>
        <br />
        <br />

        <label>Prénom</label>
        <br />
        <input type="text" required/>
        <br />
        <br />

        <label>Pseudo</label>
        <br />

        <input type="text" required />
        <br />
        <br />

        <label> Date de naissance </label>
        <br/>
        <input type="date" required></input>
        <br/>
        <br/>

        <label>Adresse mail</label>
        <br/>
        <input type="email" required></input>
        <br />
        <br />

        <label>Mot de passe</label>
        <br />
        <input type="password" onChange={(e) => setPassword(e.target.value)} required />
        {password.length < 8 && password.length>3&& (
          <p>Le mot de passe est trop petit, il doit faire 8 caractères minimum</p>
        )}
        <br />
        <br />
        <label>Confirmer mot de passe</label>
        <br />
        <input type="password" onChange={(e) => setConfirmPass(e.target.value)} required/>
        {confirmPass.length > 4 && password !== confirmPass && (
          <p>Les mots de passes ne correspondent pas</p>
        )}
        <br/>
        <br/>

        <button type="submit"> S'enregistrer</button>
      </form>
    </div>
  );
};

export default Signup;