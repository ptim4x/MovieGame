import React from "react";
import {
  FaThumbsUp,
  FaQuestion,
  FaGithub,
  FaStar,
  FaBeer,
} from "react-icons/fa";
import { HiCursorClick, HiEmojiHappy } from "react-icons/hi";

/**
 * Credit component
 */
const Credit = () => (
  <div className="my-5">
    <h3>Merci d'avoir jouer.</h3>
    <div className="alert alert-info mt-5">
      <div className="h4 my-3">
        <FaThumbsUp />
        <FaQuestion />
        <HiCursorClick />
        <FaStar />
        <a
          href="https://github.com/ptim4x/MovieGame"
          target="_blank"
          rel="noreferrer"
        >
          <FaGithub />
        </a>
        <span className="h3">:</span>
        <FaBeer />
        <HiEmojiHappy />
      </div>
    </div>
  </div>
);

export default Credit;
