import React from "react";
import useScore from "../../hooks/useScore";

/**
 * Scores and round informations display component
 */
const Scores = (props) => {
  const [info, infoColor] = useScore(props);

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
