// TODO corriger les recuperation de POST et mettre l'envois du post dans le bouton "envoyer"


import Navigation from '../components/Navigations';
import React, { useState, useEffect } from 'react';
import axios from 'axios';


const Ressources = () => {


    const [titre, setTitle] = useState("");
    const [texte, setText] = useState("");
    const [categorie, setCategorie] = useState("");
    const [acces, setAcces] = useState("");
    const [date_crea, setDate] = useState("");
    // const [createur,setCreateur]=useState("");
    

    const [niveau, setNiveau] = useState([]);
    const [cat, setCat] = useState([]);


    // ? Récupere le ficher json avec une get   
    useEffect(() => {
        axios
            // .get('http://localhost/2r/API/categorie.php')// ! url apache2 théo
            .get('http://2r/API/categorie') // ! url apache2 maison
            .then((res) => setCat(res.data));
    }, []);

    useEffect(() => {

        axios
            .get('http://2r/API/acces')// ! url apache2 théo
            // .get('http://localhost/2r/API/acces.php')// ! url apache2 maison
            .then((res) => setNiveau(res.data));
    }, []);

   
   

    const handleSubmit = (event) => {
        const post = {
            createur:1,
            titre: titre,
            categorie: categorie,
            acces: acces ,
            texte: texte ,
            date_crea: date_crea 
        };
        event.preventDefault();

        axios
            .post('http://2r/API/ressource',post ) // ! url apache2 théo
            // .post('http://localhost/2r/API/ressource',post ) // ! url apache2 maison
            .then(res => {

                console.log("Status",res.status);
                console.log("Data",res.data);
                console.log(post)
            })
        .catch(({ error }) => {
            console.error('Something went wrong!', error);
        });

    }

    // * Création du formulaire pour générer des ressources
    return (
        <div className='rs'>

            <Navigation />
            <div className='ressources'>
                <form  onSubmit={handleSubmit}>
                    <h2>Ressource</h2> <br />
                    <label>Titre de la ressource</label>
                    <br />
                    <input type="text" name="title" value={titre} onChange={e => setTitle(e.target.value)} required></input>
                    <br />

                    <div className='recup-categorie'>
                        <label>Catégorie</label>
                        <br />

                        <select id='cat' value={categorie} onChange={e => setCategorie(e.target.value)}>
                            <option value="">Sélectionnez votre catégorie</option>
                            {cat.map(cat => <option key={cat.id} value={cat.id} >{cat.label}</option>)}
                        </select>


                    </div>

                    <br />
                    <div className='recup-ressource'>
                        <label>Accès à la ressources</label>
                        <br />
                     <select id='rsr' value={acces} onChange={e => setAcces(e.target.value)}>
                            <option value="">Sélectionner votre </option>
                            {niveau.map(niveau => <option key={niveau.id} value={niveau.id} >{niveau.label}</option>)}
                        </select>
                    </div>

                    <br />

                    <label>Description</label>
                    <br />
                    <textarea name="text" value={texte} onChange={e => setText(e.target.value)}
                        rows="10" cols="50"
                        placeholder="Votre description." maxLength="500" required ></textarea>
                    <br />
                    <br />

                    <label>Date de création du post</label>
                    <br />
                    <input type="date" name="date" value={date_crea} onChange={e => setDate(e.target.value)}></input>
                    <br />
                    <br />
                    <button type='submit' >Poster la ressource</button>
                </form>
            </div>
        </div>
    );
};

export default Ressources;