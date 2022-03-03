import React from 'react';
import { NavLink } from 'react-router-dom';
import img from "../img/logo.png";

const Navigation = () => {
    return (
        <div className='navigation'>
           <div className='picture'>
                <img src={img} alt="2r"/>
            </div> 
            <NavLink  exact to="/">
                Acceuil
            </NavLink>
            <NavLink  exact to="/Ressources">
                Ressources
            </NavLink>
            <NavLink  exact to="/Contacts">
                Contact
            </NavLink>
            
            <NavLink  exact to="/Connexion">
                Connexion
            </NavLink> 
        </div>
    );
};

export default Navigation;