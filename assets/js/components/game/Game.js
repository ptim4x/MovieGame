import React, { useState, useEffect, useContext } from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import GameData from "../../services/GameData";
import { GameContext } from "../App";
import Timer from "./Timer";

/**
 * Started game component with nested components :
 *  - Picture (actor and movie)
 *  - ButtonsReply for answering
 *  - Timer countdown
 */
const Game = () => {
  const [question, setQuestion] = useState(null);

  const game_context = useContext(GameContext);

  // componentDidMount like
  useEffect(() => {
    // Set the first question
    setQuestion(GameData.getNewQuestion());
  }, []);

  const handleReply = (reply, hash) => {
    // Request response
    if (GameData.isRightAnswer(reply, hash)) {
      game_context.win();
    } else {
      game_context.loose();
    }

    // Request new question
    const question = GameData.getNewQuestion();
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
};

export default Game;
