export {};

declare global {
  function definePage(options: {
    layout?: string | false;
    [key: string]: unknown;
  }): void;
}
