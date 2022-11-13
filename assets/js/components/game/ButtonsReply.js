import React from "react";

const ButtonsReply = (props) => (
  <section className="d-flex justify-content-evenly mt-4">
    <button
      type="button"
      className="btn btn-lg btn-primary col-3"
      onClick={() => props.reply(true, props.hash)}
    >
      Oui
    </button>
    <button
      type="button"
      className="btn btn-lg btn-secondary col-3"
      onClick={() => props.reply(false, props.hash)}
    >
      Non
    </button>
  </section>
);

export default ButtonsReply;
