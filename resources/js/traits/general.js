/**
 * Extracts the base URL (origin) from a given URL string.
 * @param {string} url - The full URL.
 * @returns {string} The base URL (protocol + hostname + port).
 */
export const getBaseURL = (url) => new URL(url).origin;

/**
 * Creates a debounced function that delays invoking `func` until after `wait` milliseconds.
 * @param {Function} func - The function to debounce.
 * @param {number} wait - The number of milliseconds to delay.
 * @returns {Function} The debounced function.
 */
export const debounce = (func, wait) => {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => func?.apply(this, args), wait);
  };
};

/**
 * Retrieves the computed background color of an element.
 * @param {HTMLElement} element - The DOM element.
 * @returns {string} The background color in RGB or RGBA format.
 */
export const getBackgroundColor = (element) => window.getComputedStyle(element).backgroundColor;

/**
 * Adjusts the horizontal position of an element to ensure it stays within the viewport.
 * @param {HTMLElement} element - The DOM element to adjust.
 */
export const adjustElementPosition = (element) => {
  const { left, right } = element.getBoundingClientRect();
  const { innerWidth } = window;
  const padding = 10; // 10px padding from the edge

  let translateX = 0;
  if (right > innerWidth) {
    translateX = innerWidth - right - padding;
  } else if (left < 0) {
    translateX = -left + padding;
  }

  element.style.transform = `translateX(${translateX}px)`;
};
