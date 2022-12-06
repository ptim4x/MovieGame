import React, { useState, useEffect, createContext } from "react";
import Game from "./game/Game";
import Start from "./game/Start";
import Scores from "./game/Scores";
import Credit from "./game/Credit";
import useQuestionApi from "../hooks/useQuestionApi";
import useGame from "../hooks/useGame";

/** Create game context */
export const GameContext = createContext();

/**
 * Main App component
 */
const App = () => {
  const [isStarted, score, looseScore, highScore, start, stop, win, loose] =
    useGame();

  const [question, hasQuestion, replyQuestion] = useQuestionApi(
    win,
    loose,
    stop
  );

  return (
    <div className="container align-center">
      <header className="mb-4">
        <h1 className="text-bg-info text-center p-3">
          Test de connaissance cinématographique
        </h1>
      </header>
      <main className="text-center">
        <Scores
          score={score}
          looseScore={looseScore}
          highScore={highScore}
          isStarted={isStarted}
          hasQuestion={hasQuestion}
        />
        <GameContext.Provider
          value={{
            start: start,
            stop: stop,
          }}
        >
          {isStarted ? (
            <Game question={question} replyQuestion={replyQuestion} />
          ) : hasQuestion ? (
            <Start title={score + looseScore > 0 ? "Rejouer" : "Jouer"} />
          ) : (
            <Credit />
          )}
        </GameContext.Provider>
      </main>
      <footer className=""></footer>
    </div>
  );
};

export default App;
