import { moveStep, initProgressBarCircles } from "./modules/navigation.js";
import { updateProgressBar } from "./modules/progressBar.js";
import { submitForm } from "./modules/formSubmission.js";
import { initRangeBubble } from "./modules/rangeBubble.js";
import { validationRules } from "./modules/validation.js";

document.addEventListener("DOMContentLoaded", () => {
  const progressButtons = document.querySelectorAll(".buttons .custom-btn");
  const submitButton = document.querySelector('[data-trigger="submit"]');
  const steps = document.querySelectorAll(".form-step");
  const progressBars = document.querySelectorAll(".progress-bar");
  const form = document.querySelector("#multistep-form");
  const rangeInput = document.getElementById("form_rank");
  const rangeV = document.getElementById("rangeV");

  //preklikavania krokov cez tlacidla
  progressButtons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const target = e.target;
      const currentActive = document.querySelector(
        "#multistep-form .form-step.active"
      );
      const trigger = target.getAttribute("data-trigger");
      switch (trigger) {
        case "previous":
        case "next":
          moveStep(trigger, currentActive);
          break;
        case "submit":
          submitForm(form, submitButton);
          break;
      }
    });
  });

  //preklikavanie pomocou kruhov v progress bare
  initProgressBarCircles();

  //pri range inpute zobrazenie value nad posuvnikom
  if (rangeInput) {
    initRangeBubble(rangeInput, rangeV);
  }

  //validacia formulara a update progress baru
  document
    .querySelectorAll("#multistep-form input, #multistep-form select")
    .forEach((input) => {
      input.addEventListener("input", function () {
        const step = parseInt(this.closest(".form-step").dataset.step) - 1;
        const fieldId = this.id;
        const isValid = validationRules[fieldId]
          ? validationRules[fieldId](this.value)
          : true;

        if (!isValid) {
          this.classList.toggle("invalid", true);
        } else {
          this.classList.toggle("invalid", false);
        }

        updateProgressBar(step, steps, progressBars);
      });
    });
});
