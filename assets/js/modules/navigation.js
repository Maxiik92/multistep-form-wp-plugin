/**
 * posun krok formulara
 * targetStep je zadefinovany len pri prekliknuti cez "kruhy" inac je null
 * */
export function moveStep(direction, currentActive, targetStep = null) {
  //ak nieje zadefinovany targetStep a bola funkcia spustena inac ako renderovanymi buttonmi
  if (
    targetStep === null &&
    direction &&
    !["previous", "next"].includes(direction)
  ) {
    console.error("Invalid direction:", direction);
    return;
  }

  const currentStep = Number(currentActive.getAttribute("data-step"));
  const totalSteps = document.querySelectorAll(
    "#multistep-form .form-step"
  ).length;
  //deaktivuj aktualny krok formulara
  currentActive.classList.remove("active");
  const nextStep = getNextStep(direction, currentActive, targetStep);

  //zmen tlacidla
  toggleButtonVisibility(".buttons .prev-step", nextStep > 1);
  toggleButtonVisibility(".buttons .next-step", nextStep < totalSteps);
  toggleButtonVisibility(".buttons .submit-form", nextStep == totalSteps);

  //posun progressbar
  const progSteps = document.querySelectorAll(
    ".progress-wrapper .progress-step"
  );
  progSteps[currentStep - 1].firstElementChild.classList.remove("active");
  progSteps[nextStep - 1].firstElementChild.classList.add("active");
}

export function toggleButtonVisibility(selector, shouldBeVisible) {
  const button = document.querySelector(selector);
  button.classList.toggle("hidden", !shouldBeVisible);
}

/**
 * inicializacia event listenerov pre preklikavanie kruhov v progressbare
 */
export function initProgressBarCircles() {
  const progressBarCircles = document.querySelectorAll(
    "#progress-container .progress-step .circle"
  );

  progressBarCircles.forEach((circle) => {
    circle.addEventListener("click", () => {
      const currentActive = document.querySelector(
        "#multistep-form .form-step.active"
      );
      const step = Number(circle.innerText);
      moveStep(null, currentActive, step);
    });
  });
}

/**
 * zozen dalsi krok formulara na zaklade tlacidla alebo targetStep premennej
 */
function getNextStep(direction, currentActive, targetStep) {
  if (targetStep !== null && isValidStep(targetStep)) {
    const form = document.querySelector(
      `#multistep-form .form-step[data-step="${targetStep}"]`
    );
    form.classList.add("active");
    return targetStep;
  } else {
    const currentStep = Number(currentActive.getAttribute("data-step"));
    switch (direction) {
      case "previous":
        currentActive.previousElementSibling.classList.add("active");
        return currentStep - 1;
      case "next":
        currentActive.nextElementSibling.classList.add("active");
        return currentStep + 1;
      default:
        return currentStep;
    }
  }
}

/**
 * kontrola vybraneho kroku ci nieje mimo dostupnych
 */
function isValidStep(targetStep) {
  const totalSteps = document.querySelectorAll(
    "#multistep-form .form-step"
  ).length;
  if (targetStep >= 1 && targetStep <= totalSteps) {
    return true;
  }
  return false;
}
