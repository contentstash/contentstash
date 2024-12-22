export default defineAppConfig({
  shadcnDocs: {
    site: {
      name: "ContentStash Docs",
      description:
        "A headless CMS ecosystem built with Laravel, Inertia.js, Vue 3, and Tailwind CSS.",
    },
    theme: {
      customizable: true,
      color: "zinc",
      radius: 0.5,
    },
    header: {
      title: "ContentStash Docs",
      showTitle: true,
      darkModeToggle: true,
      logo: {
        light: "/logo.svg",
        dark: "/logo-dark.svg",
      },
      nav: [
        {
          title: "Getting Started",
          to: "/getting-started",
          target: "_self",
        },
      ],
      links: [
        {
          icon: "lucide:github",
          to: "https://github.com/contentstash/contentstash",
          target: "_blank",
        },
      ],
    },
    aside: {
      useLevel: true,
      collapse: false,
    },
    main: {
      breadCrumb: true,
      showTitle: true,
      editLink: {
        enable: true,
        pattern:
          "https://github.com/contentstash/contentstash/edit/main/apps/docs/content/:path",
        text: "Edit this page on GitHub",
        icon: "lucide:square-pen",
        placement: ["docsFooter", "toc"],
      },
    },
    footer: {
      credits: "Copyright © 2024",
      links: [
        {
          icon: "lucide:github",
          to: "https://github.com/contentstash/contentstash",
          target: "_blank",
        },
      ],
    },
    toc: {
      enable: true,
      title: "On This Page",
      links: [
        {
          title: "Star on GitHub",
          icon: "lucide:star",
          to: "https://github.com/contentstash/contentstash",
          target: "_blank",
        },
        {
          title: "Create Issues",
          icon: "lucide:circle-dot",
          to: "https://github.com/contentstash/contentstash/issues",
          target: "_blank",
        },
      ],
    },
    search: {
      enable: true,
      inAside: false,
    },
  },
});
