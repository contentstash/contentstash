import { useMediaQuery } from "@vueuse/core";

export default function () {
  return {
    isDesktop: useMediaQuery("(min-width: 768px)"),
    isMobile: useMediaQuery("(max-width: 768px)"),
  };
}
