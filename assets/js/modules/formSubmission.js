import { resetProgressBars } from "./progressBar.js";
import { moveStep } from "./navigation.js";

export function submitForm(form, submitButton) {
  const formData = new FormData(form);
  //formatovane telefonne cislo s predvolbou
  const phoneNumber = iti.getNumber();
  formData.set("phone_number", phoneNumber);
  formData.append("action", "submit_multistep_form"); //akcia potrebna na trigger funkcie vo form.php
  submitButton.disabled = true; //prevencia voci multi submitu

  fetch(multistepFormAjax.ajax_url, {
    method: "POST",
    body: formData,
    headers: {
      Accept: "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        resetForm(form);
        alert("Form submitted successfully!");
      } else {
        alert("Form submission failed:" + data.data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("There was an error with the form submission. Check the console.");
    })
    .finally(() => {
      submitButton.disabled = false;
    });
}

export function resetForm(form) {
  form.reset();
  moveStep("", document.querySelector("#multistep-form .form-step.active"), 1);
  resetProgressBars();
}
