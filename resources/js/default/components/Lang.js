
import { handleKeyEvents } from "../../traits/KeyEventHandlers";
import despatchCustomEvent from "../../traits/DespatchCustomEvent";
import { getBaseURL } from "../../traits/general";


/**
 * Sets the language preference in localStorage and updates the document's language class.
 * @param {string} language - The selected language code (e.g., 'Fr', 'En', 'Ar').
 */
const setLanguagePreference = (language) => {
    localStorage.setItem('language', language);
    document.documentElement.classList.toggle('arabic', language === 'Ar');
  };


/**
 * Toggles the language menu's visibility and updates ARIA attributes.
 * @param {HTMLElement} langBtn - The language button element.
 * @param {HTMLElement} langMenu - The language menu element.
 */
const toggleMenu = (langBtn, langMenu) => {
    const isOpen = langMenu.classList.toggle("open");
    langBtn.setAttribute("aria-expanded", isOpen);
    langMenu.setAttribute("aria-hidden", !isOpen);
  };

  /**
 * Renders a language item for the menu.
 * @param {Object} language - The language object.
 * @returns {string} - HTML string for the language item.
 */
const renderLanguageItem = (language) => {
    return `
      <li role="menuitem" class="lang__menu__item" tabindex="0">
        <div class="lang">
          <p>${language.lang}</p>
          <img src="${language.flag}" alt="${language.lang} language" />
        </div>
      </li>
    `;
  };

  /**
 * Populates the language menu with the remaining languages and updates the button.
 * @param {Array} initialLanguages - The array of language objects.
 * @param {string} selectedLang - The currently selected language.
 */
const populateLangMenu = (initialLanguages, selectedLang) => {
    const index = initialLanguages.findIndex(language => language.lang === selectedLang);
    const selectedLanguage = initialLanguages[index];

    const langMenus = document.querySelectorAll(".lang__menu");
    const langBtns = document.querySelectorAll(".lang__btn");

    const remainingLanguages = initialLanguages.filter(language => language.lang !== selectedLang);

    langBtns.forEach((langBtn) => {
      langBtn.innerHTML = `
        <div class="lang">
          <p>${selectedLanguage.lang}</p>
          <img src="${selectedLanguage.flag}" alt="${selectedLanguage.lang} language" />
        </div>
      `;
    });

    langMenus.forEach((langMenu) => {
      langMenu.innerHTML = remainingLanguages.map(renderLanguageItem).join("");
    });

    setLanguagePreference(selectedLang);
  };



  /**
 * Handles the language button click event.
 * @param {HTMLElement} langBtn - The language button element.
 * @param {HTMLElement} langMenu - The language menu element.
 */
const handleLangBtnClick = (langBtn, langMenu) => {
    toggleMenu(langBtn, langMenu);
    const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
    langMenuItems[0]?.focus(); // Focus on the first item when the menu opens
  };


/**
 * Selects a language and updates the UI.
 * @param {number} index - The index of the selected language.
 * @param {HTMLElement} langBtn - The language button element.
 * @param {HTMLElement} langMenu - The language menu element.
 * @param {Array} initialLanguages - The array of language objects.
 */
const selectLang = (index, langBtn, langMenu, initialLanguages) => {
    const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
    const selectedLang = langMenuItems[index]?.querySelector("p").textContent;
    populateLangMenu(initialLanguages, selectedLang);
    toggleMenu(langBtn, langMenu);
    langBtn.focus();
    despatchCustomEvent('set-locale', { lang: selectedLang });
  };


/**
 * Manages click and keydown events for the language menu.
 * @param {Event} event - The event object.
 * @param {HTMLElement} langBtn - The language button element.
 * @param {HTMLElement} langMenu - The language menu element.
 * @param {Array} initialLanguages - The array of language objects.
 */
const manageLangMenuOnClickOrKeyDownEvents = (event, langBtn, langMenu, initialLanguages) => {
    const langMenuItem = event.target.closest('.lang__menu__item');
    if (!langMenuItem) return;

    const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
    const index = langMenuItems.indexOf(langMenuItem);

    if (event.type === "keydown") {
      handleKeyEvents(event, index, () => selectLang(index, langBtn, langMenu, initialLanguages), langMenuItems);
    } else if (event.type === "click") {
      selectLang(index, langBtn, langMenu, initialLanguages);
    }
  };

/**
 * Initializes the language menu and attaches event listeners.
 * @param {HTMLElement} langMenuContainer - The container for the language menu.
 * @param {Array} initialLanguages - The array of language objects.
 */
const handleLangMenu = (langMenuContainer, initialLanguages) => {
    const langMenu = langMenuContainer.querySelector(".lang__menu");
    const langBtn = langMenuContainer.querySelector(".lang__btn");

    if (!langBtn || !langMenu) return;

    const selectedLang = localStorage.getItem('language') || 'Fr';
    populateLangMenu(initialLanguages, selectedLang);

    langBtn.addEventListener('click', () => handleLangBtnClick(langBtn, langMenu));

    langMenuContainer.addEventListener('keydown', (event) => {
      manageLangMenuOnClickOrKeyDownEvents(event, langBtn, langMenu, initialLanguages);
    });

    langMenuContainer.addEventListener('click', (event) => {
      manageLangMenuOnClickOrKeyDownEvents(event, langBtn, langMenu, initialLanguages);
    });
  };


const Lang = () => {
    const currentURL = window.location.href;

 const currentURLOrigin= getBaseURL(currentURL)
  const initialLanguages = [
    { lang: 'Fr', flag: `${currentURLOrigin}/img/fr.png` },
    { lang: 'En', flag: `${currentURLOrigin}/img/en.png` },
    { lang: 'Ar', flag: `${currentURLOrigin}/img/ar.png` },
  ];

  const langMenuContainers = document.querySelectorAll(".lang__menu__container");

  langMenuContainers.forEach(langMenuContainer => {
    handleLangMenu(langMenuContainer, initialLanguages);
  });
};

export default Lang;
