import React, { useState } from "react";
import axios from "axios";

const Signup = () => {
  const [psswrd, setPassword] = useState("");
  const [confirmPass, setConfirmPass] = useState("");
  const [nom, setNom] = useState("");
  const [prenom, setPrenom] = useState("");
  const [date_naiss, setDate_naiss] = useState("");
  const [email, setEmail] = useState("");
  const [login, setLogin] = useState("");

  const handleSubmit = (event) => {
    const post = {
      nom: nom,
      prenom: prenom,
      date_naiss: date_naiss,
      email: email,
      login: login,
      psswrd: psswrd

    };
    event.preventDefault();

    axios.post("adresse API", post)
      .then(res => {

        console.log("Status", res.status);
        console.log("Data", res.data);
        console.log(post)
      })
      .catch(({ error }) => {
        console.error('erreur envois enregistrement', error);
      });
  }

  return (

    <div className="signup">
      <form onSubmit={handleSubmit}>
        <h2>Inscrivez-vous</h2>

        <label>Nom</label>
        <br />
        <input type="text" value={nom} onChange={e => setNom(e.target.value)} required />
        <br />
        <br />

        <label>Prénom</label>
        <br />
        <input type="text" value={prenom} onChange={e => setPrenom(e.target.value)} required />
        <br />
        <br />

        <label>Login</label>
        <br />

        <input type="text" value={login} onChange={e => setLogin(e.target.value)} required />
        <br />
        <br />

        <label> Date de naissance </label>
        <br />
        <input type="date" value={date_naiss} onChange={e => setDate_naiss(e.target.value)} required></input>
        <br />
        <br />

        <label>Adresse mail</label>
        <br />
        <input type="email" value={email} onChange={e => setEmail(e.target.value)} required></input>
        <br />
        <br />

        <label>Mot de passe</label>
        <br />
        <input type="password" onChange={(e) => setPassword(e.target.value)} required />
        {psswrd.length < 8 && psswrd.length > 3 && (
          <p>Le mot de passe est trop petit, il doit faire 8 caractères minimum</p>
        )}
        <br />
        <br />
        <label>Confirmer mot de passe</label>
        <br />
        <input type="password" onChange={(e) => setConfirmPass(e.target.value)} required />
        {confirmPass.length > 4 && psswrd !== confirmPass && (
          <p>Les mots de passes ne correspondent pas</p>
        )}
        <br />
        <br />

        <button type="submit"> S'enregistrer</button>
      </form>
    </div>
  );
};

export default Signup;