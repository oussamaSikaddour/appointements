/**
 * Observes an element and triggers a callback when it enters or exits the viewport
 * based on a specified visibility percentage.
 *
 * @param {HTMLElement} element - The target element to observe.
 * @param {number} visibilityPercentage - The percentage of the element's visibility required to trigger the callback (0–100).
 * @param {Function} callback - The callback function to execute when visibility changes.
 * @param {object} [props={}] - Additional properties to pass to the callback.
 */
export const inView = (element, visibilityPercentage, callback, props = {}) => {
    if (!element || !(element instanceof HTMLElement)) return;

    const observerOptions = {
      threshold: visibilityPercentage / 100, // Convert percentage to decimal
    };

    const observer = new IntersectionObserver((entries) => {
      if (typeof callback === "function") {
        callback(entries[0]?.isIntersecting, props);
      }
    }, observerOptions);

    observer.observe(element);

    // Return a function to disconnect the observer if needed
    return () => observer.disconnect();
  };

  /**
   * Observes the last element in a list and triggers a callback when it enters the viewport,
   * commonly used for implementing infinite scrolling.
   *
   * @param {HTMLElement} lastElement - The target element to observe (typically the last element of a list).
   * @param {Function} callback - The callback function to execute when the element is in view.
   * @param {object} [props={}] - Additional properties to pass to the callback.
   * @returns {Function} - A function to disconnect the observer when it is no longer needed.
   */
  export const infiniteScroll = (lastElement, callback, props = {},rootMargin="50px") => {
    if (!lastElement || !(lastElement instanceof HTMLElement)) return;

    const observerOptions = {
      rootMargin // Adds a margin around the viewport for triggering earlier
    };

    const observer = new IntersectionObserver((entries) => {
      if (typeof callback === "function") {
        callback(entries[0]?.isIntersecting, { ...props, observer, lastElement });
      }
    }, observerOptions);

    observer.observe(lastElement);

    // Return a function to disconnect the observer when it is no longer needed
    return () => observer.disconnect();
  };








