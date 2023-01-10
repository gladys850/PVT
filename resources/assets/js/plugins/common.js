export default {
  randomColor: function() {
    let colors = ['red', 'pink', 'purple', 'blue', 'light-blue', 'cyan', 'teal', 'green', 'light-green',  'amber', 'orange', 'deep-orange', 'deep-orange']
    return colors[Math.floor(Math.random() * colors.length)]
  },

  cleanSpace(text){
    if(text != null){
      if(text.trim() != '')
        return text
      else
        return null
    }else{
      return null
    }
  },

  removeAccents(text) {
    const sustitutions = {
      àáâãäå: "a",
      ÀÁÂÃÄÅ: "A",
      èéêë: "e",
      ÈÉÊË: "E",
      ìíîï: "i",
      ÌÍÎÏ: "I",
      òóôõö: "o",
      ÒÓÔÕÖ: "O",
      ùúûü: "u",
      ÙÚÛÜ: "U",
      ýÿ: "y",
      ÝŸ: "Y",
      ß: "ss",
      ñ: "n",
      Ñ: "N"
    };
    // Devuelve un valor si 'letter' esta incluido en la clave
    function getLetterReplacement(letter, replacements) {
      const findKey = Object.keys(replacements).reduce(
        (origin, item, index) => (item.includes(letter) ? item : origin),
        false
      );
      return findKey !== false ? replacements[findKey] : letter;
    }
    // Recorre letra por letra en busca de una sustitución
    return text
      .split("")
      .map((letter) => getLetterReplacement(letter, sustitutions))
      .join("");
  }
}