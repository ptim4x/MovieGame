import React, { useState, useEffect } from "react";
import config from "../../config.json";

const Scores = (props) => {
  const [info, setInfo] = useState("");
  const [infoColor, setInfoColor] = useState("info");

  useEffect(() => {
    setInfoColor("info");
    if (props.isStarted) {
      setInfo("Goooooooooooo !");
    } else if (props.looseScore > 0 || props.score > 0) {
      setInfo("Aller on se motive pour battre le record");
    } else {
      setInfo(
        `Le jeu dure ${config.GAME_TIMEOUT} secondes, à vos marques, prêt`
      );
    }
  }, [props.isStarted]);

  useEffect(() => {
    if (props.score > 0) {
      setInfo("Bravo !");
      setInfoColor("success");
    }
  }, [props.score]);

  useEffect(() => {
    if (props.looseScore > 0) {
      setInfo("Et non perdu");
      setInfoColor("danger");
    }
  }, [props.looseScore]);

  useEffect(() => {
    if (props.score > 0 && props.highScore > 0) {
      setInfo(`Yeah nouveau record !`);
      setInfoColor("warning");
    }
  }, [props.highScore]);

  return (
    <>
      <section className="row my-4">
        <div className="col m-2 alert alert-info" role="alert">
          <h4 className="alert-heading">Score : {props.score}</h4>
        </div>
        <div className={"col-6 m-2 alert alert-" + infoColor} role="alert">
          <h4 className="alert-heading">{info}</h4>
        </div>
        <div className="col m-2 alert alert-info" role="alert">
          <h4 className="alert-heading">Meilleur score : {props.highScore}</h4>
        </div>
      </section>
    </>
  );
};

export default Scores;
