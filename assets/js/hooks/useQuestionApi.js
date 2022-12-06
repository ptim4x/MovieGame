import { useState, useEffect } from "react";
import apiGame from "../services/ApiGame";

/**
 * Hook to manage Question from API
 *
 * @returns array with value, fetcher and replyier
 */
const useQuestionApi = (winGame, looseGame, stopGame) => {
  const [question, setQuestion] = useState({});
  const [hasQuestion, setHasQuestion] = useState(false);

  // Fetch a new question
  const refetchQuestion = () => {
    apiGame.getNewQuestion().then((result) => setQuestion(result));
  };

  // Player reply to the question
  const replyQuestion = (reply, hash) => {
    if (!hash) {
      return;
    }

    // Check answer from API
    apiGame.isRightAnswer(reply, hash).then((result) => {
      if (result) {
        winGame();
      } else {
        looseGame();
      }

      // Fetch a new question
      refetchQuestion();
    });
  };

  // Initial question fetch at mount
  useEffect(() => {
    refetchQuestion();
  }, []);

  useEffect(() => {
    // No more question
    if (null === question) {
      setHasQuestion(false);
      stopGame();
    } else if (question.actor !== undefined) {
      setHasQuestion(true);
    }
  }, [question]);

  return [question, hasQuestion, refetchQuestion, replyQuestion];
};

export default useQuestionApi;
