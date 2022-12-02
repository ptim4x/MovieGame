import React, { useState, useEffect, useContext } from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import apiGame from "../../services/ApiGame";
import { GameContext } from "../App";
import Timer from "./Timer";
import { useQuery } from "react-query";

/**
 * Started game component with nested components :
 *  - Picture (actor and movie)
 *  - ButtonsReply for answering
 *  - Timer countdown
 */
const Game = () => {
  const { data: question, refetch: refetchQuestion } = useQuery(
    "game-question",
    apiGame.getNewQuestion
  );

  const game_context = useContext(GameContext);

  const handleReply = (reply, hash) => {
    // Request response
    if (apiGame.isRightAnswer(reply, hash)) {
      game_context.win();
    } else {
      game_context.loose();
    }

    // Request new question
    refetchQuestion();
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
