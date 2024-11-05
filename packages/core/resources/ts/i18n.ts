import { createI18n } from "vue-i18n";
import { nextTick } from "vue";
import { defu } from "defu";

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

export function setupI18n(options = {}) {
  const i18n = createI18n(
    defu(options, {
      locale: "en-GB",
      fallbackLocale: "en-GB",
      datetimeFormats: getDatetimeFormats(),
      numberFormats: getNumberFormats(),
    }),
  );
  setI18nLanguage(i18n, options.locale);
  return i18n;
}

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

export async function loadLocaleMessages(i18n, locale) {
  // load locale messages with dynamic import
  console.info(locale);
  const messages = await import(
    `/vendor/contentstash/core/resources/ts/locales/${locale}/core.json`
  );

  console.info(messages);

  // set locale and locale message
  i18n.global.setLocaleMessage(locale, messages.default);

  return nextTick();
}
