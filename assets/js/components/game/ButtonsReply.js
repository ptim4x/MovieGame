import React from "react";
import useKeyboardShortcutRef from "../../hooks/useKeyboardShortcutRef";
import config from "../../config.json";

/**
 * Component for answering game questions
 */
const ButtonsReply = (props) => {
  // Keyboard shortcut to reply (default Arrow left=true and right=false)
  const replyTrueRef = useKeyboardShortcutRef(config.GAME_SHORTCUT.YES);
  const replyFalseRef = useKeyboardShortcutRef(config.GAME_SHORTCUT.NO);

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
