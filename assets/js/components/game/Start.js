import React, { useContext } from "react";
import { GameContext } from "../App";
import useKeyDownRef from "../../hooks/useKeyDownRef";
import config from "../../config.json";

const Start = (props) => {
  const game_context = useContext(GameContext);

  // Space or Enter keyboard shortcut to launch game
  const playRef = useKeyDownRef(config.GAME_SHORTCUT.PLAY);

  return (
    <section className="d-flex justify-content-center mt-4">
      <button
        ref={playRef}
        type="button"
        className="btn btn-lg btn-secondary col-6 py-5"
        onClick={game_context.start}
      >
        {props.title}
      </button>
    </section>
  );
};

export default Start;
