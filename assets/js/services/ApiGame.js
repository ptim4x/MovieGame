import axios from "axios";

axios.create({
  baseURL: "https://localhost",
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
      })
      .then((response) => ApiGame.convertData(response.data));

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
      })
      .then((response) => {
        return response.data;
      });
  };

  /**
   * Get a new question from back-end
   */
  static isRightAnswer = (reply, hash) => {
    ApiGame.postAnswer(reply, hash);

    return true;
  };

  /**
   * Convert data from back-end to front-end format
   * @param {*} dataBack data back format
   * @returns data front format
   */
  static convertData = (dataBack) => {
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
    };

    return dataFront;
  };

  // /**
  //  * Response list data test
  //  */
  // static responseList =
  //   // test data
  //   {
  //     "hash#1": false,
  //     "hash#2": true,
  //     "hash#3": false,
  //     // ...
  //   };

  // static shuffleArray = (array) =>
  //   array
  //     .map((a) => ({ sort: Math.random(), value: a }))
  //     .sort((a, b) => a.sort - b.sort)
  //     .map((a) => a.value);

  // // static getNewQuestion = () => {
  // //   ApiGame.questionList = ApiGame.shuffleArray(ApiGame.questionList);
  // //   return ApiGame.questionList[0];
  // // }

  // static isRightAnswer = (reply, hash) => {
  //   return ApiGame.responseList[hash] == reply;
  // }
}
