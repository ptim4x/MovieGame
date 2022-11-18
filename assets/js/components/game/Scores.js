import React from "react";

const Scores = (props) => {
  return (
    <section className="d-flex justify-content-evenly mt-4">
      <span>Meilleur score : {props.highScore}</span>
      <span>Score actuel : {props.score}</span>
    </section>
  );
};

export default Scores;
