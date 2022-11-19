import React from "react";
import useKeyDownRef from "../../hooks/useKeyDownRef";
import config from "../../config.json";

const ButtonsReply = (props) => {
  // Arrow left and right keyboard shortcut to reply true or false
  const replyTrueRef = useKeyDownRef(config.GAME_SHORTCUT.YES);
  const replyFalseRef = useKeyDownRef(config.GAME_SHORTCUT.NO);

  return (
    <section className="d-flex justify-content-evenly mt-4">
      <button
        ref={replyTrueRef}
        type="button"
        className="btn btn-lg btn-primary col-3"
        onClick={() => props.reply(true, props.hash)}
      >
        Oui
      </button>
      <button
        ref={replyFalseRef}
        type="button"
        className="btn btn-lg btn-secondary col-3"
        onClick={() => props.reply(false, props.hash)}
      >
        Non
      </button>
    </section>
  );
};

export default ButtonsReply;
