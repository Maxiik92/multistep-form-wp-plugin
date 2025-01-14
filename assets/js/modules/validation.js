export const validationRules = {
  name: (value) => value.trim().length > 0, //nie prazdna hodnota
  email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value), //regex na email
  country: (value) => value.trim().length > 0, //nie prazdna hodnota
  phone_number: () => iti.isValidNumber(), //iti je international.telephone input ktory ma vlastnu validaciu tel. cisla
  company: (value) => value.trim().length > 0, //nie prazdna hodnota
  address: (value) => value.trim().length > 0, //nie prazdna hodnota
  postal_code: (value) => /^[0-9]{4,10}$/.test(value), // minimalne 4 maximalne 10 cisel
  age: (value) => Number(value) > 0 && Number(value) <= 120, // hodnota viac ako 0 menej ako 120
  music_genre: (value) => value !== "Pick a genre", //nevybrata placeholder hodnota
  form_rank: (value) => Number(value) >= 1 && Number(value) <= 5, //vybrate cislo medzi 1 az 5
};

export function checkFormValidity(steps) {
  let isFormValid = true;
  steps.forEach((step) => {
    const fields = step.querySelectorAll(
      ".form-group input, .form-group select"
    );
    fields.forEach((field) => {
      const fieldId = field.id;
      const isValid = validationRules[fieldId]
        ? validationRules[fieldId](field.value)
        : true;
      if (!isValid) {
        isFormValid = false;
      }
    });
  });

  //ak formular nieje validny submit button disablovany
  const submitButton = document.querySelector('[data-trigger="submit"]');
  if (isFormValid) {
    submitButton.disabled = false;
  } else {
    submitButton.disabled = true;
  }
}
