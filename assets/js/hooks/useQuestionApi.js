import { useState, useEffect } from "react";
import apiGame from "../services/ApiGame";
import useImagesLoading from "./useImagesLoading";

/**
 * Hook to manage Question from API
 *
 * @returns array with value, loading infos, fetcher and replyier
 */
const useQuestionApi = (winGame, looseGame, stopGame) => {
  const [question, setQuestion] = useState({});
  const [questionLoading, setQuestionLoading] = useState({});
  const [isLoading, setImagesLoading] = useImagesLoading();
  const [hasQuestion, setHasQuestion] = useState(false);

  // Set the new question and preload the next question
  const refetchQuestion = () => {
    setQuestion(questionLoading);
    apiGame.getNewQuestion().then((result) => setQuestionLoading(result));
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
        // Set the new question and preload the next question
        refetchQuestion();
      } else {
        looseGame();
      }
    });
  };

  // Initial question fetch at mount
  useEffect(() => {
    refetchQuestion();
  }, []);

  useEffect(() => {
    // No more question to preload
    if (null === questionLoading) {
      // The game hasn't start but there isn't any question
      if (!question?.complete) {
        setHasQuestion(false);
      }
    } else if (questionLoading?.complete) {
      setHasQuestion(true);
      // Preload images
      setImagesLoading([questionLoading.actor.img, questionLoading.movie.img]);
    }
  }, [questionLoading]);

  useEffect(() => {
    // No more question to ask
    if (null === question) {
      setHasQuestion(false);
      stopGame();
    }
  }, [question]);

  return [question, hasQuestion, isLoading, refetchQuestion, replyQuestion];
};

export default useQuestionApi;
