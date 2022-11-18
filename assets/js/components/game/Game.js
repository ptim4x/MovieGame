import React from "react";
import { useState, useEffect, useContext } from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import GameData from "../../services/GameData";
import { useCountdown } from "../../hooks/useCountdown";
import { GameContext } from "../App";

function Game() {
  const [question, setQuestion] = useState(null);
  const [countdown] = useCountdown(10);

  const game_context = useContext(GameContext);

  // componentDidMount like
  useEffect(() => {
    // Set the first question
    setQuestion(GameData.getNextQuestion());
  }, []);

  useEffect(() => {
    // Stop game at finish countdown
    if (countdown == 0) {
      game_context.stop();
    }
  }, [countdown]);

  const handleReply = (reply, hash) => {
    // Request response
    if (GameData.isRight(reply, hash)) {
      game_context.win();
    }

    // Request new question
    const question = GameData.getNextQuestion();
    setQuestion(question);
  };

  return (
    <>
      <h2>
        L'acteur/actrice ci-dessous a t-il/elle joué dans le film suivant ?
      </h2>
      <section className="display-2 text-center">
        <span>{countdown}</span>
      </section>
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
