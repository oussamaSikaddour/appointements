





/**
 * Creates a loader element.
 * @returns {HTMLElement} - The loader element.
 */
const createLoader = () => {
  const loaderContainer = document.createElement('div');
  loaderContainer.className = 'loader__container';

  const loader = document.createElement('div');
  loader.className = 'loader l';

  const loaderCircle1 = document.createElement('div');
  loaderCircle1.className = 'loader__circle';

  const loaderCircle2 = document.createElement('div');
  loaderCircle2.className = 'loader__circle';

  loader.appendChild(loaderCircle1);
  loader.appendChild(loaderCircle2);
  loaderContainer.appendChild(loader);

  return loaderContainer;
};

/**
 * Handles hiding the loader and focusing on the first non-hidden input field.
 */
export const hideLoader = () => {
  const loaderContainer = document.querySelector('.loader__container');
  if (loaderContainer) {
    loaderContainer.classList.add('hide');
  }
};

/**
 * Initializes the loader component.
 */
export const Loader = () => {
  // Create and append the loader to the body
  const loaderContainer = createLoader();
  document.body.appendChild(loaderContainer);
};




