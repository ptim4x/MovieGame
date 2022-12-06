import React from "react";
import useKeyboardShortcutRef from "../../hooks/useKeyboardShortcutRef";
import config from "../../config.json";
import ReactLoading from "react-loading";

/**
 * Start/Restart game component
 */
const Start = (props) => {
  // keyboard shortcut to launch game (default Space or Enter)
  const playRef = useKeyboardShortcutRef(config.GAME_SHORTCUT.PLAY);

  return (
    <section className="d-flex justify-content-center mt-4">
      {props.loading ? (
        <ReactLoading type="cylon" color="lightgray" />
      ) : (
        <button
          ref={playRef}
          type="button"
          className="btn btn-lg btn-secondary col-6 py-5"
          onClick={props.start}
        >
          {props.title}
        </button>
      )}
    </section>
  );
};

export default Start;
