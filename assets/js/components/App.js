import React from "react";
import { useState, useEffect, createContext } from "react";
import Game from "./game/Game";
import Start from "./game/Start";
import Scores from "./game/Scores";
import GameData from "../services/GameData";
import { useLocalStorage } from "../hooks/useLocalStorage";

export const GameContext = createContext();

function App() {
  const [isStarted, setIsStarted] = useState(false);
  const [score, setScore] = useState(0);
  const [highScore, setHighScore] = useLocalStorage("moviegame_highscore", 0);

  if (isStarted) {
    // Launch test set
    GameData.start();
  }

  useEffect(() => {
    if (isStarted) {
      // Init current game score
      setScore(0);
    } else {
      if (score > highScore) {
        // current game finised and beat high score
        setHighScore(score);
      }
    }
  }, [isStarted]);

  return (
    <div className="container align-center">
      <header className="mb-5">
        <h1 className="text-bg-info text-center p-3">
          Test de connaissance cinématographique
        </h1>
        <Scores score={score} highScore={highScore} />
      </header>
      <main className="text-center">
        <GameContext.Provider
          value={{
            start: () => setIsStarted(true),
            stop: () => setIsStarted(false),
            win: () => setScore((score) => score + 1),
          }}
        >
          {isStarted ? <Game /> : <Start />}
        </GameContext.Provider>
      </main>
      <footer className=""></footer>
    </div>
  );
}

export default App;
