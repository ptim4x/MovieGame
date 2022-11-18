import React from "react";
import { useContext } from "react";
import { GameContext } from "../App";

const Start = (props) => {
  const game_context = useContext(GameContext);

  return (
    <section className="d-flex justify-content-center mt-4">
      <button
        type="button"
        className="btn btn-lg btn-secondary col-6 py-5"
        onClick={game_context.start}
      >
        Jouer
      </button>
    </section>
  );
};

export default Start;
