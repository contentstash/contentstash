import { createI18n } from "vue-i18n";
import { defu } from "defu";
import { nextTick } from "vue";

/**
 * Get datetime formats
 */
const getDatetimeFormats = () => {
  return {
    "en-GB": {
      short: {
        year: "numeric",
        month: "short",
        day: "numeric",
      },
      long: {
        year: "numeric",
        month: "short",
        day: "numeric",
        weekday: "short",
        hour: "numeric",
        minute: "numeric",
      },
    },
    "de-DE": {
      short: {
        year: "numeric",
        month: "short",
        day: "numeric",
      },
      long: {
        year: "numeric",
        month: "short",
        day: "numeric",
        weekday: "short",
        hour: "numeric",
        minute: "numeric",
      },
    },
  };
};

/**
 * Get number formats
 */
const getNumberFormats = () => {
  return {
    "en-GB": {
      currency: {
        style: "currency",
        currency: "GBP",
      },
    },
    "de-DE": {
      currency: {
        style: "currency",
        currency: "EUR",
      },
    },
  };
};

export const SUPPORT_LOCALES = ["en-GB", "de-DE"];

/**
 * Setup the i18n instance
 */
export function setupI18n(options = {}) {
  const i18n = createI18n(
    defu(options, {
      locale: "en-GB",
      fallbackLocale: "en-GB",
      datetimeFormats: getDatetimeFormats(),
      numberFormats: getNumberFormats(),
      legacy: false,
      globalInjection: true,
    }),
  );
  setI18nLanguage(i18n, options.locale);
  return i18n;
}

/**
 * Set i18n language
 */
export function setI18nLanguage(i18n, locale) {
  if (i18n.mode === "legacy") {
    i18n.global.locale = locale;
  } else {
    i18n.global.locale.value = locale;
  }
  /**
   * NOTE:
   * If you need to specify the language setting for headers, such as the `fetch` API, set it here.
   * The following is an example for axios.
   *
   * axios.defaults.headers.common['Accept-Language'] = locale
   */
  document.querySelector("html").setAttribute("lang", locale);
}

/**
 * The cache of locale messages (to avoid fetching them multiple times)
 */
const messagesCache: Record<string, Record<string, string | object>> = {};

/**
 * Load locale messages
 */
export async function loadLocaleMessages(i18n, locale) {
  const request = await fetch(`/translations/${locale}`);
  messagesCache[locale] = await request.json();
  return nextTick();
}

/**
 * Set locale messages
 */
export async function setLocaleMessages(i18n, locale) {
  if (locale in messagesCache) {
    i18n.global.setLocaleMessage(locale, messagesCache[locale]);
    return nextTick();
  }

  await loadLocaleMessages(i18n, locale);

  i18n.global.setLocaleMessage(locale, messagesCache[locale]);

  return nextTick();
}
