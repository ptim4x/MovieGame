import React, { useEffect, useContext } from "react";
import useCountdown from "../../hooks/useCountdown";
import { GameContext } from "../App";
import config from "../../config.json";

/**
 * Countdown timer component
 */
const Timer = () => {
  const [countdown] = useCountdown(config.GAME_TIMEOUT);

  const game_context = useContext(GameContext);

  useEffect(() => {
    // Stop game at finish countdown
    if (countdown == 0) {
      game_context.stop();
    }
  }, [countdown]);

  return (
    <section className="display-2 text-center">
      <span>{countdown}</span>
    </section>
  );
};

export default Timer;
