import { useState, useEffect, useContext } from "react";
import apiGame from "../services/ApiGame";
import { GameContext } from "../components/App";

/**
 * Hook to manage Question from API
 *
 * @returns array with value, fetcher and replyier
 */
const useQuestionApi = () => {
  const [question, setQuestion] = useState(null);

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
      }
    });
  };

  // componentDidMount like
  useEffect(() => {
    refetchQuestion();
  }, []);

  return [question, refetchQuestion, replyQuestion];
};

export default useQuestionApi;
