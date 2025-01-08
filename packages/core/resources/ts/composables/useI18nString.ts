export default function () {
  return {
    isI18nString: (value: string) => {
      const test = /^[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+){1,}$/.test(value);
      return test;
    },
  };
}
