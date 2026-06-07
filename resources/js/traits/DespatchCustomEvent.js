/**
 * Dispatches a custom event with the specified name and optional data payload.
 *
 * @param {string} eventName - The name of the custom event to dispatch.
 * @param {object} data - Optional data to include in the event's detail.
 */
export const despatchCustomEvent = (eventName, data = {}) => {
    if (typeof eventName !== "string" || !eventName.trim()) {
      console.warn("Invalid event name provided. Ensure the event name is a non-empty string.");
      return;
    }

    // Create and dispatch the custom event
    const customEvent = new CustomEvent(eventName, {
      detail: { data },
    });
    document.dispatchEvent(customEvent);
  };

  export default despatchCustomEvent;
