import { createI18n, type I18n, type I18nOptions } from "vue-i18n";
import { defu } from "defu";
// import { nextTick } from "vue";

/**
 * The cache of locale messages (to avoid fetching them multiple times)
 */
const messagesCache: Record<string, Record<string, string | object>> = {};

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

// TODO: Make this configurable
export const SUPPORTED_LOCALES = ["en-GB", "de-DE"];
export const FALLBACK_LOCALE = "en-GB";

await loadLocaleMessages({ locale: FALLBACK_LOCALE });
/**
 * Setup the i18n instance
 */
export function setupI18n(options: I18nOptions = {}) {
  const i18n = createI18n(
    defu(options, {
      locale: FALLBACK_LOCALE,
      fallbackLocale: FALLBACK_LOCALE,
      datetimeFormats: getDatetimeFormats(),
      numberFormats: getNumberFormats(),
      legacy: false,
      globalInjection: true,
    } as I18nOptions),
  );
  i18n.global.setLocaleMessage(FALLBACK_LOCALE, messagesCache[FALLBACK_LOCALE]);
  return i18n;
}

/**
 * Set i18n language
 */
export function setI18nLanguage({
  i18n,
  locale,
}: {
  i18n: I18n;
  locale: string;
}) {
  if (typeof i18n.global.locale === "string") {
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
  document.querySelector("html")?.setAttribute("lang", locale);
}

/**
 * Load locale messages
 */
export async function loadLocaleMessages({ locale }: { locale: string }) {
  const request = await fetch(`/translations/${locale}`);
  messagesCache[locale] = await request.json();
  // return nextTick();
}

// /**
//  * Set locale messages
//  */
// export async function setLocaleMessages({
//   i18n,
//   locale,
// }: {
//   i18n: I18n;
//   locale: string;
// }) {
//   if (locale in messagesCache) {
//     console.info(`Loaded locale messages for ${locale}`);
//     i18n.global.setLocaleMessage(locale, messagesCache);
//     setI18nLanguage({ i18n, locale });
//     return nextTick();
//     // return;
//   }

//   console.info(`Fetching locale messages for ${locale}`);

//   await loadLocaleMessages({ locale });

//   console.info(`Loaded locale messages for ${locale}`);
//   i18n.global.setLocaleMessage(locale, messagesCache[locale]);

//   setI18nLanguage({ i18n, locale });

//   return nextTick();
// }

export async function getLocaleMessages({ locale }: { locale: string }) {
  if (locale in messagesCache) {
    return messagesCache[locale];
  }

  console.info(`Fetching locale messages for ${locale}`);

  await loadLocaleMessages({ locale });

  console.info(`Loaded locale messages for ${locale}`);

  return messagesCache[locale];
}
