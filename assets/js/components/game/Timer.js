import React, { useEffect } from "react";
import useCountdown from "../../hooks/useCountdown";
import config from "../../config.json";

/**
 * Countdown timer component
 */
const Timer = (props) => {
  const [countdown] = useCountdown(config.GAME_TIMEOUT);

  useEffect(() => {
    // Stop game at finish countdown
    if (countdown == 0) {
      props.stop();
    }
  }, [countdown]);

  return (
    <section className="display-2 text-center">
      <span>{countdown}</span>
    </section>
  );
};

export default Timer;
