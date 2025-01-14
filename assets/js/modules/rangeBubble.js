/**
 * inicializacia bubliny nad range inputom
 */
export function initRangeBubble(rangeInput, rangeV) {
  let fadeTimeout;
  let clearTimeoutId;
  rangeInput.addEventListener("input", () =>
    setValue(rangeInput, rangeV, fadeTimeout, clearTimeoutId)
  );
  rangeInput.addEventListener("mouseup", () => handleMouseUp(rangeV));

  rangeInput.addEventListener("mousedown", () => {
    clearTimeout(fadeTimeout);
    clearTimeout(clearTimeoutId);
  });
}

// zobrazenie hodnoty
export function setValue(rangeInput, rangeV, fadeTimeout, clearTimeoutId) {
  const newValue = Number(
      ((rangeInput.value - rangeInput.min) * 100) /
        (rangeInput.max - rangeInput.min)
    ),
    newPosition = 10 - newValue * 0.2;
  rangeV.innerHTML = `<span>${rangeInput.value}</span>`;
  rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;
  rangeV.style.opacity = 1;
  clearTimeout(fadeTimeout);
  clearTimeout(clearTimeoutId);
}

//fadeout hodnoty
export function handleMouseUp(rangeV, fadeTimeout, clearTimeoutId) {
  fadeTimeout = setTimeout(() => {
    rangeV.style.opacity = 0;

    clearTimeoutId = setTimeout(() => {
      rangeV.innerHTML = "";
    }, 1000);
  }, 2000);
}
