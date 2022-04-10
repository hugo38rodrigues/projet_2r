import React, { useState, useEffect } from "react";
import axios from "axios";

const AffichageRessource = () => {
  const [datas, setData] = useState([]);

  useEffect(() => {
    axios
      //   .get("http://localhost/2r/API/ressource.php") // ! url maison
      .get("http://2r/API/ressource") // ! url théo

      .then((res) => setData(res.data));
  }, []);

  return (
    <div className="affichage-ressource">
      {datas.map((data) => (
        <div key={data.titre} className="affichage-content">
          <div id="ress">
            <div className="ress">
              <div id="Global">
                <div id="gauche">
                  <h1> {data.titre}</h1>
                  <p className="categorie">{data.categorie}</p>
                </div>
                <div id="droite">
                  <p className="date_crea">{data.date_crea}</p>
                  <p className="createur">{data.createur}</p>
                </div>
              </div>
              <br />
              <p className="text">{data.texte}</p>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
};

export default AffichageRessource;
