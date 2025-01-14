import { checkFormValidity, validationRules } from "./validation.js";

export function updateProgressBar(step, steps, progressBars) {
  const fields = steps[step].querySelectorAll(
    ".form-group input, .form-group select"
  );
  //spocitanie validnych poli v kroku
  let validCount = getValidCountInStep(fields);

  const percentage =
    fields.length > 0 ? Math.floor((validCount / fields.length) * 100) : 0;
  const progressBar = progressBars[step];
  //ak progressBar existuje zadefinuj percenta napr posledny krok bar nema
  if (progressBar) {
    progressBar.style.width = `${percentage}%`;
  }
  //pri zmene inputu validuj cely formular
  checkFormValidity(steps);
}

/**
 * vycistenie progressbarov po uspesnom submite formulara
 */
export function resetProgressBars() {
  const progressBars = document.querySelectorAll(".progress-bar");
  progressBars.forEach((bar) => {
    bar.style.width = "0%";
  });
}

function getValidCountInStep(fields) {
  let validCount = 0;
  fields.forEach((field) => {
    const fieldId = field.id;
    const isValid = validationRules[fieldId]
      ? validationRules[fieldId](field.value)
      : true;
    if (isValid) validCount++;
  });
  return validCount;
}
