import React from "react";
import { useState, useEffect } from "react";

import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import GameData from "../../services/GameData";

function Game() {
  const [question, setQuestion] = useState(null);

  // componentDidMount like
  useEffect(() => {
    // Questions game init and suffle
    GameData.start();
    // Set the first question
    setQuestion(GameData.getNextQuestion());
  }, []);

  const handleReply = (reply, hash) => {
    // Request response
    GameData.setReply(reply, hash);

    // Request new question
    const question = GameData.getNextQuestion();
    setQuestion(question);
  };

  return (
    <>
      <h2>
        L'acteur/actrice ci-dessous a t-il/elle joué dans le film suivant ?
      </h2>
      <section className="d-flex justify-content-evenly align-items-center mt-4">
        <Picture data={question ? question.actor : null} />
        <Picture data={question ? question.movie : null} />
      </section>
      <ButtonsReply
        reply={handleReply}
        hash={question ? question.hash : null}
      />
    </>
  );
}

export default Game;
