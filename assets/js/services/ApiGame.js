import axios from "axios";
import config from "../config.json";

axios.create({
  baseURL: config.GAME_API.BASE_URL,
  headers: {
    "Content-type": "application/json",
  },
});

/**
 * Service class to manage MovieGame API requests with back-end
 */
export default class ApiGame {
  /**
   * Get a new question from back-end
   */
  static getNewQuestion = async () =>
    await axios
      .get("/game/play")
      .then((response) => ApiGame.convertQuestionData(response.data))
      .catch(function (error) {
        if (error.response) {
          // Request made and server responded
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          // The request was made but no response was received
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log("Error", error.message);
        }
      });

  /**
   * Post the answer to the question
   */
  static postAnswer = async (reply, hash) => {
    // Api back is set with form-data parameter so...
    const formDataAnswer = new FormData();
    // Api Back only know right/wrong for answer form field value
    formDataAnswer.append("answer", reply ? "right" : "wrong");
    const config = {
      headers: { "Content-Type": "multipart/form-data" },
    };

    return await axios
      .post(`/game/play/${hash}`, formDataAnswer, config)
      .then((response) => response.data)
      .catch(function (error) {
        if (error.response) {
          // Request made and server responded
          console.log(error.response.data);
        } else if (error.request) {
          // The request was made but no response was received
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log("Error", error.message);
        }
      });
  };

  /**
   * Get a new question from back-end
   */
  static isRightAnswer = async (reply, hash) => {
    const gameResult = await ApiGame.postAnswer(reply, hash).then((result) => {
      return ApiGame.convertReplyData(result);
    });

    return gameResult;
  };

  /**
   * Convert Reply data from back-end to front-end format
   * @param {*} dataBack data back format
   * @returns it was a good answer ? boolean
   */
  static convertReplyData = (dataBack) => {
    if (!dataBack.result) {
      return null;
    }

    return dataBack.result == "win";
  };

  /**
   * Convert data from back-end to front-end format
   * @param {*} dataBack data back format
   * @returns data front format
   */
  static convertQuestionData = (dataBack) => {
    if (!dataBack.result) {
      return null;
    }

    const data = { ...dataBack.result };
    const dataFront = {
      hash: data.hash,
      actor: {
        title: data.actor.name,
        img: data.actor.picture,
      },
      movie: {
        title: data.movie.title,
        img: data.movie.picture,
      },
      complete: true,
    };

    return dataFront;
  };
}
