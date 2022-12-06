import { useState, useEffect } from "react";
import config from "../config.json";

/**
 * Score hook to manage score informations and color
 */
const useScore = (props) => {
  const [info, setInfo] = useState("");
  const [infoColor, setInfoColor] = useState("info");

  useEffect(() => {
    // color reboot
    setInfoColor("info");

    if (!props.hasQuestion) {
      // No question anymore
      setInfo(`Plus de question en stock...`);
      setInfoColor("warning");
    } else if (props.isStarted) {
      // Game just start
      setInfo("Goooooooooooo !");
    } else if (props.looseScore > 0 || props.score > 0) {
      // Game just end and player has played
      setInfo("Aller on se motive pour battre le record");
    } else {
      // Initial state game
      if (props.loadedCount === 0) {
        setInfo(`Le jeu dure ${config.GAME_TIMEOUT} secondes`);
      }
      if (props.loadedCount === 1) {
        setInfo((info) => info + `, à vos marques`);
      }
      if (props.loadedCount === 2) {
        setInfo((info) => info + `, prêt`);
      }
    }
  }, [props.isStarted, props.hasQuestion, props.loadedCount]);

  useEffect(() => {
    if (props.score > 0) {
      setInfo("Bravo !");
      setInfoColor("success");
    }
  }, [props.score]);

  useEffect(() => {
    if (props.looseScore > 0) {
      setInfo("Et non perdu");
      setInfoColor("danger");
    }
  }, [props.looseScore]);

  useEffect(() => {
    if (props.score > 0 && props.highScore > 0) {
      setInfo(`Yeah nouveau record !`);
      setInfoColor("warning");
    }
  }, [props.highScore]);

  return [info, infoColor];
};

export default useScore;
