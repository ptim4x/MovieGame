import React, { useState, useEffect, useContext } from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import GameData from "../../services/GameData";
import { GameContext } from "../App";
import Timer from "./Timer";

function Game() {
  const [question, setQuestion] = useState(null);

  const game_context = useContext(GameContext);

  // componentDidMount like
  useEffect(() => {
    // Set the first question
    setQuestion(GameData.getNextQuestion());
  }, []);

  const handleReply = (reply, hash) => {
    // Request response
    if (GameData.isRight(reply, hash)) {
      game_context.win();
    } else {
      game_context.loose();
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
      <section className="d-flex justify-content-evenly align-items-center mt-4">
        <Picture data={question ? question.actor : null} />
        <Timer />
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
