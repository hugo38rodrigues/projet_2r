import React from 'react';
import AffichageRessource from '../components/AffichageRessouce';
import Navigation from '../components/Navigations';




const Accueil = () => {
 

    return (
        <div className='acceuil'>
            <Navigation />
            <AffichageRessource/>

        </div>
    );
};

export default Accueil;