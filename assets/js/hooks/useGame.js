import { useState, useEffect } from "react";
import useLocalStorage from "./useLocalStorage";

/**
 * Hook to manage Game states
 */
const useGame = () => {
  const [isStarted, setIsStarted] = useState(false);
  const [score, setScore] = useState(0);
  const [looseScore, setLooseScore] = useState(0);
  const [highScore, setHighScore] = useLocalStorage("moviegame_highscore", 0);

  const start = () => setIsStarted(true);
  const stop = () => setIsStarted(false);
  const win = () => setScore((score) => score + 1);
  const loose = () => {
    stop();
    setLooseScore((score) => score + 1);
  };

  useEffect(() => {
    if (isStarted) {
      // Init current game score
      setScore(0);
      setLooseScore(0);
    } else {
      if (score > highScore) {
        // current game finised and beat high score
        setHighScore(score);
      }
    }
  }, [isStarted]);

  return [isStarted, score, looseScore, highScore, start, stop, win, loose];
};

export default useGame;
