export default class GameData {
  /**
   * Question list data test
   */
  static questionList = [
    {
      actor: {
        img: "https://img-4.linternaute.com/Ob0OnozNuR_Tqbe5n1IjESOAL4A=/1500x/smart/043a0cc33a254e7c90b725f992295bf8/ccmcms-linternaute/38001887.jpg",
        title: "Bourvil",
      },
      movie: {
        img: "https://resize-europe1.lanmedia.fr/img/var/europe1/storage/images/media/images/le-diner-de-cons/15796674-1-fre-FR/Le-diner-de-cons_reference.jpg",
        title: "Le dîner de cons",
      },
      hash: "hash#1",
    },
    {
      actor: {
        img: "https://resize.prod.femina.ladmedia.fr/rblr/652,438/img/var/2021-02/1612781536_natalie-portman.jpg",
        title: "Natalie Portman",
      },
      movie: {
        img: "https://resize-europe1.lanmedia.fr/img/var/europe1/storage/images/media/images/leon/15796682-1-fre-FR/Leon_reference.jpg",
        title: "Léon",
      },
      hash: "hash#2",
    },
    {
      actor: {
        img: "https://pbs.twimg.com/profile_images/1427890743276982272/X0SWZAvL_400x400.jpg",
        title: "Fred Testot",
      },
      movie: {
        img: "https://resize-europe1.lanmedia.fr/img/var/europe1/storage/images/media/images/intouchables/15796690-1-fre-FR/Intouchables_reference.jpg",
        title: "Intouchables",
      },
      hash: "hash#3",
    },
    // ...
  ];

  /**
   * Response list data test
   */
  static responseList =
    // test data
    {
      "hash#1": false,
      "hash#2": true,
      "hash#3": false,
      // ...
    };

  static questionGame = null;
  static index;

  static start() {
    const questionListCopy = [...GameData.questionList];
    GameData.questionGame = GameData.shuffleArray(questionListCopy);
    GameData.index = 0;
  }

  static shuffleArray = (array) =>
    array
      .map((a) => ({ sort: Math.random(), value: a }))
      .sort((a, b) => a.sort - b.sort)
      .map((a) => a.value);

  static getNextQuestion = () => GameData.questionGame[GameData.index++];

  static isRight(reply, hash) {
    return GameData.responseList[hash] == reply;
  }
}
