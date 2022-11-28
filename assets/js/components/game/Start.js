import React, { useContext } from "react";
import { GameContext } from "../App";
import useKeyboardShortcutRef from "../../hooks/useKeyboardShortcutRef";
import config from "../../config.json";

/**
 * Start/Restart game component
 */
const Start = (props) => {
  const game_context = useContext(GameContext);

  // keyboard shortcut to launch game (default Space or Enter)
  const playRef = useKeyboardShortcutRef(config.GAME_SHORTCUT.PLAY);

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