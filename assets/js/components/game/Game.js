import React from "react";
import Picture from "./Picture";
import ButtonsReply from "./ButtonsReply";
import useQuestionApi from "../../hooks/useQuestionApi";
import Timer from "./Timer";
import Credit from "./Credit";

/**
 * Started game component with nested components :
 *  - Picture (actor and movie)
 *  - ButtonsReply for answering
 *  - Timer countdown
 */
const Game = () => {
  const [question, refetchQuestion, replyQuestion] = useQuestionApi();

  const handleReply = (reply, hash) => {
    if (!hash) {
      return;
    }

    // Reply to the question
    replyQuestion(reply, hash);

    // Request new question
    refetchQuestion();
  };

  return null === question ? (
    <Credit />
  ) : (
    <>
      <h2>
        L'acteur/actrice ci-dessous a t-il/elle joué dans le film suivant ?
      </h2>
      <section className="d-flex justify-content-evenly align-items-center mt-4">
        <Picture data={question?.actor} />
        <Timer />
        <Picture data={question?.movie} />
      </section>
      <ButtonsReply reply={handleReply} hash={question?.hash} />
    </>
  );
};

export default Game;
