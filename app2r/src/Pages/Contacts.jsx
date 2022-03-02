import React, { useState } from 'react';
import Navigation from '../components/Navigations';


const Contact = () => {
    const [name, setName] = useState("");
    const [phone, setPhone] = useState("");
    const [email, setEmail] = useState("");
    const [message, setMessage] = useState("");
  
    const handleSubmit = (e) => {
      e.preventDefault();
  
      sendFeedback("service_eug9kp1","template_l3nz8ym", {
        name,
        phone,
        email,
        message,
      });
    };
  
    const sendFeedback = (serviceID,templateId, variables) => {
  
      window.emailjs
        .send(serviceID, templateId, variables)
        .then((res) => {
          console.log('success !');
          setName("");
          setPhone("");
          setEmail("");
          setMessage("");
        })
        .catch(
          (err) =>
            document.querySelector('.form-message').innerHTML =
              "Une erreur s'est produite, veuillez réessayer.")
    };
  
    return (
      <div id="Contact">
        <Navigation/>
        <form className="contact-form">
          <h2>Contactez-nous</h2>
          <br/>
          <div className="form-content">
            <input
              type="text"
              id="name"
              name="name"
              onChange={(e) => setName(e.target.value)}
              placeholder="nom + prénom *"
              value={name}
              autoComplete="off"
            />
            <br/>

            <input
              type="text"
              id="phone"
              name="phone"
              onChange={(e) => setPhone(e.target.value)}
              placeholder="téléphone"
              value={phone}
            />
            <br/>

            <div className="email-content">
              <label id="not-mail">Email non valide</label>
              <br/>
              <input
                type="mail"
                id="email"
                name="email"
                onChange={(e) => setEmail(e.target.value)}
                placeholder="email *"
                value={email}
                autoComplete="off"
              />
              <br/>
            </div>
            <textarea
              id="message"
              name="message"
              onChange={(e) => setMessage(e.target.value)}
              placeholder="message *"
              value={message}
            />
            <br/>
          </div>
          <br/>
          <button
            className="button"
            type="button"
            value="Envoyer"
            onClick={handleSubmit}
          > Envoyer </button>
          <div className="form-message"></div>
        </form>
      </div>
  );
};
export default Contact;