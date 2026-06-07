import { adjustElementPosition } from "../../traits/general";

// Function to show tooltip
const showTooltip = (tooltip) => {
  if (!tooltip) return; // Guard clause for missing tooltips
  tooltip.classList.add("show");
  adjustElementPosition(tooltip);
};

// Function to hide tooltip
const hideTooltip = (tooltip) => {
  if (!tooltip) return; // Guard clause for missing tooltips
  tooltip.classList.remove("show");
};

// Initialize tooltips on elements
const initializeTooltips = () => {
  const elements = document.querySelectorAll(".hasTooltip");
  elements.forEach((element) => {
    const tooltip = element.querySelector(".toolTip");

    // Ensure event listeners are added only once
    if (tooltip) {
      element.addEventListener("mouseenter", () => showTooltip(tooltip));
      element.addEventListener("mouseleave", () => hideTooltip(tooltip));
    }
  });
};

// Listen for the 'initialize-tooltips' event to trigger tooltip initialization
const ToolTip = () => {
  // Initial initialization when the page is loaded
  initializeTooltips();

  // Listen for the 'initialize-tooltips' event (for dynamic content loading)
  document.addEventListener("initialize-tooltips", () => {
    initializeTooltips();
  });

  // MutationObserver to handle dynamically added elements
//   const observer = new MutationObserver(() => {
//     initializeTooltips();
//   });

//   // Observe changes in the document body for added nodes
//   observer.observe(document.body, {
//     childList: true,
//     subtree: true,
//   });
};

export default ToolTip;
