import { useState, useEffect, useContext } from "react";
import apiGame from "../services/ApiGame";
import { GameContext } from "../components/App";

/**
 * Hook to manage Question from API
 *
 * @returns array with value, fetcher and replyier
 */
const useQuestionApi = () => {
  const [question, setQuestion] = useState({});

  const game_context = useContext(GameContext);

  const refetchQuestion = () => {
    apiGame.getNewQuestion().then((result) => setQuestion(result));
  };

  const replyQuestion = (reply, hash) => {
    apiGame.isRightAnswer(reply, hash).then((result) => {
      // Request response
      if (result) {
        game_context.win();
      } else {
        game_context.loose();
        game_context.stop();
      }
    });
  };

  // componentDidMount like
  useEffect(() => {
    refetchQuestion();
  }, []);

  // Check no more question
  useEffect(() => {
    if (null === question) {
      game_context.end();
    }
  }, [question]);

  return [question, refetchQuestion, replyQuestion];
};

export default useQuestionApi;
