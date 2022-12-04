import { useState, useEffect } from "react";
import config from "../config.json";

/**
 * Score hook to manage score informations and color
 */
const useScore = (props) => {
  const [info, setInfo] = useState("");
  const [infoColor, setInfoColor] = useState("info");

  useEffect(() => {
    setInfoColor("info");
    if (props.isStarted) {
      if (props.hasQuestion) {
        setInfo("Goooooooooooo !");
      } else {
        setInfo(`Plus de question en stock...`);
      }
    } else if (props.looseScore > 0 || props.score > 0) {
      setInfo("Aller on se motive pour battre le record");
    } else {
      setInfo(
        `Le jeu dure ${config.GAME_TIMEOUT} secondes, à vos marques, prêt`
      );
    }
  }, [props.isStarted]);

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

  useEffect(() => {
    if (!props.hasQuestion) {
      setInfo(`Plus de question en stock...`);
      setInfoColor("warning");
    }
  }, [props.hasQuestion]);

  return [info, infoColor];
};

export default useScore;
