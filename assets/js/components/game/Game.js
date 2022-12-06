import React, { useEffect } from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import Timer from "./Timer";

/**
 * Started game component with nested components :
 *  - Picture (actor and movie)
 *  - ButtonsReply for answering
 *  - Timer countdown
 */
const Game = (props) => {
  // No question anymore
  if (null === props.question) {
    return;
  }

  // Set the new question and preload the next question
  useEffect(() => {
    // First mount Game with only one preloaded question
    // and without a question to ask, so refetchQuestion
    if (!props.question?.complete) {
      props.refetchQuestion();
    }
  }, []);

  // Question not complete
  if (!props.question.complete) {
    return;
  }

  return (
    <>
      <h2>
        L'acteur/actrice ci-dessous a t-il/elle joué dans le film suivant ?
      </h2>
      <section className="d-flex justify-content-evenly align-items-center mt-4">
        <Picture data={props.question.actor} />
        <Timer stop={props.stop} />
        <Picture data={props.question.movie} />
      </section>
      <ButtonsReply reply={props.replyQuestion} hash={props.question.hash} />
    </>
  );
};

export default Game;
