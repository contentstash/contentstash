export default defineAppConfig({
  shadcnDocs: {
    site: {
      name: "ContentStash Docs",
      description:
        "A headless CMS ecosystem built with Laravel, Inertia.js, Vue 3, and Tailwind CSS.",
    },
    theme: {
      customizable: false,
      color: "stone",
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
          title: "Docs",
          links: [
            {
              title: "Getting Started",
              description: "Learn how to get started with ContentStash.",
              icon: "lucide:rocket",
              to: "/getting-started",
            },
            {
              title: "Guides",
              description:
                "Learn how to build, deploy and extend a ContentStash application.",
              icon: "lucide:book-open",
              to: "/guide",
            },
            {
              title: "API",
              description: "Learn how to use the ContentStash API.",
              icon: "lucide:code-xml",
              to: "/api",
            },
          ],
        },
      ],
      links: [
        {
          icon: "simple-icons:github",
          to: "https://github.com/contentstash/contentstash",
          target: "_blank",
        },
        {
          icon: "simple-icons:discord",
          to: "https://discord.gg/92nzCyWwsS",
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
      codeIcon: {
        composer: "vscode-icons:file-type-composer",
      },
      showTitle: true,
      editLink: {
        enable: true,
        pattern:
          "https://github.com/contentstash/contentstash/edit/main/apps/docs/content/:path",
        text: "Edit this page on GitHub",
        icon: "lucide:square-pen",
        placement: ["docsFooter", "toc"],
      },
      pm: ["pnpm"],
    },
    footer: {
      credits: "Copyright © 2024",
      links: [
        {
          icon: "simple-icons:github",
          to: "https://github.com/contentstash/contentstash",
          target: "_blank",
        },
        {
          icon: "simple-icons:discord",
          to: "https://discord.gg/92nzCyWwsS",
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
